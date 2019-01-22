<?php

namespace backend\modules\playlist\models;

use Yii;

/**
 * This is the model class for table "visibility".
 *
 * @property integer $id
 * @property string $type
 *
 * @property Playlist[] $playlists
 */
class Visibility extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visibility';
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
    public function getPlaylists()
    {
        return $this->hasMany(Playlist::className(), ['visibility_id' => 'id']);
    }
}
