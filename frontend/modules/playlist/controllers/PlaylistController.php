<?php
namespace frontend\modules\playlist\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\BaseJson;
use yii\helpers\Url;

use common\models\Visibility;
use common\models\User;
use common\util\Response;
use common\util\Flags;
use common\util\MobileDetect;
use common\widgets\modalBox\ModalBox;
use common\widgets\songsList\SongsList;
use common\services\DataService;

use frontend\models\Song;
use frontend\models\Profile;
use frontend\controllers\RaBaseController;
use frontend\modules\listener\models\Listener;
use frontend\modules\playlist\models\Playlist;
use frontend\modules\album\models\Album;

use searcher\services\Searcher;
use searcher\services\PlaylistFilter;

use frontend\modules\musicPanel\components\mobilePlaybackVisor\MobilePlaybackVisor;
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
                                'create',
                                'delete',
                                'update',
                                'add-to-favs',
                                'add-song',
                                'add-album',
                                'remove-song',
                                'list'
                                 ],
                  'allow' => true,
                  'roles' => ['@'],
                ],
                [
                  'actions' => ['view'],
                  'allow' => true,
                  'roles' => ['?', '@'],
                ]
          ],
      ],
    ];
  }


  public function _checkSongInPlaylist($song_id, $playlist_id){
    $rows = (new \yii\db\Query())
            -> from('playlist_has_song')
            ->where(['playlist_id' =>$playlist_id, 'song_id' => $song_id])
            ->count();

    return ($rows > 0);
  }

  public function _addSongToCollection($song_id, $playlist_id){

    $alreadyExist = $this->_checkSongInPlaylist($song_id, $playlist_id);
    if ($alreadyExist){
      $modal = ModalBox::widget([
        'title' => \Yii::t('app', 'addToPlaylist'),
        'content' => \Yii::t('app', 'songAlreadyInPlaylist'),
        'type' => 'danger',
      ]);
      return $modal;
    }

    $playlist = Playlist::findOne($playlist_id);
    $song = Song::findOne($song_id);


    try {
        $playlist->link('songs', $song);
        $modal = ModalBox::widget([
          'title' => \Yii::t('app', 'addToPlaylist'),
          'content' => \Yii::t('app', 'songAddedToPlaylist'),
        ]);
        return $modal;
    } catch (yii\db\IntegrityException $e) {
        return Response::getInstance($e, Flags::ERROR_UPDATE_DB)->jsonEncode();
    }
  }

  public function actionAddToFavs(){
    $song_id = Yii::$app->request->get('id');

    if ( !(Yii::$app->request->isAjax && isset($song_id) && is_numeric($song_id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type);

    $favorites = Playlist::find()->where(['profile_id' => $me->profile->id, 'name' => Playlist::FAVORITES])->one();
    return $this->_addSongToCollection($song_id, $favorites->id);
  }

  public function actionList(){
    $entity = Yii::$app->request->get('entity');
    $segment = Yii::$app->request->get('segment');

    $filter = new PlaylistFilter();
    $filter->createQuery($entity);

    $params['entity'] = $entity;
    $params['segment'] = $segment;

    return $this->listElements($filter, '/playlist/playlist/list', $params, 'playlists');
  }

  public function actionCreate(){
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $pl = Yii::$app->request->post('PlayList');

    if ( !(Yii::$app->request->isAjax && isset($pl) && is_array($pl)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $stored = Playlist::find()->where(['name' => $pl['name'], 'profile_id' => $me->id])->one();

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

        return Response::getInstance(['data' => $row['row'], 'origin' => $pl['origin']], Flags::SAVE_SUCCESS)->jsonEncode();
      }
      $msg = $playlist->errors;
      return Response::getInstance($msg, Flags::SAVE_ERROR)->jsonEncode();
    } else{
      $msg = Yii::t('app', 'errorPlaylistExist');
      return Response::getInstance($msg, Flags::ALREADY_EXIST)->jsonEncode();
      }
  }

  public function actionView(){
    $id = Yii::$app->request->get('id');
    $env = Yii::$app->request->get('env');
    $ref = Yii::$app->request->get('ref');

    if ( Yii::$app->user->isGuest && !(isset($ref) && is_string($ref) && isset($env) && is_string($env)))
      return $this->redirect(['/site/login']);

    if ( !(isset($id) && is_numeric($id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $playlist = Playlist::findOne($id);

    $query = $playlist->getSongs();
    $service = new DataService();
    $service->setQuery($query);
    $segment = Yii::$app->request->get('segment');

    if (!$segment){
      $rows = $service->getData();
      $viewParams = [ 'songs' => $rows,
                      'env' => $env,
                      'playlist' => $playlist,
                      'lazyLoad' => [ 'route' => Url::to(['/playlist/playlist/view', 'id'=>$id, 'segment' => 1]),
                                      'visible' => !$service->isLastPage(),
                                    ]
                    ];

      if (isset($ref) && $ref == '_external'){
        return $this->renderPreview('songs', $viewParams);
      } else{
        $viewParams['externalSource'] = false;
        return $this->renderSection('songs', $viewParams);
      }
    } else{
      $rows = $service->getData($segment);
      $segment = $segment + 1;
      $infinite['status'] =  $service->isLastPage();
      $infinite['route'] = Url::to(['/playlist/playlist/view', 'id'=>$id, 'segment' => $segment]);
      $infinite['content'] = $this->renderSection('songs-lazy', [ 'songs' => $rows,
                                                                  'playlist_id' => $playlist->id]);

     return Response::getInstance($infinite, Flags::ALL_OK)->jsonEncode();
    }
  }

  public function actionDelete(){
    $id = Yii::$app->request->post('Playlist');

    if ( !(Yii::$app->request->isAjax && isset($id) && is_array($id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $stored = Playlist::findOne($id['id']);

    if ($stored->name != Playlist::FAVORITES){
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
  }

  public function actionUpdate(){
    $pl = Yii::$app->request->post('PlayList');

    if ( !(Yii::$app->request->isAjax && isset($pl) && is_array($pl)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $stored = Playlist::findOne($pl['id']);

    if ($stored->name != Playlist::FAVORITES){
      $stored->name = $pl['name'];
      $visibility = Visibility::findOne($pl['visibility']);
      if ($stored->visibility->id != $pl['visibility']){
        //$stored->unlinkAll('visibility');
        $stored->visibility_id = $visibility->id;
      }

      if ($stored && $stored->save()){
        $response['name'] = $stored->name;
        $response['id'] = $stored->id;
        $response['visibility'] = Yii::t('app', $visibility->type);
        return Response::getInstance($response, Flags::UPDATE_SUCCESS)->jsonEncode();
      }
      $modal = ModalBox::widget([
        'title' => 'Ops!',
        'content' => 'Se ha producido un error al eliminar la lista de reproducción. Contactese con el área de soporte para mas información.',
      ]);
      return Response::getInstance($modal, Flags::UPDATE_ERROR)->jsonEncode();
    }
  }

  public function actionModal(){
    $id = Yii::$app->request->get('id');
    $action = Yii::$app->request->get('action');
    $content;
    $title;
    $modal;

    if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id) && isset($action) && is_string($action)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


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
    $song_id = Yii::$app->request->get('entity');

    if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id) && isset($song_id) && is_numeric($song_id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    return $this->_addSongToCollection($song_id, $id);
  }

  public function actionAddAlbum(){}

  public function actionRemoveSong(){
    $pl = Yii::$app->request->post('Playlist');

    if ( !(Yii::$app->request->isAjax && isset($pl) && is_array($pl)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $pl_id = $pl['id'];
    $song_id = $pl['song'];

    $playlist = Playlist::findOne($pl_id);
    $song = Song::findOne($song_id);

    try {
        $playlist->unlink('songs', $song, true);
        $response = ['playlist' => $pl_id, 'song' => $song->id];
        return Response::getInstance($response, Flags::UNLINK_SUCCESS)->jsonEncode();
    } catch (Exception $e) {
        return Response::getInstance($e, Flags::ERROR_UPDATE_DB)->jsonEncode();
    }
  }


}
