<?php

namespace frontend\modules\channel\models;

use frontend\modules\album\models\Album;


use Yii;

/**
 * This is the model class for table "channel".
 *
 * @property integer $id
 * @property string $name
 * @property string $id_referencia
 *
 * @property AlbumHasChannel[] $albumHasChannels
 * @property Album[] $albums
 */
class Channel extends \yii\db\ActiveRecord
{

    public static function dataPath(){
      return Yii::getAlias('@common') . '/data/channels/';
    }
      /**
       * @inheritdoc
       */
      public static function tableName()
      {
          return 'channel';
      }

      /**
       * @inheritdoc
       */
      public function rules()
      {
          return [
            [['name', 'id_referencia'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 400],
            [['art'], 'string', 'max'=>100],
          ];
      }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'art' => 'Art',
            'id_referencia' => 'Id reference',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumHasChannels()
    {
        return $this->hasMany(AlbumHasChannel::className(), ['channel_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Album::className(), ['id' => 'album_id'])->viaTable('album_has_channel', ['channel_id' => 'id']);
    }
}
