<?php
namespace backend\controllers;

use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\i18n\I18N;

use common\models\User;
use common\util\Requester;
use common\util\Flags;
use common\util\Response;
use common\util\StrProcessor;
use common\util\ImageProcessor;
use common\util\mapper\Mapper;
use common\services\DataService;

use backend\models\Song;
use backend\models\Profile;
use backend\modules\album\models\Album;
use backend\modules\artist\models\Artist;
use admin\models\Channel;
use backend\controllers\RaBaseController;

/**
 * Site controller
 */
class RaController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['main',
                                  'albums',
                                  'artists',
                                  'artist',
                                  'channels',
                                  'messages',
                                  'songs',
                                  'get-client-txt',
                                  'thumbnail'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
          ],
      ],
    ];
  }


  private function getArtistArrayRepresentation($artist, $actions){
    $obj = array();
    $obj['name'] = $artist['name'];
    $obj['id'] = $artist['id'];
    $obj['art'] = Url::to(['/ra/thumbnail', 'id' => $artist['profile']['photo'], 'entity' => 'profile']);
    $obj['url'] = Url::to(['/artist/artist/artist', 'id' => $obj['id']]);
    $obj['actions'] = $actions;
    return $obj;
  }

  public function actionMain(){
    return $this->actionChannels();
  }

  public function actionAlbums(){
    $actions = [];
    if (Yii::$app->user->can('loginInAdminArea')){
    //  $actions['adicional'][] = ['icon' => 'eye-slash', 'url' => Url::to(), 'type' => 'nav', 'tooltip' => \Yii::t('app', 'disable')];
      $actions['main']        = ['icon' => 'play', 'url' => Url::to(), 'type' => 'playback', 'tooltip' => \Yii::t('app', 'playback')];
    }

    $query = Album::find()->orderBy('name');
    $albums = array();

    $service = new DataService();
    $service->setQuery($query);
    $segment = Yii::$app->request->get('segment');
    if (!$segment){
      $rows = $service->getData();
      $visible = ($service->isLastPage()) ? false : true;
      $lazyRoute = Url::to(['/ra/albums', 'segment' => 1]);
      foreach($rows as $album)
        $albums[] = $this->getObjectArrayRepresentation($album, '/admin/album/view', $actions, 'album');

      return $this->renderSection('albums', ['albums' => $albums, 'lazyLoad' => ['route' => $lazyRoute, 'visible' => $visible]]);
    }else {
      $rows = $service->getData($segment);
      $segment = $segment + 1;
      $infinite['status'] =  $service->isLastPage();

      $infinite['route'] = Url::to(['/ra/albums', 'segment' => $segment]);

      foreach($rows as $album)
        $albums[] = $this->getObjectArrayRepresentation($album, '/admin/album/view', $actions, 'album');
      $infinite['content'] = $this->renderSection('albums', ['albums' => $albums, 'partial' => true]);

      return Response::getInstance($infinite, Flags::ALL_OK)->jsonEncode();
    }
  }

  public function actionArtists(){
    $actions = [];
/*    $icon = $artist->profile->listed ? 'eye-slash' : 'eye';
    $tooltip = $artist->profile->listed ? \Yii::t('app', 'disable') : \Yii::t('app', 'enable');
    if (Yii::$app->user->can('loginInAdminArea'))
      $actions['main'] = ['icon' => $icon, 'url' => Url::to(['/regulator/regulator/status-user']), 'type' => 'modal', 'tooltip' => $tooltip];
*/

    $artists = array();
    $query = Artist::find()->orderBy('name');
    $service = new DataService();
    $service->setQuery($query);
    $segment = Yii::$app->request->get('segment');
    if (!$segment){
      $rows = $service->getData();
      $visible = ($service->isLastPage()) ? false : true;
      $lazyRoute = Url::to(['/ra/artists', 'segment' => 1]);
      foreach($rows as $artist){
        $artists[] = $this->getArtistArrayRepresentation($artist, $actions);
      }

      return $this->renderSection('artists', ['artists' =>$artists, 'lazyLoad' => ['route' => $lazyRoute,'visible' => $visible]]);
    } else {
      $rows = $service->getData($segment);
      $segment = $segment + 1;

      $infinite['status'] =  $service->isLastPage();
      $infinite['route'] = Url::to(['/ra/artists', 'segment' => $segment]);
      foreach($rows as $artist){
        $artists[] = $this->getArtistArrayRepresentation($artist, $actions);
      }
      $infinite['content'] = $this->renderSection('artists', ['artists' => $artists, 'partial' => true]);

      return Response::getInstance($infinite, Flags::ALL_OK)->jsonEncode();
    }

  }

  public function actionChannels(){
    $actions = [];
    if (Yii::$app->user->can('loginInAdminArea')){
      $actions['main']  = ['icon' => 'play', 'url' => Url::to(), 'type' => 'playback', 'tooltip' => \Yii::t('app', 'playback')];
    }

    $query = Channel::find()->orderBy('name');
    $channels = array();

    $service = new DataService();
    $service->setQuery($query);
    $segment = Yii::$app->request->get('segment');

    if (!$segment){
      $rows = $service->getData();
      $visible = ($service->isLastPage()) ? false : true;
      $lazyRoute = Url::to(['/ra/channels', 'segment' => 1]);
      foreach($rows as $channel){
        $actions['adicional'] = [];
        if (Yii::$app->user->can('loginInAdminArea'))
            $actions['adicional'][] = ['icon' => 'pencil', 'url' => Url::to(['/admin/channel/update', 'id' => $channel->id]), 'type' => 'nav', 'tooltip' => \Yii::t('app', 'playback')];
        $channels[] = $this->getObjectArrayRepresentation($channel, '/admin/channel/view', $actions, 'channel');
      }
      return $this->renderSection('channels', ['channels' =>$channels, 'lazyLoad' => ['route' => $lazyRoute,'visible' => $visible]]);
    }else {
      $rows = $service->getData($segment);
      $segment = $segment + 1;

      $infinite['status'] =  $service->isLastPage();
      $infinite['route'] = Url::to(['/ra/channels', 'segment' => $segment]);
      foreach($rows as $channel){
        $actions['adicional'] = [];
        if (Yii::$app->user->can('loginInAdminArea'))
            $actions['adicional'][] = ['icon' => 'pencil', 'url' => Url::to(['/admin/channel/update', 'id' => $channel->id]), 'type' => 'nav', 'tooltip' => \Yii::t('app', 'playback')];
        $channels[] = $this->getObjectArrayRepresentation($channel, '/admin/channel/view', $actions, 'channel');
      }
      $infinite['content'] = $this->renderSection('channels', ['channels' => $channels, 'partial' => true]);

      return Response::getInstance($infinite, Flags::ALL_OK)->jsonEncode();
    }
  }

  public function actionMessages(){
    return $this->renderSection('messages');
  }

  public function actionSongs(){
    $user = User::findOne(Yii::$app->user->id);

    $query = Song::find();
    $service = new DataService();
    $service->setQuery($query);
    $segment = Yii::$app->request->get('segment');
    if (!$segment){
      $rows = $service->getData();
      $visible = ($service->isLastPage()) ? false : true;
      $lazyRoute = Url::to(['/ra/songs', 'segment' => 1]);
      return $this->renderSection('songs', ['songs'=> $rows, 'lazyLoad' => ['route' => $lazyRoute, 'visible' => $visible]]);
    } else{
      $rows = $service->getData($segment);
      $segment = $segment + 1;

      $infinite['status'] =  $service->isLastPage();
      $infinite['route'] = Url::to(['/ra/songs', 'segment' => $segment]);
      $infinite['content'] = $this->renderSection('songs', ['songs'=> $rows, 'partial' => true ]);
      return Response::getInstance($infinite, Flags::ALL_OK)->jsonEncode();
    }
  }

  public function actionGetClientTxt(){
    $traduccion = require(dirname(__DIR__).'/../common/util/i18n/'.Yii::$app->language.'/client.php');
    return Json::encode($traduccion);
  }

  public function actionThumbnail(){
    $img = Yii::$app->request->get('id');
    $entity = Yii::$app->request->get('entity');
    return ImageProcessor::thumbnail($img, $entity);

  }
  

}
