<?php

namespace user\models;

use Yii;

/**
 * This is the model class for table "notification_type".
 *
 * @property integer $id
 * @property string $type
 *
 * @property Notification[] $notifications
 */
class NotificationType extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notification::className(), ['notification_type_id' => 'id'])->inverseOf('notificationType');
    }
}
