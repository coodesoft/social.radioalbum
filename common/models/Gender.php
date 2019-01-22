<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gender".
 *
 * @property integer $id_gender
 * @property string $type
 *
 * @property Profile[] $profiles
 */
class Gender extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gender';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_gender'], 'required'],
            [['id_gender'], 'integer'],
            [['type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_gender' => 'Id Gender',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['gender_id' => 'id_gender']);
    }
}
