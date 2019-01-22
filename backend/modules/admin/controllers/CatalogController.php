<?php
namespace admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;

use backend\controllers\RaBaseController;
use backend\models\Channel;
use backend\models\Song;
use backend\models\Profile;

use backend\modules\artist\models\Artist;
use backend\modules\album\models\Album;

use common\util\Response;
use common\util\Flags;
use common\util\Requester;
use common\util\ImageProcessor;
use common\util\StrProcessor;

class CatalogController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['view-catalog-migration-area',
                                  'analisis-channels',
                                  'analisis-albums',
                                  'import-photo-artist',
                                  'analisis-artists',
                                  'update-channels',
                                  'update-albums',
                                  'update-songs',
                                  'update-artists',
                                  ],
                    'allow' => true,
                    'roles' => ['admin', 'regulator'],
                ],
          ],
      ],
    ];
  }

  private function diffChannels($ampChannels){
    $channels = Channel::find()->all();
    $stored = array();
    $deleted = array();
    foreach($channels as $channel){
      $id = $channel->id_referencia;
      if (array_key_exists($id, $ampChannels)){
        if ($channel->name != $ampChannels[$id]['name']){
          $ampChannels[$id]['oldName'] = $channel->name;
          $stored[] = $ampChannels[$id];
        }
        unset($ampChannels[$id]);
      }else
        $deleted[] = $channel;
    }
    $result = array();
    $result['update'] = $stored;
    $result['deleted'] = $deleted;
    $result['add'] = $ampChannels;
    return $result;
  }

  private function diffAlbums($ampAlbums){
    $service = $this->module->get('albumService');
    $albums = Album::find()->with('channels')->all();
    $stored = array();
    $deleted = array();
    foreach($albums as $album){
      $id = $album->id_referencia;
      if (array_key_exists($id, $ampAlbums)){
        //por ahora compara si variaron los canales en los que está
        $mirror = $service->compare($album, $ampAlbums[$id]);
        if (isset($mirror['id']))
          $stored[$mirror['id']] = $mirror;
        unset($ampAlbums[$id]);
      } else
        $deleted[] = ['id' => $album->id, 'name' => $album->name];
    }
    $result = array();
    $result['update'] = $stored;
    $result['deleted'] = $deleted;
    $result['add'] = $ampAlbums;
    return $result;
  }

  private function diffSongs($ampSongs){
    $service = $this->module->get('songService');
    $songs = Song::find()->with('album')->all();
    $delete = array();
    $update = array();
    $add = array();
    foreach($songs as $song){
      $id = $song->id_referencia;
      if (isset($ampSongs[$id])){
        $mirror = $service->compare($song, $ampSongs[$id]);
        if ($mirror)
          $update[$id] = $mirror;
        unset($ampSongs[$id]);
      } else
        $delete[] = $song;
    }
    $result = array();
    $result['update'] = $update;
    $result['deleted'] = $delete;
    $result['add'] = $ampSongs;
    return $result;
  }

  private function diffArtists($ampArtists){
    $service = $this->module->get('artistService');
    $artists = Artist::find()->with(['profile', 'albums'])->all();
    $update = array();
    $delete = array();
    foreach($artists as $artist){
      $id = $artist['id_referencia'];
      if (array_key_exists($id, $ampArtists)){
        $mirror  = $service->compare($artist, $ampArtists[$id]);
        if ($mirror)
          $update[$mirror['id']] = $mirror;
        unset($ampArtists[$id]);
      } else
        $delete[] = ['id' => $artist['id'], 'name' => $artist['name']];
    }
    $result = array();
    $result['update'] = $update;
    $result['delete'] = $delete;
    $result['add'] = $ampArtists;
    return $result;
  }

  private function update($collection, $service){
    $crud = $this->module->get($service);
    $errors = array();
    if (isset($collection['add'])){
      $errors['add'] = $crud->addAll($collection['add']);
    }

    if (isset($collection['delete']))
      $errors['delete'] = $crud->removeAll($collection['delete']);

    if (isset($collection['update'])){
      $errors['update'] = $crud->updateAll($collection['update']);
    }else {

    }
    return $errors;
  }

  public function actionViewCatalogMigrationArea(){
    $analisisChannels = Url::to(['/admin/catalog/analisis-channels']);
    $analisisAlbums = Url::to(['/admin/catalog/analisis-albums']);
    $analisisSongs = Url::to(['/admin/catalog/analisis-songs']);
    $analisisArtists = Url::to(['/admin/catalog/analisis-artists']);
    $importPhotoArtist = Url::to(['/admin/catalog/import-photo-artist']);
    return $this->renderSection('catalog', ['analisisChannels' => $analisisChannels,
                                            'analisisAlbums' => $analisisAlbums,
                                            'analisisSongs' => $analisisSongs,
                                            'analisisArtists' => $analisisArtists,
                                            'importPhotoArtist' => $importPhotoArtist,
                                          ]);
  }

  public function actionAnalisisChannels(){
    $ampache = Yii::$app->get('mediaServer');
    $channels = $ampache->getChannels();
    $diff = $this->diffChannels($channels);
    return $this->renderSection('analisis-channels', ['diff' => $diff]);
  }

  public function actionAnalisisAlbums(){
    $ampache = Yii::$app->get('mediaServer');
    $albums   = $ampache->getAlbums();
    $diff = $this->diffAlbums($albums);
    return $this->renderSection('analisis-albums', ['diff' => $diff]);
  }

  private function test($array, $ampSongs){


    return $result;
  }

  public function actionAnalisisSongs(){
    $ampache = Yii::$app->get('mediaServer');
    $songs = $ampache->getSongs();
    $diff = $this->diffSongs($songs);
    return $this->renderSection('analisis-songs', ['diff' => $diff]);
  }

  public function actionAnalisisArtists(){
    $ampache = Yii::$app->get('mediaServer');
    $ampArtists = $ampache->getArtists();
    $diff = $this->diffArtists($ampArtists);
    //return Json::encode($diff);
    return $this->renderSection('analisis-artists', ['diff' => $diff]);;
  }

  public function actionUpdateChannels(){
    $channels = Yii::$app->request->post('channels');
    $errors = $this->update($channels, 'crudChannel');
    return Response::getInstance($errors, Flags::ALL_OK)->jsonEncode();
  }

  public function actionUpdateAlbums(){
    $albums = Yii::$app->request->post('albums');
    $errors = $this->update($albums, 'crudAlbum');
    return Response::getInstance($errors, Flags::ALL_OK)->jsonEncode();
  }

  public function actionUpdateSongs(){
    $songs = Yii::$app->request->post('songs');
    $errors = $this->update($songs, 'crudSong');
    return Response::getInstance($errors, Flags::ALL_OK)->jsonEncode();
  }

  public function actionUpdateArtists(){
    $artists = Yii::$app->request->post('artists');
    $errors = $this->update($artists, 'crudArtist');
    return Response::getInstance($errors, Flags::ALL_OK)->jsonEncode();
  }

  public function actionImportPhotoArtist(){

    $ampache = Yii::$app->get('mediaServer');
    $crud = $this->module->get('crudArtist');
    $ampArtists = $ampache->getArtists();

    $errors = [];
    $ids = [];
    $images = [];
    foreach ($ampArtists as $key => $artist) {
      $id = $artist['id'];
      $ids[] = $id;
      $images[$id] = $artist['photo'];
    }

    $stored = Artist::find()->where(['in', 'id_referencia', $ids])->with('profile')->all();

    foreach ($stored as $key => $artist) {

      // si existe, borramos la imagen actual
      if (is_file(Profile::dataPath() . $artist->profile->photo))
        unlink(Profile::dataPath() . $artist->profile->photo);

      //obtenemos el archivo
      $id_referencia = $artist->id_referencia;
      $image = Requester::get($images[$id_referencia]);

      //genero el nombre identificatorio
      $uidPhoto = StrProcessor::getRandomString($artist->profile->name);
      $artist->profile->photo = $uidPhoto;

      $filename = Profile::dataPath() . $uidPhoto;
      $result = file_put_contents($filename, $image);
      //corregimos la imagen si es rectangular
      $squaredImg = ImageProcessor::cropSquareImage($filename);
      $result = file_put_contents($filename, $squaredImg);
      if ($result != 0){
        if (!$artist->profile->save())
          $errors [] = ['artista' => $artist->name, 'error' => $artist->profile->errors];
      } else
        $errors[] = 'Error al guardar imagen de artista: '. $artist->name;
    }

    if (count($errors)>0)
      $response = Response::getInstance($errors, Flags::UPDATE_ERROR);
    else
      $response = Response::getInstance(null, Flags::UPDATE_SUCCESS);

    return $this->renderSection('import-photo', ['response' => $response]);

  }

}
