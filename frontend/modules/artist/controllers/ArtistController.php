<?php
namespace frontend\modules\artist\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

use common\models\User;
use common\util\Flags;
use common\util\Response;
use common\util\ArrayProcessor;

use frontend\models\Profile;
use frontend\modules\artist\models\Artist;
use frontend\controllers\RaBaseController;
use admin\models\UploadAlbumForm;

use searcher\services\Searcher;
use searcher\services\ArtistFilter;
use searcher\services\PostFilter;

use user\services\SocialService;
use user\models\Relationship;


/**
 * Site controller
 */
class ArtistController extends RaBaseController{


  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['view', 'list', 'add'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
          ],
      ],
    ];
  }

  public function actionView(){
    $id = Yii::$app->request->get('id');

    if (!isset($id) && !is_numeric($id))
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);
    
    $artist = Artist::find()->with('profile')->where(['id' => $id])->one();
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;

    $relationship = SocialService::checkForFollower($me->id, $artist->profile->id);

    if ($relationship && $relationship['status'] != Relationship::DECLINED && $relationship['status'] != Relationship::BLOCKED){
      $title = ($relationship['status'] == Relationship::PENDING) ? Yii::t('app', 'pendingFollowReq') : Yii::t('app', 'stopFollow');
      $profile_action = ['icon' => 'user', 'title' => $title, 'type' => 'social.follow', 'url' => Url::to(['/user/social/stop-follow', 'id' => $artist->profile->id])];
    } else
       $profile_action = ['icon' => 'user', 'title' => Yii::t('app', 'follow'), 'type' => 'social.follow', 'url' => Url::to(['/user/social/follow', 'id' => $artist->profile->id])];


    $filter = new PostFilter();
    $filter->createQuery(['who' => $artist->profile->id]);

    $service = new Searcher();
    $posts = $service->search($filter);
    $posts = $filter->prepareModel($posts);

    $followers = SocialService::getFollowers($artist->profile->id);
    $followedUsers = SocialService::getFollowedUsers($artist->profile->id);

    $relationships = [];

    $idArr = [];
    foreach ($followers as $key => $profile){
      $relationships['followers'][] = ArrayProcessor::profileToArrayRepresentation($profile);
    }

    foreach ($followedUsers as $key => $profile)
      $relationships['followedUsers'][] = ArrayProcessor::profileToArrayRepresentation($profile);

    return $this->renderSection('artist_profile', ['artist' => $artist,
                                                   'posts' => $posts,
                                                   'relationships' => $relationships,
                                                   'postsRemain' => !$service->stopSearch(),
                                                   'profile_action' => $profile_action
                                                  ]);
  }

  public function actionList(){
    $entity = Yii::$app->request->get('entity');
    $segment = Yii::$app->request->get('segment');

    $service = new Searcher();
    $filter = new ArtistFilter();
    $filter->createQuery($entity);

    $params['entity'] = $entity;
    $params['segment'] = $segment;

    return $this->listElements($filter, '/artist/artist/list', $params, 'artists');
  }

  public function actionAdd(){
    $model = new UploadAlbumForm();

    if (Yii::$app->request->isPost) {
      $model->load(Yii::$app->request->post());
      $model->image = UploadedFile::getInstance($model, 'image');
      $model->songs = UploadedFile::getInstances($model, 'songs');
      $upload = $model->upload();
      if ($upload->getFlag() === Flags::ALL_OK) {
        $message = ['text' => Yii::t('app', 'uploadAlbumSuccess'), 'type' => 'success'];
        return Response::getInstance($message, Flags::UPLOAD_SUCCESS)->jsonEncode();
      }

      $response = ArrayProcessor::toString($upload->getResponse());
      $message = ['text' => $response, 'type' => 'danger'];
      return Response::getInstance($message, $upload->getFlag())->jsonEncode();
    }
    return $this->renderSection('add', ['model' => $model]);
  }

}
