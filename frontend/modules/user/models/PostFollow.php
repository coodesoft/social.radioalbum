<?php

namespace user\models;

use Yii;

/**
 * This is the model class for table "post_follow".
 *
 * @property integer $id_profile
 * @property integer $id_post
 */
class PostFollow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_follow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_profile', 'id_post'], 'required'],
            [['id_profile', 'id_post'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_profile' => 'Id Profile',
            'id_post' => 'Id Post',
        ];
    }
}
