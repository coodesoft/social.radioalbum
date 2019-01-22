<?php

namespace frontend\modules\listener\models;

use Yii;
use common\models\User;
use frontend\models\Profile;
/**
 * This is the model class for table "listener".
 *
 * @property integer $id
 * @property integer $profile_id
 * @property integer $user_id
 *
 * @property Profile $profile
 * @property User $user
 */
class Listener extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'listener';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'profile_id', 'user_id'], 'required'],
            [['id', 'profile_id', 'user_id'], 'integer'],
            [['presentation'], 'string', 'max'=> 400],
            [['name'], 'string', 'max' => 45],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'presentation' => 'Presentation',
            'name' => 'Listener Name',
            'profile_id' => 'Profile ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
