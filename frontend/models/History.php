<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property integer $id
 * @property string $profile_id
 * @property string $song_id
 * @property string $date
 */
class History extends \yii\db\ActiveRecord
{

    const MAX_HISTORY_SIZE = 100;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'song_id', 'date'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_id' => 'Profile ID',
            'song_id' => 'Song ID',
            'date' => 'Date',
        ];
    }

}
