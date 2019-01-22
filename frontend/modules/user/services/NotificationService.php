<?php
namespace user\services;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;

use common\util\StrProcessor;

use frontend\models\Profile;
use frontend\models\ProfileOpts;

use user\models\PostFollow;
use user\models\Notification;
use user\models\NotificationType;



class NotificationService{

    public static function checkNotification($id, $all = null){
      $notifArray = ($all) ? Notification::getNotifications($id) :Notification::getUnreadNotifications($id);

      if (count($notifArray) == 0)
        return null;

      $response = [];
      foreach($notifArray as $result){
        $id = $result['id'];
        $response[$id]['id'] = $result['id'];
        $response[$id]['sender_name'] = $result['name'];
        $response[$id]['sender_id'] = $result['sender_id'];
        $response[$id]['sender_photo'] = $result['photo'];
        $response[$id]['sender_id'] = $result['sender_id'];
        $response[$id]['status'] = $result['status'];
        $response[$id]['created_at'] = $result['created_at'];
        $response[$id]['updated_at'] = $result['updated_at'];
        $response[$id]['clickeable'] = (($result['type']!='relationship_follow') && ($result['type']!='relationship_pending')) ? 'clickeable' : '';
        $response[$id]['meta_data'] = $result['meta_data'];
        $className =  'user\services\messages\\' . StrProcessor::mapToClassName($result['type']) . 'Message';

       $response[$id]['message'] = call_user_func_array($className.'::getMessage', array($result));
      }

      return $response;
    }

    public static function countNotifications($id){
      return Notification::countUnreadNotifications($id);
    }

    public static function notificationIndicator($profile){
      $counter = "";

      $notifCount = NotificationService::countNotifications($profile->id);
      $hide = (($notifCount == 0) || ($profile->options->notification_check)) ? 'display: none' : '';

      $counter = Html::beginTag('span', ['class' => 'fa-layers fa-fw fa-lg notification-counter', 'style'=>"background:transparent; ". $hide]);
      $counter .= Html::tag('i', null, ['class' => 'fas fa-circle fa-lg', 'style'=>"color: red"]);
      $counter .=   Html::beginTag('span', ['class' => 'fa-layers-text fa-inverse notification-counter-text', 'data-fa-transform' => 'shrink-8 down-1 right-0.75', 'style' => 'font-weight:700']);
      $counter .=     $notifCount;
      $counter .=   Html::endTag('span');
      $counter .= Html::endTag('span');



      $notification = Html::tag('i', null, ['class' => 'fas fa-music fa-lg']);

      $notifWrapper = Html::beginTag('div', ['class' => 'notification-wrapper']);
      $notifWrapper .= $notification;
      $notifWrapper .= $counter;
      $notifWrapper .= Html::endTag('div');
      return $notifWrapper;
    }

    public static function buildNotification($sender, $recevier, $type, $meta_data){
      $notification = new Notification();
      $notification->status = Notification::STATUS_UNREAD;
      $notification->sender_id = $sender;
      $notification->recevier_id = $recevier;
      $notification->created_at =  (string) time();;
      $notification->updated_at = $notification->created_at;
      $notification->meta_data = Json::encode($meta_data);

      $notification_type = NotificationType::findOne(['type' => $type]);
      $notification->notification_type_id = $notification_type->id;

      return $notification;
    }



    protected static function createRepresentation($sender, $recevier, $type_id, $meta_data){
      $notif = [];
      $notif['status'] = Notification::STATUS_UNREAD;
      $notif['sender_id'] = $sender;
      $notif['recevier_id'] = $recevier;
      $notif['created_at'] = (string) time();
      $notif['updated_at'] = $notif['created_at'];
      $notif['notification_type_id'] = $type_id;
      if ($meta_data)
        $notif['meta_data'] = Json::encode($meta_data);

      return $notif;
    }

    protected static function updateProfilesNotificationCheck($profileArr){
      $optsIDs = Profile::find()->select(['options_id'])
                               ->where(['in', 'id', $profileArr])
                               ->all();
      $idArr = [];
      foreach ($optsIDs as $key => $value) {
        $idArr[] = $value['options_id'];
      }

      ProfileOpts::updateAll(['notification_check' => 0], ['in', 'id', $idArr]);
    }

    public static function createNotificationListByPostComment($id, $sender_id){
      $postFollowArr = PostFollow::find()->where(['id_post' => $id])->all();
      $type = NotificationType::findOne(['type' => 'post_follow_comment']);
      $result = [];

      $postFollowSender = PostFollow::find()->where(['id_post' => $id, 'id_profile' => $sender_id])->one();
      if (count($postFollowArr)==0 || (count($postFollowArr)==1 && $postFollowSender))
        return -1;

      $profileArr = [];
      foreach ($postFollowArr as $key => $postFollow) {
        if ($sender_id != $postFollow->id_profile){
           $result[] = NotificationService::createRepresentation($sender_id, $postFollow->id_profile, $type->id, ['pid' => $postFollow->id_post]);
           $profileArr[] = $postFollow->id_profile;
         }
      }

      if (count($profileArr)>0)
        NotificationService::updateProfilesNotificationCheck($profileArr);

      $cols = ['status', 'sender_id', 'recevier_id', 'created_at', 'updated_at', 'notification_type_id', 'meta_data'];
      $result = Yii::$app->db->createCommand()->batchInsert('notification', $cols, $result)->execute();
      return $result;
    }

    public static function createNotificationListByCommentResponse($id, $sender_id, $commentOwner_id){
      $postFollowArr = PostFollow::find()->where(['id_post' => $id])->all();
      $type = NotificationType::findOne(['type' => 'post_follow_comment']);
      $result = [];

      $postFollowSender = PostFollow::find()->where(['id_post' => $id, 'id_profile' => $sender_id])
                                            ->orWhere(['id_post' => $id, 'id_profile' => $commentOwner_id])
                                            ->all();


      if (count($postFollowArr)==0 || (count($postFollowArr)==count($postFollowSender) && $postFollowSender))
        return -1;

      $profileArr = [];
      foreach ($postFollowArr as $key => $postFollow) {
        if ($sender_id != $postFollow->id_profile && $commentOwner_id != $postFollow->id_profile){
           $result[] = NotificationService::createRepresentation($sender_id, $postFollow->id_profile, $type->id, ['pid' => $postFollow->id_post]);
           $profileArr[] = $postFollow->id_profile;
         }
      }

      if (count($profileArr)>0)
        NotificationService::updateProfilesNotificationCheck($profileArr);

      $cols = ['status', 'sender_id', 'recevier_id', 'created_at', 'updated_at', 'notification_type_id', 'meta_data'];
      $result = Yii::$app->db->createCommand()->batchInsert('notification', $cols, $result)->execute();
      return $result;
    }


}
