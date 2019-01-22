<?php
namespace frontend\modules\listener\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;

use common\models\User;
use common\util\ArrayProcessor;
use common\util\Flags;
use common\util\Response;

use frontend\models\Profile;
use frontend\modules\listener\models\Listener;
use frontend\controllers\RaBaseController;


use searcher\services\Searcher;
use searcher\services\ListenerFilter;
use searcher\services\PostFilter;

use user\services\SocialService;
use user\models\Relationship;
/**
 * Listener controller
 */

class ListenerController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                  'actions' => ['view',
                                'list',
                                ],
                  'allow' => true,
                  'roles' => ['@'],
                ],
          ],
      ],
    ];
  }


  public function actionConfiguration(){
    $id = Yii::$app->user->id;
  }

  public function actionView(){
    $actions = [];
    $actions['adicional'][] = ['icon' => 'plus', 'url' => Url::to(), 'type' => 'modal', 'tooltip' => \Yii::t('app', 'addToPlaylist')];
    $actions['adicional'][] = ['icon' => 'star', 'url' => Url::to(), 'type' => 'modal', 'tooltip' => \Yii::t('app', 'addToFavs')];
    $actions['adicional'][] = ['icon' => 'share', 'url' => Url::to(), 'type' => 'nav', 'tooltip' => \Yii::t('app', 'share')];;
    $actions['main']        = ['icon' => 'play', 'url' => Url::to(), 'type' => 'playback', 'tooltip' => \Yii::t('app', 'playback')];

    $id = Yii::$app->request->get('id');

    if (!isset($id) && !is_numeric($id))
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $artist = Listener::find()->with('profile')->where(['id' => $id])->one();
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
                                                   'actions' => $actions,
                                                   'relationships' => $relationships,
                                                   'posts' => $posts,
                                                   'postsRemain' => !$service->stopSearch(),
                                                   'profile_action' => $profile_action]);
  }

  public function actionList(){

    $entity = Yii::$app->request->get('entity');
    $segment = Yii::$app->request->get('segment');

    $albums = array();
    $service = new Searcher();

    $filter = new ListenerFilter();
    $filter->createQuery($entity);

    $params['entity'] = $entity;
    $params['segment'] = $segment;

    return $this->listElements($filter, '/listener/listener/list', $params, 'listeners');

  }
}
