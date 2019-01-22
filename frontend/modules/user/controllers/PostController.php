<?php

namespace user\controllers;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\filters\AccessControl;

use common\models\User;
use common\util\Response;
use common\util\Flags;
use common\services\DataService;
use common\widgets\modalBox\ModalBox;

use frontend\controllers\RaBaseController;
use frontend\models\Profile;
use frontend\modules\album\models\Album;

use user\models\Relationship;
use user\models\Post;
use user\models\Comment;
use user\models\PostComment;
use user\models\Notification;
use user\models\NotificationType;
use user\models\PostFollow;
use user\models\PostLike;
use user\models\CommentLike;
use user\services\SocialService;
use user\services\NotificationService;
use user\services\PostDataService;

use searcher\services\Searcher;
use searcher\services\PostFilter;

class PostController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['post',
                                  'view',
                                  'wall',
                                  'comment',
                                  'reply-comment',
                                  'like-post',
                                  'like-comment',
                                  'check-new-comments',
                                  'check-likes',
                                  'prev-comments',
                                  'remove-post',
                                  'remove-comment',
                                  ],
                    'allow' => true,
                    'roles' => ['listener', 'artist'],
                ],
          ],
      ],
    ];
  }

  protected function setUserFollowPost($id_profile, $id_post){
    // PostFollow almacena claves (profile_id, post_id) para indicar que ese
    // perfil sigue a ese post

    $postFollow = PostFollow::find()->where(['id_profile' => $id_profile, 'id_post' => $id_post])->one();

    if (!$postFollow){
      $postFollow = new PostFollow();
      $postFollow->id_profile = (string) $id_profile;
      $postFollow->id_post = $id_post;
      return $postFollow->save();
    }
    return true;
  }

  protected function getCountResult($array, $id, $table){
    for ($i=0; $i < count($array); $i++) {
      if ($array[$i][$table.'_id'] == $id)
        return $array[$i]['count'];
    }
    return 0;
  }

  public function actionPost(){
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $posted = Yii::$app->request->post('Post');

    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    if (isset($posted) && !empty($posted)){
      $post = new Post();
      $post->id = 0;
      $post->profile_id = $me->id;
      $post->visibility_id = $posted['visibility'];
      $post->content = $posted['content'];
      $post->created_at = (string)time();
      $post->updated_at = $post->created_at;
      if (!empty($posted['album']))
        $post->album_id = $posted['album'];

      if ($post->save())
        return Response::getInstance(true, Flags::ALL_OK)->jsonEncode();
    }
    return Response::getInstance($post->errors, Flags::ERROR)->jsonEncode();
  }

  public function actionRemovePost(){
    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    if (Yii::$app->request->isPost){
      $toRemove = Yii::$app->request->post('Post');

      if ( !(isset($toRemove) && !empty($toRemove)) )
        return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

      $post = Post::findOne($toRemove['id']);
      $transaction = Post::getDb()->beginTransaction();
      try {
          $comments = $post->comments;
          foreach ($comments as $key => $comment) {
            $comment->unlinkAll('commentLikes', true);
          }
          $post->unlinkAll('comments', true);
          $post->unlinkAll('postLikes', true);
          PostFollow::deleteAll(['id_post' => $post->id]);

          if ($post->delete()){
            $transaction->commit();
            return Response::getInstance(['block' => $toRemove['id'], 'type' => 'post', 'message' => Yii::t('app', 'successDeletePost')], Flags::DELETE_SUCCESS)->jsonEncode();
          }
          else{
            $transaction->rollBack();
            return Response::getInstance(['error' => \Yii::t('app', 'errorDeletePost')], Flags::DELETE_ERROR)->jsonEncode();
          }
      } catch (\Exception $e) {
        $transaction->rollBack();
        return Response::getInstance(['error' => $e->getMessage()], Flags::DELETE_ERROR)->jsonEncode();
      }
    } else{
      $toRemove = Yii::$app->request->get('id');

      if ( !(isset($toRemove) && is_numeric($toRemove)) )
        return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

      $post = Post::findOne($toRemove);

      $title = Yii::t('app', 'deletePost');
      $content = $this->renderSection('delete_confirmation', ['post' => $post]);
      return ModalBox::widget(['title' => $title, 'content' => $content]);
    }
  }

  public function actionView(){

    /*
     * ES NECESARIO CHEQUEAR QUE EL USUARIO TIENE LOS PERMISOS PARA VER EL POST
     */
    $id = Yii::$app->request->get('id');
    if (isset($id) && is_numeric($id) && Yii::$app->user->can('postExplore',['post_id' => $id])){
      $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
      $post = Post::find()->where(['id' => $id])->with(['profile', 'album.artists', 'postLikes'])->all();
      $post = Comment::fillPosts($post);
      return $this->renderSection('post', ['me' => $me, 'content' => $post, 'shareable'=> false]);
    } else {
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);
    }
  }

  public function actionWall(){
    $me = User::getModelExtended(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;

    $followedArr = [];
    $who = Yii::$app->request->get('w');
    if ($who === SocialService::LOGGED_USER){
        $myPosts = true;
        $query = Post::findMyPosts($me->id);
    } else{
        $myPosts = false;
        $relationships = Relationship::findFollowedUsersRelationship($me->id)->all();
        foreach ($relationships as $key => $relationship) {
            $followedArr [] = ($me->id == $relationship->profile_one_id) ? $relationship->profile_two_id : $relationship->profile_one_id;
        }
        $query = Post::findExtended($followedArr, $me->id);
    }
    $service = new DataService();
    $service->setQuery($query);

    $segment = Yii::$app->request->get('segment');
    if (!isset($segment)){
        $rows = $service->getData();
        $rows = Comment::fillPosts($rows);

        $visible = ($service->isLastPage()) ? false : true;
        $route = ($who === SocialService::LOGGED_USER) ? ['/user/post/wall', 'w' => SocialService::LOGGED_USER, 'segment' => 1] : ['/user/post/wall', 'segment' => 1];
        $lazyRoute = Url::to($route);

        return $this->renderSection('wall', ['me' => $me, 'content' => $rows, 'component' => 'wall', 'shareable'=> true, 'myPosts' => $myPosts, 'lazyLoad' => ['route' => $lazyRoute,'visible' => $visible]]);
    } else{
        $rows = $service->getData($segment);
        $rows = Comment::fillPosts($rows);
        $segment = $segment + 1;

        $response['status'] =  $service->isLastPage();
        $route = ($who === SocialService::LOGGED_USER) ? ['/user/post/wall', 'w' => SocialService::LOGGED_USER , 'segment' => $segment] : ['/user/post/wall', 'segment' => $segment];
        $response['route'] = Url::to($route);
        $response['content'] = $this->renderSection('wall', ['me' => $me, 'content' => $rows, 'component' => 'wall_partial', 'shareable' => true]);
        return Response::getInstance($response, Flags::ALL_OK)->jsonEncode();
    }
  }

  public function actionComment(){
    $req = Yii::$app->request->post('Post');

    if ( !(Yii::$app->request->isAjax && isset($req) && !empty($req) && isset($req['uid_entity']) && isset($req['uid_propietor'])) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $post = Post::findOne($req['uid_entity']);
    $postOwner = $req['uid_propietor'];
    if (isset($req['comment']) && $post){

      $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;

      //Creamos el comentario
      $comment = new Comment();
      $comment->id = 0;
      $comment->content = $req['comment'];
      $comment->profile_id = (string) $me->id;
      $comment->created_at = (string) time();
      $comment->updated_at  = $comment->created_at;
      $comment->post_id = $post->id;

      $transaction = Comment::getDb()->beginTransaction();

      // Si no puede guardar vuelve atras la transacción y retorna los errores;
      if (!$comment->save()){
        $transaction->rollBack();
        return Response::getInstance($comment->errors, Flags::COMMENT_SAVE_ERROR)->jsonEncode();
      }

      // return contiene la respueta que se va a se va a renderizar y el id del post asociado
      $return['body'] =  $this->renderSection('wall', ['me' => $me, 'component' => 'comment', 'content' => $comment, 'shareable' => false, 'reply_to' => $post->id]);
      $return['id'] =  $post->id;

      // Este if abarca el caso de que yo responda posts que no son mios
      // se evita almacenarme como seguidor de mi propio post
      if ($me->id != $postOwner){

        // Si no estoy como seguidor del post, me agrego.
        $postFollow = $this->setUserFollowPost($me->id, $post->id);
        if (!$postFollow){
          $transaction->rollBack();
          return Response::getInstance($postFollow->errors, Flags::POST_FOLLOW_SAVE_ERROR)->jsonEncode();
        }

        // Creo la notificación para el owner de la publicaciónn
        $notification = NotificationService::buildNotification($me->id, $postOwner, 'post_comment', ['pid' => $post->id]);
        if (!$notification->save()){
          $transaction->rollBack();
          return Response::getInstance($notification->errors, Flags::NOTIFICACTION_SAVE_ERROR)->jsonEncode();
        }
        $result = Profile::resetNotificationCheck($postOwner);
      }

      $notifList = NotificationService::createNotificationListByPostComment($post->id, $me->id);

      if ($notifList !== 0){

        $transaction->commit();
        return Response::getInstance($return, Flags::SAVE_SUCCESS)->jsonEncode();
      } else{
        $transaction->rollBack();
        return Response::getInstance($notifList, Flags::NOTIFICACTION_SAVE_ERROR)->jsonEncode();
      }
    } else{
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);
    }

  }

  public function actionRemoveComment(){
    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    if (Yii::$app->request->isPost){
      $toRemove = Yii::$app->request->post('Comment');

      if ( !(isset($toRemove) && !empty($toRemove) && is_numeric($toRemove['id'])) )
        return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

      $comment = Comment::findOne($toRemove['id']);

      $transaction = Comment::getDb()->beginTransaction();
      try {
          $comment->unlinkAll('commentLikes', true);

          if ($comment->delete()){
            $transaction->commit();
            return Response::getInstance(['block' => $toRemove['id'], 'type'=> 'comment', 'message' => Yii::t('app', 'successDeleteComment')], Flags::DELETE_SUCCESS)->jsonEncode();
          }
          else{
            $transaction->rollBack();
            return Response::getInstance(['error' => \Yii::t('app', 'errorDeleteComment')], Flags::DELETE_ERROR)->jsonEncode();
          }
      } catch (\Exception $e) {
        $transaction->rollBack();
        return Response::getInstance(['error' => $e->getMessage()], Flags::DELETE_ERROR)->jsonEncode();
      }
    } else{
      $toRemove = Yii::$app->request->get('id');
      if ( !(isset($toRemove) && is_numeric($toRemove)) )
        return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

      $comment = Comment::findOne($toRemove);

      $title = Yii::t('app', 'deleteComment');
      $content = $this->renderSection('delete_confirmation', ['comment' => $comment]);
      return ModalBox::widget(['title' => $title, 'content' => $content]);
    }
  }

  public function actionReplyComment(){
    $req = Yii::$app->request->post('Post');

    if ( !(Yii::$app->request->isAjax && isset($req) && !empty($req) && isset($req['uid_entity']) && isset($req['uid_propietor'])) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $post = Post::findOne($req['uid_entity']);
    $commentOwner = $req['uid_propietor'];

    $transaction = Comment::getDb()->beginTransaction();
    if (isset($req['comment']) && $post){
      $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;

      //Creamos el comentario
      $comment = new Comment();
      $comment->id = 0;
      $comment->profile_id = (string) $me->id;
      $comment->created_at = (string) time();
      $comment->updated_at  = $comment->created_at;
      $comment->post_id = $post->id;

      // Si el usuario se responde un comentario propio
      if ($me->id == $commentOwner){
          $comment->content = $req['comment'];
      } else{
        // Se crea el comentario personalizado (se agrega enlace con nombre)
        $model = Profile::find()->with(['listeners', 'artists'])->where(['id' => $commentOwner])->one();
        if (isset($model->artists))
          foreach ($model->artists as $artist)
            $url = Url::to(['/artist/artist/view', 'id' => $artist->id]);

        if (isset($model->listeners))
          foreach ($model->listeners as $listener)
            $url = Url::to(['/listener/listener/view', 'id' => $listener->id]);

        $aTag = Html::a($model->name, $url, ['data-action' => 'nav', 'class' => 'comment-reply-profile']);
        $comment->content = $aTag. " ". $req['comment'];

        // Se crea notificacion para el Owner del comentario
        $notifToCommentOwner = NotificationService::buildNotification($me ->id, $commentOwner, 'comment_comment', ['pid' => $post->id]);
        if (!$notifToCommentOwner->save()){
          $transaction->rollBack();
          return Response::getInstance($notifToCommentOwner->errors, Flags::NOTIFICACTION_SAVE_ERROR)->jsonEncode();
        }
        // Se reseta el indicador de notificaciones del Owner del comentario
        Profile::resetNotificationCheck($commentOwner);
      }

      // recupero el id del creador del post desde el comentario creado
      $postOwner = $comment->post->profile;

      //Si el user que responde el comentario NO ES el Owner del Post
      if ($me->id != $postOwner->id){

        // Si el user que responde no es seguidor del post se lo agrega.
        $postFollow = $this->setUserFollowPost($me->id, $post->id);
        if (!$postFollow){
          $transaction->rollBack();
          return Response::getInstance($postFollow->errors, Flags::POST_FOLLOW_SAVE_ERROR)->jsonEncode();
        }

        //chequeo que el owner del post no sea el mismo que el del comment
        if ($postOwner->id != $commentOwner){
          // Se crea la notificación para el owner del post
          $notifToPostOwner = NotificationService::buildNotification($me->id, $postOwner->id, 'post_comment', ['pid' => $post->id]);
          if (!$notifToPostOwner->save()){
            $transaction->rollBack();
            return Response::getInstance($notifToPostOwner->errors, Flags::NOTIFICACTION_SAVE_ERROR)->jsonEncode();
          }
          //Se resetea el indicador de notificaciones del Owner del Post.
          Profile::resetNotificationCheck($postOwner->id);
        }
      }

      // Finalmente se guarda el comentario
      if (!$comment->save()){
        $transaction->rollBack();
        return Response::getInstance($comment->errors, Flags::COMMENT_SAVE_ERROR)->jsonEncode();
      }

      $transaction->commit();
      //throw new \Exception("Error Processing Request ". $post->id, 1);

      $return['body'] =  $this->renderSection('wall', ['me' => $me, 'component' => 'comment', 'content' => $comment, 'shareable' => false, 'reply_to' =>  $post->id]);
      $return['id'] =  $post->id;
      return Response::getInstance($return, Flags::SAVE_SUCCESS)->jsonEncode();
    } else{
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);
    }
  }

  public function actionLikeComment(){
    $post = Yii::$app->request->post('Post');

    if ( !(Yii::$app->request->isAjax && isset($post) && !empty($post) && isset($post['uid_like']) && isset($post['uid_post']) && isset($post['uid_propietor'])) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $commentID = $post['uid_like'];
    $postID = $post['uid_post'];
    $commentOwnerID = $post['uid_propietor'];

    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $commentLike = CommentLike::find()->where(['profile_id' => $me->id, 'comment_id' => $commentID])->one();

    if (!$commentLike){
      $commentLike = new CommentLike();
      $commentLike->created_at = (string) time();
      $commentLike->profile_id = $me->id;
      $commentLike->comment_id = $commentID;

      $transaction = CommentLike::getDb()->beginTransaction();
      if (!$commentLike->save()){
        $transaction->rollBack();
        return Response::getInstance($commentLike->errors, Flags::SAVE_ERROR)->jsonEncode();
      }

      /*
       * Armo las notificaciones correspondiente *****************************************************
       */
      $storedPost = Post::find()->where(['id' => $postID])->with(['profile'])->one();

      // COMMENT OWNER: Si el usuario que megustea no es el owner del comment
      if ($me->id != $commentOwnerID){
        $notifToCommentOwner = NotificationService::buildNotification($me->id, $commentOwnerID, 'like_comment', ['pid' => $storedPost->id, 'cid' => $commentID]);
        if (!$notifToCommentOwner->save()){
          $transaction->rollBack();
          return Response::getInstance($notifToCommentOwner->errors, Flags::NOTIFICACTION_SAVE_ERROR)->jsonEncode();
        }
        Profile::resetNotificationCheck($commentOwnerID);
      }

      // POST OWNER: Si el usuario que megustea no es el owner del post
      if ($me->id != $storedPost->profile->id && $commentOwnerID != $storedPost->profile->id){
        $notifToPostOwner = NotificationService::buildNotification($me->id, $storedPost->profile->id, 'like_comment_post', ['pid' => $storedPost->id, 'cid' => $commentID]);
        if (!$notifToPostOwner->save()){
          $transaction->rollBack();
          return Response::getInstance($notifToPostOwner->errors, Flags::NOTIFICACTION_SAVE_ERROR)->jsonEncode();
        }
        Profile::resetNotificationCheck($storedPost->profile->id);
      }

      $transaction->commit();
      return Response::getInstance(['uid_entity' => $commentID], Flags::SAVE_SUCCESS)->jsonEncode();
    } else {
      if ($commentLike->delete() !== false)
        return Response::getInstance(['uid_entity' => $commentID], Flags::DELETE_SUCCESS)->jsonEncode();

      return Response::getInstance($commentLike->errors, Flags::DELETE_ERROR)->jsonEncode();
    }

  }

  public function actionLikePost(){
    $post = Yii::$app->request->post('Post');

    if ( !(Yii::$app->request->isAjax && isset($post) && !empty($post) && isset($post['uid_like']) && isset($post['uid_propietor'])) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $postID = $post['uid_like'];
    $postOwnerID = $post['uid_propietor'];

    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $postLike = PostLike::find()->where(['profile_id' => $me->id, 'post_id' => $postID])->one();

    if (!$postLike){
      $postLike = new PostLike();
      $postLike->created_at = (string) time();
      $postLike->profile_id = $me->id;
      $postLike->post_id = $postID;


      $transaction = PostLike::getDb()->beginTransaction();
      if (!$postLike->save()){
        $transaction->rollBack();
        return Response::getInstance($postLike->errors, Flags::SAVE_ERROR)->jsonEncode();
      }

      /*
       * Armo las notificaciones correspondientes *****************************************************
       */

      // POST OWNER: Si el usuario que megustea no es el owner del comment
      if ($me->id != $postOwnerID){
        $notifToPostOwner = NotificationService::buildNotification($me->id, $postOwnerID, 'like_post', ['pid' => $postID]);
        if (!$notifToPostOwner->save()){
          $transaction->rollBack();
          return Response::getInstance($notifToPostOwner->errors, Flags::NOTIFICACTION_SAVE_ERROR)->jsonEncode();
        }
        Profile::resetNotificationCheck($postOwnerID);
      }

      $transaction->commit();
      return Response::getInstance(['uid_entity' => $postID], Flags::SAVE_SUCCESS)->jsonEncode();
    } else {
      if ($postLike->delete())
        return Response::getInstance(['uid_entity' => $postID], Flags::DELETE_SUCCESS)->jsonEncode();

      return Response::getInstance($postLike->errors, Flags::DELETE_ERROR)->jsonEncode();
    }
  }

  public function actionCheckNewComments(){
    $params = Yii::$app->request->post('params');


    if ( Yii::$app->request->isAjax && isset($params) && !empty($params) ){
      $t = 0;
      foreach ($params as $key => $comment_id) {
        if ($t == 0)
          $comments = Comment::find()->where(['and', 'post_id='.$key, 'id>'.$comment_id ]);
        else
          $comments = $comments->orWhere(['and', 'post_id='.$key, 'id>'.$comment_id]);
        $t++;
      }
      $result = $comments->all();
      $return = [];
      foreach ($result as $key => $comment) {
        $return[] =  ['post_id' => $comment->post_id, 'count'=> count($result), 'body' => $this->renderSection('wall', ['component' => 'comment', 'content' => $comment, 'shareable' => false, 'reply_to' => $comment->post_id])];
      }
      if (!$return)
        return Response::getInstance(null, Flags::ALL_OK)->jsonEncode();

      return Response::getInstance($return, Flags::ALL_OK)->jsonEncode();
    } else
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

  }

  public function actionCheckLikes(){
    $posts = Yii::$app->request->post('params');

    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    if (isset($posts)){
      $array = [];
      $arrPosts = [];
      foreach ($posts as $post => $comments) {
        $array = array_merge($array, $comments);
        $arrPosts[] = $post;
      }
      $commentLikes = (new Query())->select(['comment_id', 'count(id) as count'])
                                   ->from('comment_like')
                                   ->where(['in', 'comment_id', $array])
                                   ->groupBy('comment_id')
                                   ->all();

      $postLikes = (new Query())->select(['post_id', 'count(id) as count'])
                                   ->from('post_like')
                                   ->where(['in', 'post_id', $arrPosts])
                                   ->groupBy('post_id')
                                   ->all();

      $postResult = [];
      foreach ($arrPosts as $postId)
        $postResult[] = ['post_id' => $postId, 'count' => $this->getCountResult($postLikes, $postId, 'post')];

      $commentResult = [];
      foreach ($array as $commentId)
        $commentResult[] = ['comment_id' => $commentId, 'count' => $this->getCountResult($commentLikes, $commentId, 'comment')];

      return Response::getInstance(['comments' => $commentResult, 'posts' => $postResult], Flags::ALL_OK)->jsonEncode();
    }
    return Response::getInstance(null, FLags::ALL_OK)->jsonEncode();
  }

  public function actionPrevComments(){
    $me = User::getModelExtended(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;

    $uid_post = Yii::$app->request->get('uid_post');
    $uid_comment = Yii::$app->request->get('uid_comment');

    if ( !(Yii::$app->request->isAjax && isset($uid_post) && is_numeric($uid_post) && isset($uid_comment) && is_numeric($uid_comment)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $comments = Comment::find()->where(['post_id' => $uid_post])
                               ->andWhere(['<', 'id', $uid_comment])
                               ->with(['commentLikes', 'profile'])
                               ->orderBy('updated_at DESC')
                               ->limit(Comment::THRESHOLD)
                               ->all();

     $arrView = [];
     foreach ($comments as $key => $comment) {
       $arrView[] = ['post_id' => $comment->post_id, 'comment_id' => $comment->id, 'body' => $this->renderSection('wall', ['component' => 'comment', 'me' => $me, 'content' => $comment, 'shareable' => false, 'reply_to' => $comment->post_id])];
     }

     return Response::getInstance($arrView, Flags::ALL_OK)->jsonEncode();
  }




/*
  public function actionMentionByName(){
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $search = Yii::$app->request->get('Search');

    $profile_one_condition = ['and', ['profile_one_id' => $myId, 'one_follow_two_status' => Relationship::ACCEPTED]];
    $profile_two_condition = ['and', ['profile_two_id' => $myId, 'two_follow_one_status' => Relationship::ACCEPTED]];
    ['or', $profile_one_condition, $profile_two_condition];

    $relationshipOne = ['and', ['and', 'relationship.profile_one_id=p.id', 'relationship.profile_two_id='.$myId], 'relationship.two_follow_one_status='.ACCEPTED];
    $relationshipTwo = ['and', ['and', 'relationship.profile_two_id=p.id', 'relationship.profile_one_id='.$myId], 'relationship.one_follow_two_status='.ACCEPTED];

    $contacts = (new Query())
                ->select('p.id, p.name, p.last_name, p.photo')
                ->from('profile p')
                ->rightJoin('relationship', ['or', $relationshipOne, $relationshipTwo])
                ->where(['like', 'name', $search['name']])
                ->orWhere(['like', 'last_name', $search['name']])->all();

   return $contacts;
  }
*/


}
