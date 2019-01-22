<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profileOpts".
 *
 * @property integer $id
 * @property integer $begin_date
 * @property integer $instrument
 * @property integer $presentation
 * @property integer $full_name
 * @property integer $birth_date
 * @property integer $birth_location
 * @property integer $phone
 * @property integer $social
 * @property integer $profile_id
 * @property integet $notificatoin_check
 *
 * @property Profile $profile
 */
 class ProfileOpts extends \yii\db\ActiveRecord
 {
     /**
      * @inheritdoc
      */
     public static function tableName()
     {
         return 'profileOpts';
     }

     /**
      * @inheritdoc
      */
     public function rules()
     {
         return [
             [['begin_date', 'instrument', 'presentation', 'full_name', 'birth_date', 'birth_location', 'phone', 'social', 'gender', 'notification_check'], 'integer'],
         ];
     }

     /**
      * @inheritdoc
      */
     public function attributeLabels()
     {
         return [
             'id' => 'ID',
             'begin_date' => 'Begin Date',
             'instrument' => 'Instrument',
             'presentation' => 'Presentation',
             'full_name' => 'Full Name',
             'birth_date' => 'Birth Date',
             'birth_location' => 'Birth Location',
             'phone' => 'Phone',
             'social' => 'Social',
             'notification_check' => 'Notification check',
         ];
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getProfiles()
     {
         return $this->hasMany(Profile::className(), ['options_id' => 'id']);
     }
 }
