<?php
namespace admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\Html;


use backend\controllers\RaBaseController;
use admin\models\UploadAlbumForm;

use common\util\Response;
use common\util\Flags;
use common\util\ArrayProcessor;

class AlbumController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['view', 'add'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
          ],
      ],
    ];
  }


  public function actionView(){}

  public function actionUpdate(){}

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

  public function actionRemove(){}



}
