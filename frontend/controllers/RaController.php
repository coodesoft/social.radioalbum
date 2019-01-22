<?php
namespace frontend\controllers;

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

use frontend\models\Song;
use frontend\models\Profile;
use frontend\modules\album\models\Album;
use frontend\modules\artist\models\Artist;
use frontend\modules\channel\models\Channel;
use frontend\controllers\RaBaseController;

use searcher\services\Searcher;
use searcher\services\SongFilter;

/**
 * Site controller
 */
class RaController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'only' => ['main', 'channels', 'messages', 'collections', 'search', 'thumbnail'],
          'rules' => [
                [
                    'actions' => ['main',
                                  'channels',
                                  'messages',
                                  'collections',
                                  'search'
                                  ],
                    'allow' => true,
                    'roles' => ['listener', 'artist'],
                ],
                [
                    'actions' => ['thumbnail'],
                    'allow' => true,
                    'roles' => ['?', '@'],
                ]
          ],
      ],
    ];
  }

  public function actions() {
      return [
          'error' => [
              'class' => 'yii\web\ErrorAction',
          ],
      ];
  }

  public function actionMain(){
    return $this->redirect(['/channel/channel/list']);
  }

  public function actionMessages(){
    return $this->renderSection('messages');
  }

/*public function actionSongs(){
    $profile = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $entity = Yii::$app->request->get('entity');

    $filter = new SongFilter();
    $filter->createQuery($entity);
    $service = new Searcher();

    $segment = Yii::$app->request->get('segment');

    if (!$segment){
      $rows = $service->search($filter);
      $visible = !$service->stopSearch();
      $lazyRoute = Url::to(['/ra/songs', 'entity' => $entity, 'segment' => 1]);
      return $this->renderSection('songs', ['songs'=> $rows,'profile_id' => $profile->id, 'lazyLoad' => ['route' => $lazyRoute, 'visible' => $visible]]);
    } else{
      $rows = $service->search($filter, $segment);
      $segment = $segment + 1;

      $infinite['status'] =  $service->stopSearch();
      $infinite['route'] = Url::to(['/ra/songs', 'entity' => $entity, 'segment' => $segment]);
      $infinite['content'] = $this->renderSection('songs', ['songs'=> $rows, 'profile_id' => $profile->id, 'partial' => true]);
      return Response::getInstance($infinite, Flags::ALL_OK)->jsonEncode();
    }
  }
  */


  public function actionGetClientTxt(){
    $common = Yii::getAlias('@common') ;
    $traduccion = require($common .'/util/i18n/'. Yii::$app->language.'/client.php');
    return Json::encode($traduccion);
  }

  public function actionThumbnail(){
    $img = Yii::$app->request->get('id');
    $entity = Yii::$app->request->get('entity');
    return ImageProcessor::thumbnail($img, $entity);
  }

}
