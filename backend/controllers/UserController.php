<?php
namespace backend\controllers;
use Yii;

use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

use common\util\Flags;
use common\util\Response;
use common\util\InfiniteScrollResponse;

use common\models\User;
use common\interfaces\IUser;
use common\widgets\modalBox\ModalBox;

use backend\models\Profile;
use backend\modules\playlist\models\Playlist;

use frontend\services\HistoryService;
use common\services\DataService;

class UserController extends RaBaseController implements IUser{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                  'actions' => ['playlists',
                                'favorites',
                                'history',
                                'profile',
                                'modal'],
                  'allow' => true,
                  'roles' => ['@'],
                ],
          ],
      ],
    ];
  }


  public function actionHistory(){
    $user = User::findOne(Yii::$app->user->id);
    $profile = $user->getAssociatedModel()->profile;

    $segment = Yii::$app->request->get('segment');
    $service = new HistoryService();
    $service->setQuery($profile->id);

    if (!$segment){
      $rows = $service->getData();
      $visible = ($service->isLastPage()) ? false : true;

      $lazyRoute = Url::to(['/user/history', 'segment' => 1]);
      return $this->renderSection('history', ['songs' => $rows,
                                               'profile_id'=> $profile->id,
                                               'lazyLoad' => [
                                                 'route' => $lazyRoute,
                                                 'visible' => $visible,
                                               ]
                                             ]);
    } else {
      $rows = $service->getData($segment);
      $segment = $segment + 1;

      $status =  $service->isLastPage();
      $route = Url::to(['/user/history', 'segment' => $segment]);
      $content= $this->renderSection('history-lazy', ['songs' => $rows, 'profile_id'=> $profile->id]);


      return InfiniteScrollResponse::getInstance($status, $content, $route, Flags::ALL_OK)->jsonEncode();
    }

  }

  public function actionPlaylists(){
    $user = User::findOne(Yii::$app->user->id);
    $profile = $user->getAssociatedModel()->profile;
    $playlists='';
      if ($profile)
        $playlists = $profile->playlists;

      return $this->renderSection('playlists', ['playlists' => $playlists, 'profile' => $profile->id]);
  }

  public function actionFavorites(){
    $user = User::findOne(Yii::$app->user->id);
    $profile = $user->getAssociatedModel()->profile;
    $favorites = null;
    $playlists= null;

    if ($profile){
      $playlists = $profile->playlists;
      foreach($playlists as $playlist)
        if ($playlist->name == Playlist::FAVORITES)
          $favorites = $playlist;

      $query = $favorites->getSongs();
      $service = new DataService();
      $service->setQuery($query);
      $segment = Yii::$app->request->get('segment');
      if (!$segment){
        $rows = $service->getData();
        $visible = ($service->isLastPage()) ? false : true;

        $lazyRoute = Url::to(['/user/favorites', 'segment' => 1]);
        return $this->renderSection('favorites', ['songs' => $rows,
                                                 'favorites_id'=> $favorites->id,
                                                 'lazyLoad' => [
                                                   'route' => $lazyRoute,
                                                   'visible' => $visible,
                                                 ]
                                               ]);
      } else{
        $rows = $service->getData($segment);
        $segment = $segment + 1;

        $status =  $service->isLastPage();
        $route = Url::to(['/user/favorites', 'segment' => $segment]);
        $content= $this->renderSection('favorites-lazy', ['songs' => $rows,
                                                          'profile_id'=> $profile->id,
                                                          'favorites_id'=> $favorites->id]);

        return InfiniteScrollResponse::getInstance($status, $content, $route, Flags::ALL_OK)->jsonEncode();

      }
    }
  }


  public function actionModal(){

    $action = Yii::$app->request->get('action');
    $modal ="";
    switch ($action) {
      case 'add-to-playlist':
          $id = Yii::$app->request->get('id');
          $profile_id = Yii::$app->request->get('profile');
          $profile = Profile::findOne($profile_id);
          return $this->renderAjax('add-to-playlist', ['id'=> $id, 'profile' => $profile]);
        break;
      case 'update':
        break;
      default:
        break;
    }
    return $modal;
  }

  public function actionProfile(){
    $user = User::findOne(Yii::$app->user->id);
    $model = $user->getAssociatedModel();
    return $this->renderSection('profile', ['model' => $model]);

  }

  public function actionConfiguration(){}

}
?>
