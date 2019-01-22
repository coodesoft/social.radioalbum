<?php
namespace backend\modules\playlist\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\BaseJson;
use yii\helpers\Url;

use common\models\Song;

use common\util\Response;
use common\util\InfiniteScrollResponse;
use common\util\Flags;

use common\widgets\modalBox\ModalBox;
use common\widgets\songsList\SongsList;

use backend\models\Profile;
use backend\services\DataService;
use backend\controllers\RaBaseController;

use backend\modules\listener\models\Listener;
use backend\modules\playlist\models\Playlist;
use backend\modules\playlist\models\Visibility;


/**
 * Listener controller
 */

class PlaylistController extends RaBaseController {

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                  'actions' => ['modal',
                                'view',
                                'create',
                                'delete',
                                'update',
                                'add-song',
                                'remove-song'
                                 ],
                  'allow' => true,
                  'roles' => ['@'],
                ],
          ],
      ],
    ];
  }

  public function actionCreate(){
    $pl = Yii::$app->request->post('PlayList');

    $stored = Playlist::findOne(['name' => $pl['name']]);

    if (!$stored){
      $profile = Profile::findOne($pl['profile']);
      $visibility = Visibility::findOne($pl['visibility']);


      $playlist = new Playlist();
      $playlist->name = $pl['name'];

      $playlist->profile_id = $profile->id;
      $playlist->visibility_id = $visibility->id;

      if ($playlist->save()){
        if (isset($pl['minimal']) && $pl['minimal'] == 1)
          $row['row'] = $this->renderPartial('row', ['playlist' => $playlist, 'minimal' => true, 'song' => $pl['song']]);
        else
          $row['row'] = $this->renderPartial('row', ['playlist' => $playlist, 'minimal' => false]);

        return Response::getInstance($row['row'], Flags::SAVE_SUCCESS)->jsonEncode();
      }
      $msg = $playlist->errors;
      return Response::getInstance($msg, Flags::SAVE_ERROR)->jsonEncode();
    } else{
      $msg = 'Ya existe una lista con ese nombre';
      return Response::getInstance($msg, Flags::ALREADY_EXIST)->jsonEncode();
      }
  }

  public function actionView(){
    $id = Yii::$app->request->get('id');
    $playlist = Playlist::findOne($id);

    $query = $playlist->getSongs();
    $service = new DataService();
    $service->setQuery($query);
    $segment = Yii::$app->request->get('segment');

    if (!$segment){
      $rows = $service->getData();
      $visible = ($service->isLastPage()) ? false : true;
      $lazyRoute = Url::to(['/playlist/playlist/view', 'id'=>$id, 'segment' => 1]);
      return $this->renderSection('songs', ['songs' => $rows,
                                            'playlist_id' => $playlist->id,
                                            'lazyLoad' => [
                                              'route' => $lazyRoute,
                                              'visible' => $visible,
                                            ]]);
    } else{
      $rows = $service->getData($segment);
      $segment = $segment + 1;
      $status =  $service->isLastPage();
      $route = Url::to(['/playlist/playlist/view', 'id'=>$id, 'segment' => $segment]);
      $content = $this->renderSection('songs-lazy', ['songs' => $rows,
                                                     'playlist_id' => $playlist->id]);

     return InfiniteScrollResponse::getInstance($status, $content, $route, Flags::ALL_OK)->jsonEncode();
    }
  }

  public function actionDelete(){
    $id = Yii::$app->request->post('Playlist');
    $stored = Playlist::findOne($id);
    $stored->unlinkAll('songs', true);
    if ($stored && $stored->delete()){
        return Response::getInstance($id['id'], Flags::DELETE_SUCCESS)->jsonEncode();
    }
    $modal = ModalBox::widget([
      'title' => 'Ops!',
      'content' => 'Se ha producido un error al eliminar la lista de reproducción. Contactese con el área de soporte para mas información.',
    ]);
    return Response::getInstance($modal, Flags::DELETE_ERROR)->jsonEncode();
  }

  public function actionUpdate(){
    $pl = Yii::$app->request->post('PlayList');
    $stored = Playlist::findOne($pl['id']);

    $stored->name = $pl['name'];
    if ($stored->visibility->id != $pl['visibility']){
      //$stored->unlinkAll('visibility');
      $visibility = Visibility::findOne($pl['visibility']);
      $stored->visibility_id = $visibility->id;
    }
    if ($stored && $stored->save()){

      return Response::getInstance($stored, Flags::UPDATE_SUCCESS)->jsonEncode();
    }
    $modal = ModalBox::widget([
      'title' => 'Ops!',
      'content' => 'Se ha producido un error al eliminar la lista de reproducción. Contactese con el área de soporte para mas información.',
    ]);
    return Response::getInstance($modal, Flags::UPDATE_ERROR)->jsonEncode();

  }

  public function actionModal(){
    $id = Yii::$app->request->get('id');
    $action = Yii::$app->request->get('action');
    $content;
    $title;
    $modal;
    switch ($action) {
      case 'delete':
        $content = $this->renderPartial('delete', ['id'=> $id]);
        $title =  'Eliminar Lista de Reproducción';
        break;
      case 'remove-from-playlist':
        $playlist_id = Yii::$app->request->get('playlist_id');
        $song_name = Yii::$app->request->get('name');
        $content = $this->renderPartial('remove-song', ['id'=> $playlist_id, 'song_name'=>$song_name, 'song_id'=>$id]);
        $title =  'Eliminar de la Lista de Reproducción';
        break;
      case 'update':
        $id = Yii::$app->request->get('id');
        $playlist = Playlist::findOne($id);
        $content = $this->renderAjax('update-list', ['playlist' => $playlist]);
        $title =  'Actualizar Lista de Reproducción';
        break;
      default:
        break;
    }
    return $this->renderAjax('modal', ['title' => $title, 'content' => $content]);
  }

  public function actionAddSong(){
    $id = Yii::$app->request->get('id');
    $song_id = Yii::$app->request->get('song');

    $playlist = Playlist::findOne($id);
    $song = Song::findOne($song_id);


    $rows = (new \yii\db\Query())
            -> from('playlist_has_song')
            ->where(['playlist_id' =>$id, 'song_id' => $song_id])
            ->count();

    if ($rows > 0){
      $modal = ModalBox::widget([
        'title' => 'Agregar a Lista de Reproducción ',
        'content' => 'La canción que intentas agregar ya se encuentra en la Lista de Reproducción',
      ]);
      return $modal;
    }

    try {
        $playlist->link('songs', $song);
        $modal = ModalBox::widget([
          'title' => 'Agregar a Lista de Reproducción ',
          'content' => 'La canción se añadió exitosamente a la lista de reproducción!',
        ]);
        return $modal;
    } catch (yii\db\IntegrityException $e) {
        return Response::getInstance($e, Flags::ERROR_UPDATE_DB)->jsonEncode();
    }


  }

  public function actionAddAlbum(){

  }

  public function actionRemoveSong(){
    $pl = Yii::$app->request->post('Playlist');
    $pl_id = $pl['id'];
    $song_id = $pl['song'];

    $playlist = Playlist::findOne($pl_id);
    $song = Song::findOne($song_id);

    try {
        $playlist->unlink('songs', $song, true);
        return Response::getInstance($song->id, Flags::UNLINK_SUCCESS)->jsonEncode();
    } catch (Exception $e) {
        return Response::getInstance($e, Flags::ERROR_UPDATE_DB)->jsonEncode();
    }
  }
}
