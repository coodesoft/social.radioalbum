<?php
namespace frontend\modules\channel\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;

use common\util\Response;
use common\util\Flags;
use common\services\DataService;
use common\models\User;
use common\widgets\errorMessage\ErrorMessage;

use frontend\controllers\RaBaseController;
use frontend\modules\channel\models\Channel;

use searcher\services\Searcher;
use searcher\services\ChannelFilter;
use searcher\services\AlbumFilter;

/**
 * Album controller
 */

class ChannelController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['view', 'list'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
          ],
      ],
    ];
  }

  public function actionView(){
    $segment = Yii::$app->request->get('segment');
    $entity = Yii::$app->request->get('entity');
    $id = Yii::$app->request->get('id');

    if (!isset($id) && !is_numeric($id))
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $channel = Channel::findOne($id);
    $service = new Searcher();
    $filter = new AlbumFilter();
    $filter->relatedChannelId = $id;

    $filter->createQuery();
    $albums = $service->search($filter);
    $albums = $filter->prepareModel($albums);

    $visible = !$service->stopSearch();
    $lazyRoute = Url::to(['/album/album/list-by-channel', 'id'=> $id, 'segment' => 1]);

    return $this->renderSection('channel', ['albums' => $albums, 'element' => $channel, 'lazyLoad' => ['route' => $lazyRoute, 'visible' => $visible]]);
  }

  public function actionList(){
    $entity = Yii::$app->request->get('entity');
    $segment = Yii::$app->request->get('segment');

    $service = new Searcher();

    $filter = new ChannelFilter();
    $filter->createQuery($entity);

    $params['entity'] = $entity;
    $params['segment'] = $segment;

    return $this->listElements($filter, '/channel/channel/list', $params, 'channels');
  }
}
