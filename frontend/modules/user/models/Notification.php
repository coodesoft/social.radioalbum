<?php

namespace user\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $sender_id
 * @property integer $recevier_id
 * @property integer $type
 * @property string $message
 *
 */
class Notification extends \yii\db\ActiveRecord
{

    const STATUS_UNREAD     = 0;

    const STATUS_READ       = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'sender_id', 'recevier_id'], 'integer'],
            [['created_at', 'updated_at'], 'string', 'max' => 45],
            [['meta_data'], 'string', 'max' => 60],
            [['notification_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => NotificationType::className(), 'targetAttribute' => ['notification_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'sender_id' => 'Sender ID',
            'recevier_id' => 'Recevier ID',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'notification_type_id' => 'Notification Type ID',
      ];
    }

    /**
      * @return \yii\db\ActiveQuery
      */
    public function getNotificationType(){
            return $this->hasOne(NotificationType::className(), ['id' => 'notification_type_id'])->inverseOf('notifications');
    }

    public static function getUnreadNotifications($id){
      return (new Query())->select(['notification_type.*', 'n.*', 'profile.photo', 'profile.name'])
                          ->from(['notification n'])
                          ->leftJoin('notification_type', 'notification_type.id = n.notification_type_id')
                          ->leftJoin('profile', 'profile.id = n.sender_id')
                          ->where(['recevier_id' => $id])
                          ->andWhere(['status' => Notification::STATUS_UNREAD])
                          ->orderBy(['created_at' => SORT_DESC])
                          ->all();
    }

    public static function getNotifications($id){
      return (new Query())->select(['notification_type.*', 'n.*', 'profile.photo', 'profile.name'])
                          ->from(['notification n'])
                          ->leftJoin('notification_type', 'notification_type.id = n.notification_type_id')
                          ->leftJoin('profile', 'profile.id = n.sender_id')
                          ->where(['recevier_id' => $id])
                          ->orderBy(['created_at' => SORT_DESC])
                          ->all();
    }

    public static function countUnreadNotifications($id){
      return Notification::find()->where(['recevier_id' => $id])
                                 ->andWhere(['status' => Notification::STATUS_UNREAD])
                                 ->orderBy(['updated_at' => SORT_DESC])
                                 ->count();

    }

    public static function findNotificationByType($sender, $recevier, $type){
      return Notification::find()->joinWith('notificationType')
                                 ->where(['sender_id' => $sender])
                                 ->andWhere(['recevier_id' => $recevier])
                                 ->andWhere(['like', 'notification_type.type', $type])
                                 ->one();
    }

    public static function findNotificationByTime($sender, $recevier, $time){
        return Notification::find()->where(['sender_id' => $sender])
                                   ->andWhere(['recevier_id' => $recevier])
                                   ->andWhere(['status' => Notification::STATUS_UNREAD])
                                   ->andWhere(['updated_at' => $time])
                                   ->one();
    }

    public static function markAsRead($sender, $recevier, $time){
      $stored = Notification::findNotificationByTime($sender, $recevier, $time);
      if ($stored){
        $stored->status = Notification::STATUS_READ;
        $stored->updated_at = (string) time();
        return $stored->save();
      }
      return false;
    }

    public static function markAsReadById($id){
      $stored = Notification::findOne($id);
      if ($stored){
        $stored->status = Notification::STATUS_READ;
        $stored->updated_at = (string) time();
        return $stored->save();
      }
      return false;
    }

    public static function markAsUnreadById($id){
      $stored = Notification::findOne($id);
      if ($stored){
        $stored->status = Notification::STATUS_UNREAD;
        $stored->updated_at = (string) time();
        return $stored->save();
      }
      return false;
    }

    public static function markAllRead($recevier_id){
      return Notification::updateAll(['status' => 1], ['recevier_id' => $recevier_id, 'status' => 0]);
    }
}
