<?php

namespace admin\models;

use backend\modules\album\models\Album;


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
            'name' => \Yii::t('app', 'name'),
            'art' => \Yii::t('app', 'channelArt'),
            'description' => \Yii::t('app', 'description'),
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

    public function deleteOne($id){
      $channel = Channel::findOne($id);

      if ($channel){
        try {
          $channel->unlinkAll('albums', true);
          if ( $channel->delete() ){
            $unlink = unlink(Channel::dataPath() . $channel->art);
            if ($unlink)
              return Response::getInstance(true, Flags::DELETE_SUCCESS);
            return Response::getInstance('Se eliminó el canal, pero no se pudo eliminar la imágen', Flags::DELETE_ERROR);
          }
          return Response::getInstance($channel->errors, Flags::DELETE_ERROR);
        } catch (yii\base\InvalidCallException $e) {
          $transaction->rollBack();
          throw new \Exception('Se produjo un error al eliminar una o mas relaciones de canal. Detalle del error: '. $e->getMessage(), 1);
        }
      }
    }
}
