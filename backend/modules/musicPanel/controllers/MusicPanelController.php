<?php
namespace backend\modules\musicPanel\controllers;

use Yii;
use yii\helpers\BaseJson;
use yii\filters\AccessControl;

use backend\models\Channel;
use backend\models\History;
use backend\controllers\RaBaseController;
use backend\modules\album\models\Album;
use backend\modules\playlist\models\Playlist;

use common\models\Song;
use common\models\User;
use common\util\Response;
use common\util\Flags;
use common\util\Requester;
use common\util\StrProcessor;


class MusicPanelController extends RaBaseController{

      public function behaviors(){
      return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                  [
                    'actions' => ['change-skin',
                                  'channels',
                                  'albums',
                                  'album',
                                  'album-art',
                                  'song',
                                  'linked-song',
                                  'playlist'],
                    'allow' => true,
                    'roles' => ['@'],
                  ],
            ],
        ],
      ];
    }


    private function buildCollectionMirror($collection){
      $mirror = array();
      $mirror['name'] = $collection->name;
      $mirror['id'] = $collection->id;
      foreach($collection->songs as $song)
        $mirror['songs'][] = ['name' => $song->name, 'id' => $song->id, 'status' => 0];

      return $mirror;
    }

    public function addNewHistoryRecord($profile, $song){
      $historyRecord = new History();
      $historyRecord->profile_id = (string) $profile;
      $historyRecord->song_id = (string) $song;
      $historyRecord->date = (string) time();

      $size = History::find()->where(['profile_id' => $profile])->count();

      if ($size >= History::MAX_HISTORY_SIZE){
        $toDelete = History::find()->where(['profile_id' => $profile])->limit(1)->one();
        if (!$toDelete->delete())
          return Flags::DELETE_ERROR;
      }

      if (!$historyRecord->save())
        return Flags::SAVE_ERROR;
      return Flags::ALL_OK;
    }

    public function actionChangeSkin($id){ }

    public function actionChannels(){
      $channels = Channel::find()->all();

      $mirror = array();
      foreach ($channels as $channel) {
        $mirror[$channel->id] = $channel->name;
      }
      return Response::getInstance($mirror, Flags::ALL_OK)->jsonEncode();
    }

    public function actionAlbums(){
      $id = Yii::$app->request->get('id');
      $channel = Channel::findOne($id);
      $albums = $channel->albums;
      $arrAlbum = array();

      foreach($albums as $album)
        $arrAlbum[] = ['id' => $album->id, 'status' => 0];

      $resp['channel'] = ['id'=>$channel->id, 'name' => $channel->name];
      $resp['albums'] = $arrAlbum;
      return Response::getInstance($resp, Flags::ALL_OK)->jsonEncode();
    }

    public function actionAlbum(){
      $id = Yii::$app->request->get('id');
      $album = Album::findOne($id);

      $mirror = $this->buildCollectionMirror($album);

      return Response::getInstance($mirror, Flags::ALL_OK)->jsonEncode();
    }

    public function actionAlbumArt(){
      $id = Yii::$app->request->get('id');
      $album = Album::findOne($id);
      return Yii::$app->response->sendContentAsFile(base64_encode($album->art), 'album-art', ['inline' => false, 'mimeType' => 'image/png']);
    }

    public function actionSong(){
        $ampache = Yii::$app->get('mediaServer');
        $id = Yii::$app->request->get('id');
        $song = Song::findOne($id);

        $url = $ampache->getSongUrl($song->id_referencia);
        $mixed = array();
        $mixed['url'] = $url;
        $mixed['name'] = $song->name;

        return Response::getInstance($mixed, Flags::ALL_OK)->jsonEncode();
    }

    public function actionLinkedSong(){
      $id = Yii::$app->request->get('id');
      $playlist_id = Yii::$app->request->get('playlist');
      $mirror = array();

      if (($playlist_id!=null) && is_numeric($playlist_id)){
        $collection = Playlist::findOne($playlist_id);
        $mirror['type'] = StrProcessor::functionalClassName(Playlist::className());
      }else {
        $song = Song::findOne($id);
        $collection = $song->album;
        $mirror['type'] = StrProcessor::functionalClassName(Album::className());
      }
      $songs = $collection->songs;
      $t=0;
      $position;
      $found = false;

      while($t<count($songs) && !$found){
        if ($songs[$t]->id == $id){
          $found = true;
          $position = $t;
        }
        $t++;
      }

      $mirror['song_position'] = $position;
      $mirror['collection_id'] = $collection->id;

      return Response::getInstance($mirror, Flags::ALL_OK)->jsonEncode();
    }

    public function actionPlaylist(){
      $id = Yii::$app->request->get('id');
      $collection = Playlist::findOne($id);
      $mirror = $this->buildCollectionMirror($collection);
      return Response::getInstance($mirror, Flags::ALL_OK)->jsonEncode();
    }
}

 ?>
