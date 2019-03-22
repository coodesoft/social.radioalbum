<?php
namespace admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\UploadedFile;

use backend\controllers\RaBaseController;
use backend\modules\album\models\Album;

use common\util\mapper\Mapper;
use common\util\Response;
use common\util\Flags;

use common\services\DataService;
use common\models\User;
use admin\models\Artist;


class ArtistController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['view', 'edit', 'list', 'add', 'remove'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
          ],
      ],
    ];
  }

  public function actionList(){
    $service = new DataService();
    $query = Artist::find()->with('albums');

    $service->setQuery($query);
    $segment = Yii::$app->request->get('segment');
    if ($segment){
      return $this->getDataSegment('/admin/artist/view', 'list-lazy', $service, $segment);
    } else{
      $rows = $service->getData();
      $visible = ($service->isLastPage()) ? false : true;
      $lazyRoute = Url::to(['/admin/artist/view', 'segment' => 1]);
      $body = $this->renderPartial('artists', ['artists' => $rows, 'lazyLoad' => ['route' => $lazyRoute, 'visible' => $visible]]);
      return $this->renderSection('view', ['body' => $body, 'title' => \Yii::t('app', 'areaAdminArtists')]);
    }
  }

  public function actionView(){
    $id = Yii::$app->request->get('id');
    if ( is_numeric($id) && $id>0){
      $artist = Artist::find()->with(['albums', 'profile'])->where(['id' => $id])->one();
      return $this->renderSection('artist', ['artist' => $artist, 'title' => Yii::t('app', 'artistInfo')]);
    }
    throw new \Exception('Incorrect Param Type', 1);
  }

  public function actionAdd(){
    $model = new ChannelForm();
    if (Yii::$app->request->isPost) {
      $model->load(Yii::$app->request->post());
      $model->art = UploadedFile::getInstance($model, 'art');

      $result = $model->add();
      if ($result->getResponse() == Flags::ALL_OK)
        return Response::getInstance(true, Flags::SAVE_SUCCESS)->jsonEncode();
      elseif ($result->getResponse() == Flags::FORM_VALIDATION)
        $response = ['text' => 'El formulario tiene errores: '.$result->getResponse(), 'type' => 'danger'];
      else
        $response = ['text' => 'Se produjo un error al crear el canal: '.$result->getResponse(), 'type' => 'danger'];


      return Response::getInstance($response, Flags::SAVE_ERROR)->jsonEncode();
    } else{
      return $this->renderSection('add', ['model' => $model]);
    }
  }

  public function actionEdit(){
    $id = Yii::$app->request->get('id');
    if ( !intval($id) )
      return;

    $model = new ChannelForm();
    if (Yii::$app->request->isPost) {
      $model->load(Yii::$app->request->post());
      $model->art = UploadedFile::getInstance($model, 'art');
      $result = $model->edit();
      if ($result->getResponse() == Flags::ALL_OK)
        return Response::getInstance(true, Flags::UPDATE_SUCCESS)->jsonEncode();
      elseif ($result->getResponse() == Flags::FORM_VALIDATION)
        $response = ['text' => 'El formulario tiene errores: '.$result->getResponse(), 'type' => 'danger'];
      else
        $response = ['text' => 'Se produjo un error al editar el canal: '.$result->getResponse(), 'type' => 'danger'];

      return Response::getInstance($response, Flags::SAVE_ERROR)->jsonEncode();
    } else{
      $channel = Channel::findOne($id);
      $model->id = $channel->id;
      $model->name = $channel->name;
      $model->description = $channel->description;
      $model->art_name = $channel->art;
      return $this->renderSection('edit', ['model' => $model]);
    }
  }

  public function actionRemove(){
    $id = Yii::$app->request->get('id');

    if ( !intval($id) )
      return;

    try {
      $result = Channel::deleteOne($id);
      if ( $result->getFlag() == Flags::DELETE_SUCCESS )
        return $result->jsonEncode();

      return Response::getInstance(['text' => 'Se produjo un error al eliminar el canal: '. $result->getResponse(), 'type' => 'danger'], Flags::DELETE_ERROR)->jsonEncode();
    } catch (\Exception $e) {
      return Response::getInstance(['text' => 'Se produjo un error al eliminar el canal: '. $e->getMessage(), 'type' => 'danger'], Flags::DELETE_ERROR)->jsonEncode();
    }



  }
}
