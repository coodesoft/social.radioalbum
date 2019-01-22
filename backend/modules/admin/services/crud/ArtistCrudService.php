<?php
namespace admin\services\crud;
use backend\modules\artist\models\Artist;
use backend\modules\album\models\Album;
use backend\models\Profile;
use backend\models\ProfileOpts;
use backend\util\mapper\Mapper;

use common\util\Requester;
use common\util\ImageProcessor;
use common\util\StrProcessor;
use yii\helpers\Json;
use Yii;

class ArtistCrudService  extends CrudService{

  protected function beforeAdd($obj = null){
    $data = Json::decode($obj);
    $artist = new Artist();
    $artist->id_referencia = $data['id'];
    $artist->name = $data['name'];

    if (strlen($data['presentation'])>0)
      $artist->presentation = substr($data['presentation'], 0, 400);

    if (strlen($data['yearformed'])>0)
      $artist->begin_date = $data['yearformed'];


    //creo el perfil asociado al nuevo artista
    $profile = new Profile();
    $profile->name = $artist->name;

    $uidPhoto = StrProcessor::getRandomString($profile->name);
    $profile->photo = $uidPhoto;

    $image = Requester::get($data['photo']);

    $filename = $profile->dataPath() . $uidPhoto;
    $result = file_put_contents($filename, $image);

    //corregimos la imagen si es rectangular
    $squaredImg = ImageProcessor::cropSquareImage($filename);
    $result = file_put_contents($filename, $squaredImg);

    if ($result == 0)
      throw new \Exception("No se pudo copiar el archivo ", 1);

    //defino las opciones básicas para la visualización del perfil
    $opts = new ProfileOpts();
    $opts->begin_date = 1;
    $opts->presentation = 1;
    $opts->full_name = 1;
    $opts->save();

    $profile->options_id = $opts->id;
    $profile->save();
    $artist->profile_id = $profile->id;

    return $artist;
  }

  protected function afterAdd($model, $obj, $errors){
    $data = Json::decode($obj);
    $ampAlbums = $data['album'];
    foreach ($ampAlbums as $ampAlbum) {
      $album = Album::findOne(['id_referencia' => $ampAlbum]);
      if ($model->validate())
        $model->link('albums', $album);
      else{
        $errors[] = $model->errors;
      }
    }
    return $errors;
  }

  protected function beforeRemove($params = null){
    $model = Artist::findOne($params);

    $playlists = $model->profile->playlists;
    if (!empty($playlists)){
      foreach ($playlists as $playlist)
        $playlist->unlinkAll('songs', true);
      $model->unlink('playlists', $playlist, true);
    }
    if (!empty($model->albums))
      $model->unlinkAll('albums', true);

    $model->unlink('profile', $model->profile, true);
    return $model;
  }

  protected function afterRemove($params = null){}

  protected function beforeUpdate($obj = null){
    $obj = Json::decode($obj);
    $model = Artist::findOne($obj['id']);

    $model->name = $obj['name'];
    $model->profile->name = $model->name;

    if (isset($obj['presentation']) && strlen($obj['presentation'])>0)
      $model->presentation = substr($obj['presentation'], 0, 400);

    if (isset($obj['begin_date']) && strlen($obj['begin_date'])>0)
      $model->begin_date =  (string) $obj['begin_date'];

    if (isset($obj['photo'])){
      
      if (is_file(Profile::dataPath() . $model->profile->photo))
        unlink(Profile::dataPath() . $model->profile->photo);

      $image = Requester::get($obj['photo']);
      $filename = $model->profile->dataPath() . $model->profile->photo;
      $result = file_put_contents($filename, $image);
      //corregimos la imagen si es rectangular
      $squaredImg = ImageProcessor::cropSquareImage($filename);
      $result = file_put_contents($filename, $squaredImg);
      if ($result == 0)
        throw new \Exception("No se pudo copiar el archivo ", 1);

    }

    $albums = $obj['albums'];
    if (isset($albums['add']))
      foreach($albums['add'] as $album){
        $raAlbum = Album::findOne(['id_referencia' =>$album]);
        $model->link('albums', $raAlbum);
      }

    if (isset($albums['delete']))
      foreach($albums['delete'] as $id){
        $raAlbum = Album::findOne($id);
        $model->unlink('albums', $raAlbum, true);
      }

    $model->profile->save();
    return $model;
  }

  protected function afterUpdate($obj = null){}


}
