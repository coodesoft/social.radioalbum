<?php
namespace user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\Html;


use frontend\controllers\RaBaseController;
use user\models\ArtistUploadForm;
use common\models\User;

use common\util\Response;
use common\util\Flags;
use common\util\ArrayProcessor;

use user\models\Notification;
use user\models\NotificationType;

class ArtistUploadController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
              [
                'actions' => ['add'],
                'allow' => true,
                'roles' => ['@'],
              ],
        ],
      ],
    ];
  }

  protected function addNotification($sender_id, $receiver_id){
    $notification = new Notification();
    $notification->status = Notification::STATUS_UNREAD;
    $notification->sender_id = $sender_id;
    $notification->recevier_id = $receiver_id;
    $notification->created_at = (string) time();
    $notification->updated_at = $notification->created_at;

    $notification_type = NotificationType::findOne(['type' => 'album_upload']);
    $notification->notification_type_id = $notification_type->id;

    $notification->save();
  }

  public function actionAdd(){
    if (\Yii::$app->user->can('LoadArtistMainPanel')){
      $model = new ArtistUploadForm();
      if (Yii::$app->request->isPost) {
        $model->load(Yii::$app->request->post());
        $model->image = UploadedFile::getInstance($model, 'image');
        $model->songs = UploadedFile::getInstances($model, 'songs');
        $model->artist = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->name;

        $upload = $model->upload();
        if ($upload->getFlag() === Flags::ALL_OK) {
          $message = ['text' => Yii::t('app', 'uploadAlbumSuccess'), 'type' => 'success'];
          $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;

          $this->addNotification($me->id, 0);

          return Response::getInstance($message, Flags::UPLOAD_SUCCESS)->jsonEncode();
        }

        $response = ArrayProcessor::toString($upload->getResponse());
        $message = ['text' => $response, 'type' => 'danger'];
        return Response::getInstance($message, $upload->getFlag())->jsonEncode();
      }
      return $this->renderSection('add', ['model' => $model]);
    } else
      $this->redirect(['user/profile']);
  }

  public function actionView(){}

  public function actionUpdate(){}

  public function actionRemove(){}


}
