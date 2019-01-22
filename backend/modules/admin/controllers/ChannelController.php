<?php
namespace admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\UploadedFile;

use backend\controllers\RaBaseController;
use backend\modules\album\models\Album;

use admin\models\Channel;
use common\util\mapper\Mapper;
use common\util\Response;
use common\util\Flags;

use common\services\DataService;
use common\models\User;


class ChannelController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['view', 'update'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
          ],
      ],
    ];
  }

  public function actionView(){
    $actions = [];
    if (Yii::$app->user->can('loginInAdminArea')){
      $actions['adicional'][] = ['icon' => 'plus', 'url' => Url::to(), 'type' => 'modal'];
      $actions['adicional'][] = ['icon' => 'star', 'url' => Url::to(), 'type' => 'modal'];
      $actions['adicional'][] = ['icon' => 'share', 'url' => Url::to(), 'type' => 'nav'];
      $actions['main'] = ['icon' => 'play', 'url' => Url::to(), 'type' => 'playback'];
    }

    $id = Yii::$app->request->get('id');
    $channel = Channel::findOne($id);
    $query = $channel->getAlbums();
    $albums = array();

    $service = new DataService();
    $service->setQuery($query);
    $segment = Yii::$app->request->get('segment');
    if (!$segment){
      $rows = $service->getData();
      $visible = ($service->isLastPage()) ? false : true;
      $lazyRoute = Url::to(['/admin/channel/view', 'id'=> $id, 'segment' => 1]);
      foreach($rows as $album)
        $albums[] = $this->getObjectArrayRepresentation($album, '/admin/album/view', $actions);

      return $this->renderSection('channel', ['albums' => $albums, 'lazyLoad' => ['route' => $lazyRoute, 'visible' => $visible]]);
    }else {
      $rows = $service->getData($segment);
      $segment = $segment + 1;
      $infinite['status'] =  $service->isLastPage();

      $infinite['route'] = Url::to(['/admin/channel/view', 'id'=> $id, 'segment' => $segment]);

      foreach($rows as $album)
        $albums[] = $this->getObjectArrayRepresentation($album, '/admin/album/view', $actions);
      $infinite['content'] = $this->renderSection('channel', ['albums' => $albums, 'partial' => true]);

      return Response::getInstance($infinite, Flags::ALL_OK)->jsonEncode();
    }
  }

  public function actionUpdate(){
    if (Yii::$app->request->isPost){
      $updated = Yii::$app->request->post('Channel');
      $crud = $this->module->get('crudChannel');
      $updated['id'] = $updated['id_referencia'];
      $updated['folder'] = $this->module->params['tmp_dir'];

      $errors = $crud->update($updated['id'], $updated);
      if (strlen($errors)>0){
        $message = ['text' => $errors, 'type' => 'danger'];
        return Response::getInstance($message, Flags::UPDATE_ERROR)->jsonEncode();
      }
      $message = ['text' => Yii::t('app', 'updateChannelSuccess'), 'type' => 'success'];
      return Response::getInstance($message, Flags::ALL_OK)->jsonEncode();
    } else{
      $id = Yii::$app->request->get('id');
      $channel = Channel::findOne($id);
      return $this->renderSection('update', ['model' => $channel]);
    }
  }

  public function actionAdd(){

  }

  public function actionRemove(){

  }
}
