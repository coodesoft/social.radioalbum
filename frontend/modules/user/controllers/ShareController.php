<?php
namespace user\controllers;

use common\models\User;
use common\widgets\modalBox\ModalBox;
use common\util\Response;
use common\util\Flags;

use frontend\controllers\RaBaseController;
use frontend\modules\album\models\Album;

use user\components\post\Post;
use user\models\Post as PostModel;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;

class ShareController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['share-post',
                                  'share-song',
                                  'modal',
                                  'target',
                                  'post'
                                  ],
                    'allow' => true,
                    'roles' => ['listener', 'artist'],
                ],
          ],
      ],
    ];

  }

  public function actionTarget(){
    $content = Yii::$app->request->get('content');
    $id = Yii::$app->request->get('id');

    if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id) && isset($content) && is_string($content)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $classname = 'user\models\shared\Shared'. ucfirst($content);
    $model = $classname::getModel($id);

    $target = $this->renderAjax('share', [ 'content' => $model->type,
                                           'id' => $model->id,
                                           'e_url' => $model->url,
                                           'e_title' => $model->name,
                                           'e_image' => $model->imgUrl,
                                         ]);

    return $this->renderAjax('target', ['id' => $id, 'content' => $target]);
  }

  public function actionModal(){
    $id = Yii::$app->request->get('id');
    $content = Yii::$app->request->get('content');

    if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id) && isset($content) && is_string($content)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $classname = 'user\models\shared\Shared'. ucfirst($content);
    $data = $classname::getContent($id);
    return $this->renderAjax('share_entity', ['id' => $id, 'content' => $data, 'type' => $content]);

  }

  public function actionPost(){
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $posted = Yii::$app->request->post('Post');


    if (Yii::$app->request->isAjax && isset($posted) && !empty($posted)){
      $post = new PostModel();
      $post->id = 0;
      $post->profile_id = $me->id;
      $post->visibility_id = $posted['visibility'];
      $post->content = $posted['content'];
      $post->created_at = (string)time();
      $post->updated_at = $post->created_at;
      if ($posted['attached_type'] == 'album'){
          $post->album_id = $posted['attached_id'];
          $entity = 'album';
        }

      if ($posted['attached_type'] == 'post'){
          $post->post_id = $posted['attached_id'];
          $post->post_attached = true;
          $entity = 'post';
      }

      if ($posted['attached_type'] == 'collection'){
          $post->collection_id = $posted['attached_id'];
          $entity = 'collection';
      }

      if ($post->save())
        return Response::getInstance(['status' => true, 'entity' => $entity], Flags::ALL_OK)->jsonEncode();

      return Response::getInstance(false, Flags::SAVE_ERROR)->jsonEncode();
    } else
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

  }

}
