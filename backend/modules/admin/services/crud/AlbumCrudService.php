<?php
namespace admin\services\crud;

use backend\modules\album\models\Album;
use backend\models\Channel;
use backend\models\Song;
use yii\helpers\Json;
use Yii;

use common\util\Requester;
use common\util\ImageProcessor;
use common\util\StrProcessor;

class AlbumCrudService  extends CrudService{


  protected function transaction(){
    return Album::getDb()->beginTransaction();
  }

  protected function beforeAdd($obj = null){
    $obj = Json::decode($obj);
    $album = new Album();
    $album->name = $obj['name'];
    $album->id_referencia = $obj['id'];

    $image = Requester::get($obj['art']);

    $uidPhoto = StrProcessor::getRandomString($album->name);
    $album->art = $uidPhoto;

    if (is_file(Album::dataPath() . $album->art))
      unlink(Album::dataPath() . $album->art);

    $filename = $album->dataPath() . $uidPhoto;
    $result = file_put_contents($filename, $image);

    //corregimos la imagen si es rectangular
    $squaredImg = ImageProcessor::cropSquareImage($filename);
    $result = file_put_contents($filename, $squaredImg);

    if ($result == 0)
      throw new \Exception("No se pudo copiar el archivo ", 1);

    return $album;
  }

  protected function afterAdd($model, $obj, $errors){
    $obj = Json::decode($obj);
    $ampChannels = $obj['channels'];
    foreach($ampChannels as $ampChannel){
      $channel = Channel::findOne(['name' => $ampChannel]);
      if ($channel)
        $model->link('channels', $channel);
    }

    $ampSongs = $obj['songs'];

    foreach($ampSongs as $ampSong){
      $song = new Song();
      $song->name = $ampSong['name'];
      $song->path_song = $ampSong['path_song'];
      $song->id_referencia = $ampSong['id'];
      $song->time = $ampSong['time'];
      $song->rate = $ampSong['rate'];
      $song->bitrate = $ampSong['bitrate'];
      $song->size = $ampSong['size'];

      try {
          $model->link('songs', $song);
      } catch (yii\base\InvalidCallException $e) {
        $errors[] = ['id' => $model->id, 'error' => $e->getName()];
      }
    }

    return $errors;
  }

  protected function beforeRemove($params = null){
    $album = Album::findOne($params);
    if (!empty($album->songs))
      $album->unlinkAll('songs', true);

    if (!empty($album->genres))
      $album->unlinkAll('genres', true);

    if (!empty($album->channels))
      $album->unlinkAll('channels', true);

    if (!empty($album->artists))
      $album->unlinkAll('artists', true);

    return $album;
  }

  protected function afterRemove($params = null){}

  protected function beforeUpdate($obj = null){
    $obj = Json::decode($obj);
    $album = Album::findOne($obj['id']);
    $album->name = $obj['name'];

    /* Obtenemos el hash sha1 del art del album en
     * ampache y en radioalbm y los comparamos para saber si hay
     * que actualizar la imagen
     */
    $ampArt = Requester::get($obj['art']);
    $resumenAmp = sha1($ampArt);


    $image = Requester::get($obj['art']);
    if ($image){
      $filename = $album->dataPath() . $album->art;
      $toSave = ImageProcessor::cropSquareImage($image);
      $result = file_put_contents($filename, $image);
      //corregimos la imagen si es rectangular
      $squaredImg = ImageProcessor::cropSquareImage($filename);
      $result = file_put_contents($filename, $squaredImg);

    }

    $ampChannels = $obj['channels'];
    // desvinculamos los canales correspondientes
    if (isset($ampChannels['delete']))
      foreach($album->channels as $channel){
        if (in_array($channel['name'], $ampChannels['delete']))
          $album->unlink('channels', $channel, true);
      }

    // vinculamos los canales correspondientes
    if (isset($ampChannels['add']))
      foreach($ampChannels['add'] as $ampChannel){
        $channel = Channel::findOne(['name' => $ampChannel]);
        $album->link('channels', $channel);
      }

    return $album;
  }

  protected function afterUpdate($obj = null){}


}
