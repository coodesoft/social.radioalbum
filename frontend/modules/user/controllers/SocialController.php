<?php
namespace user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\helpers\Json;

use common\models\User;
use common\models\Visibility;
use common\services\DataService;
use common\util\Response;
use common\util\Flags;

use frontend\controllers\RaBaseController;
use frontend\models\Profile;

use user\models\Relationship;
use user\models\Notification;
use user\models\NotificationType;
use user\models\Post;

use user\services\SocialService;

class SocialController extends RaBaseController{


  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['follow',
                                  'accept-follow',
                                  'decline-follow',
                                  'stop-follow',
                                  'check-for-relationship',
                                  'check',
                                  'check-count',
                                  'mark-as-read',
                                  'mark-as-unread',
                                  'mark-all-read',
                                  'notifications',
                                  'messages',
                                  ],
                    'allow' => true,
                    'roles' => ['listener', 'artist'],
                ],
          ],
      ],
    ];
  }


  public function actionFollow(){
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $id = (int) Yii::$app->request->get('id');

    if ( !(Yii::$app->request->isAjax && isset($id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    if ($me->id == $id)
      return null;

    $service = $this->module->get('socialService');
    $toFollow = Profile::findOne($id);

    if (!$toFollow)
      return Response::getInstance(null, Flags::INVALID_ID)->jsonEncode();

    $relationship = Relationship::findRelationship($me->id, $id);
    if ($relationship == null){
      $relationship = new Relationship();

      $relationship->profile_one_id = ($id > $me->id) ? $me->id : $id;
      $relationship->profile_two_id = ($id < $me->id) ? $me->id : $id;

      if ($me->id == $relationship->profile_one_id){
       $relationship->one_follow_two_status = ($toFollow->visibility == Visibility::VPUBLIC) ? Relationship::ACCEPTED : Relationship::PENDING;
       $response = $service->setFollowResponse($relationship->one_follow_two_status, $relationship->profile_one_id, $relationship->profile_two_id);
     }else{
       $relationship->two_follow_one_status = ($toFollow->visibility == Visibility::VPUBLIC) ? Relationship::ACCEPTED : Relationship::PENDING;
       $response = $service->setFollowResponse($relationship->two_follow_one_status, $relationship->profile_two_id, $relationship->profile_one_id);
     }

    } else{
      if ($me->id == $relationship->profile_one_id && ($relationship->one_follow_two_status == null || $relationship->one_follow_two_status == Relationship::DECLINED)){
        $relationship->one_follow_two_status = ($toFollow->visibility == Visibility::VPUBLIC) ? Relationship::ACCEPTED : Relationship::PENDING;
        $response = $service->setFollowResponse($relationship->one_follow_two_status, $relationship->profile_one_id, $relationship->profile_two_id);
      }
      elseif ($me->id == $relationship->profile_two_id && ($relationship->two_follow_one_status == null || $relationship->two_follow_one_status == Relationship::DECLINED)){
        $relationship->two_follow_one_status = ($toFollow->visibility == Visibility::VPUBLIC) ? Relationship::ACCEPTED : Relationship::PENDING;
        $response = $service->setFollowResponse($relationship->two_follow_one_status, $relationship->profile_two_id, $relationship->profile_one_id);
      }
    }
    $response['url'] = Url::to(['/user/social/stop-follow', 'id' => $id]);

    $transaction = Relationship::getDb()->beginTransaction();
    if ($relationship->save()){

      $notification = new Notification();
      $notification->status = Notification::STATUS_UNREAD;
      $notification->sender_id = $me->id;
      $notification->recevier_id = $toFollow->id;
      $notification->created_at = (string) time();
      $notification->updated_at = $notification->created_at;

      $notification_type = ($toFollow->visibility == Visibility::VPUBLIC) ? NotificationType::findOne(['type' => 'relationship_follow']) : NotificationType::findOne(['type' => 'relationship_pending']);
      $notification->notification_type_id = $notification_type->id;

      if ($notification->save()){

        $toFollow->options->notification_check = 0;
        $toFollow->options->save();
        $transaction->commit();
        return Response::getInstance($response, Flags::SAVE_SUCCESS)->jsonEncode();
      }
      $transaction->rollBack();
      return Response::getInstance($notification->errors, Flags::NOTIFICACTION_SAVE_ERROR)->jsonEncode();
    }

    $transaction->rollBack();
    return Response::getInstance(null, Flags::SAVE_ERROR)->jsonEncode();

  }

  public function actionCheckForRelationship(){
    $service = $this->module->get('socialService');

    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;

    $id = (int) Yii::$app->request->get('id');

    if ( !(Yii::$app->request->isAjax && isset($id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $someProfile = Profile::findOne($id);

    return $service->checkForFollower($me->id, $someProfile->id);
  }

  public function actionStopFollow(){
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $id = (int) Yii::$app->request->get('id');

    if ( !(Yii::$app->request->isAjax && isset($id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    // en caso de que intente dejar de seguirme a mi mismo
    if ($me->id == $id)
      return null;

    $service = $this->module->get('socialService');
    $relationship = Relationship::findRelationship($me->id, $id);

    // si no hay relacion retorno null
    if (!$relationship)
      return null;

    // determino quien siugue a quien y actualizo los registros en la tabla
    // adicionalmente obtengo el tipo de notificación asociada a la relación para su posterior eliminación
    $delete = false;
    if ($relationship->profile_one_id == $me->id){
      $relationship->one_follow_two_status = null;
      if (!$relationship->two_follow_one_status)
        $delete = true;
    } else{
      $relationship->two_follow_one_status = null;
      if (!$relationship->one_follow_two_status)
        $delete = true;
    }

    //obtenemos la notificacion asociada a la relacion
    $notification = Notification::findNotificationByType($me->id, $id, 'relationship');

    $result = false;
    $transaction = Relationship::getDb()->beginTransaction();
    if ($delete)
      $result = ($relationship->delete()) ? true : false;
    else
      $result = ($relationship->save()) ? true : false;

    $result = ($notification->delete() && $result);

    if ($result){
      $response['status'] = null;
      $response['url'] = Url::to(['/user/social/follow', 'id' => $id]);
      $transaction->commit();
      return Response::getInstance($response, Flags::DELETE_SUCCESS)->jsonEncode();
    } else{
      $transaction->rollBack();
      return Response::getInstance(null, Flags::DELETE_ERROR)->jsonEncode();
    }

  }

  public function actionAcceptFollow(){
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $recevier_id = Yii::$app->request->get('recevier');

    if ( !(Yii::$app->request->isAjax && isset($recevier_id) && is_numeric($recevier_id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $recevier = Profile::findOne($recevier_id);
    $recevier->options->notification_check = 0;
    $recevier->options->save();

    $relationship = Relationship::findRelationship($me->id, $recevier->id);
    if ($me->id == $relationship->profile_one_id){
      $alreadyAccepted = ($relationship->two_follow_one_status == Relationship::ACCEPTED) ? true : false;
      $relationship->two_follow_one_status = Relationship::ACCEPTED;
    }

    if ($me->id == $relationship->profile_two_id){
        $alreadyAccepted = ($relationship->one_follow_two_status == Relationship::ACCEPTED) ? true : false;
        $relationship->one_follow_two_status = Relationship::ACCEPTED;
      }

    //esto evita que se intente aceptar dos veces la misma solicitud, y evita que se disparen nuevas notificaciones
    if ($alreadyAccepted)
      return Response::getInstance(Yii::t('app', 'requestAccepted'), Flags::NOTIFICATION_SAVE_SUCCESS)->jsonEncode();

    $transaction = Relationship::getDb()->beginTransaction();
    if ($relationship->save()){
      $time = Yii::$app->request->get('time');
      $updatedNotif = Notification::markAsRead($recevier->id, $me->id, $time);

      if ($updatedNotif){
            $notification = new Notification();
            $notification->status = Notification::STATUS_UNREAD;
            $notification->sender_id = $me->id;
            $notification->recevier_id = $recevier->id;
            $notification->created_at = (string) time();
            $notification->updated_at = $notification->created_at;

            $notification_type = NotificationType::findOne(['type' => 'relationship_accepted']);
            $notification->notification_type_id = $notification_type->id;

            if ($notification->save()){
              $transaction->commit();
              return Response::getInstance(Yii::t('app', 'requestAccepted'), Flags::NOTIFICATION_SAVE_SUCCESS)->jsonEncode();
            } else
              $error = Response::getInstance(Yii::t('app', 'errorAcceptRequest'), FLags::NOTIFICACTION_SAVE_ERROR)->jsonEncode();
      } else
            $error = Response::getInstance(Yii::t('app', 'errorAcceptRequest'), FLags::NOTIFICATION_UPDATE_ERROR)->jsonEncode();
    } else
      $error = Response::getInstance(Yii::t('app', 'errorAcceptRequest'), FLags::RELATIONSHIP_UPDATE_ERROR)->jsonEncode();

    $transaction->rollBack();
    return $error;
  }

  public function actionDeclineFollow(){
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $recevier_id = Yii::$app->request->get('recevier');

    if ( !(Yii::$app->request->isAjax && isset($recevier_id) && is_numeric($recevier_id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $relationship = Relationship::findRelationship($me->id, $recevier_id);
    if ($me->id == $relationship->profile_one_id){
      $alreadyDeclined = ($relationship->two_follow_one_status == Relationship::DECLINED) ? true : false;
      $relationship->two_follow_one_status = Relationship::DECLINED;
    }

    if ($me->id == $relationship->profile_two_id){
      $alreadyDeclined = ($relationship->two_follow_one_status == Relationship::DECLINED) ? true : false;
      $relationship->one_follow_two_status = Relationship::DECLINED;
    }

    if ($alreadyDeclined)
      return Response::getInstance(Yii::t('app', 'requestDenied'), Flags::NOTIFICATION_UPDATE_SUCCESS)->jsonEncode();

    $transaction = Relationship::getDb()->beginTransaction();
    if ($relationship->save()){
      $time = Yii::$app->request->get('time');
      $updatedNotif = Notification::markAsRead($recevier_id, $me->id, $time);
      if ($updatedNotif){
        $transaction->commit();
        return Response::getInstance(Yii::t('app', 'requestDenied'), Flags::NOTIFICATION_UPDATE_SUCCESS)->jsonEncode();
      } else
        $error = Response::getInstance(Yii::t('app', 'errorDenyRequest'), FLags::NOTIFICATION_UPDATE_ERROR)->jsonEncode();
    } else
      $error = Response::getInstance(Yii::t('app', 'errorAcceptRequest'), FLags::RELATIONSHIP_UPDATE_ERROR)->jsonEncode();

    $transaction->rollBack();
    return $error;
  }

  public function actionCheck(){

    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $service = $this->module->get('notificationService');
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $response = $service->checkNotification($me->id);

    $me->options->notification_check = true;
    $me->options->save();

    return $this->renderAjax('notifications', ['notifications' => $response]);
  }

  public function actionCheckCount(){

    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    if (!$me->options->notification_check){
      $service = $this->module->get('notificationService');
      return Response::getInstance($service->countNotifications($me->id), Flags::ALL_OK)->jsonEncode();
    }

    return Response::getInstance(0, Flags::ALL_OK)->jsonEncode();
  }

  public function actionMarkAsRead(){
    $id = Yii::$app->request->get('id');

    if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $result = Notification::markAsReadById($id);

    if ($result)
      return Response::getInstance(true, Flags::NOTIFICATION_UPDATE_SUCCESS)->jsonEncode();

    return Response::getInstance(false, Flags::NOTIFICATION_UPDATE_ERROR)->jsonEncode();
  }

  public function actionMarkAsUnread(){
    $id = Yii::$app->request->get('id');

    if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $result = Notification::markAsUnreadById($id);

    if ($result)
      return Response::getInstance(true, Flags::NOTIFICATION_UPDATE_SUCCESS)->jsonEncode();

    return Response::getInstance(false, Flags::NOTIFICATION_UPDATE_ERROR)->jsonEncode();
  }

  public function actionMarkAllRead(){
    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $result = Notification::markAllRead($me->id);
    if ($result)
      return Response::getInstance(true, Flags::NOTIFICATION_UPDATE_SUCCESS)->jsonEncode();

    return Response::getInstance(false, Flags::NOTIFICATION_UPDATE_ERROR)->jsonEncode();
  }


  public function actionNotifications(){
    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $service = $this->module->get('notificationService');
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $notifications = $service->checkNotification($me->id, true);
    return $this->renderSection('wall', ['notifications' => $notifications]);
  }

  public function actionMessages(){}
}
