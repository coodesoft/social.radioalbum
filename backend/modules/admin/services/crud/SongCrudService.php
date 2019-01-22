<?php
namespace admin\services\crud;
use backend\models\Song;
use backend\modules\album\models\Album;
use yii\helpers\Json;

class SongCrudService extends CrudService{

  protected function transaction(){
    return Song::getDb()->beginTransaction();

  }

  protected function beforeAdd($obj = null){
    $obj = Json::decode($obj);
    $song = new Song();
    $song->name = $obj['name'];
    $song->path_song = $obj['path_song'];
    $song->id_referencia = $obj['id'];
    $song->time = $obj['time'];
    $song->rate = $obj['rate'];
    $song->bitrate = $obj['bitrate'];
    $song->size = $obj['size'];

    if (isset($obj['album_id']))
      $song->album_id = $obj['album_id'];
    return $song;
  }

  protected function afterAdd($model, $obj, $errors){
    return $errors;
   }

  protected function beforeRemove($obj = null){
    $song = Song::findOne($obj);
    return $song;
  }

  protected function afterRemove($obj = null){}

  protected function beforeUpdate($obj = null){
    $obj = Json::decode($obj);
    $song = Song::findOne($obj['id']);
    if (isset($obj['album']['new'])){
      $album = Album::findOne(['name' => $obj['album']['new']]);
      $song->album_id = $album->id;
    }

    $song->name = isset($obj['name']['new']) ? $obj['name']['new'] : $song->name;
    return $song;
  }

  protected function afterUpdate($params = null){}



}
