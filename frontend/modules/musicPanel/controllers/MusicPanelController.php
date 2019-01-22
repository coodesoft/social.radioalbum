<?php
namespace frontend\modules\musicPanel\controllers;

use Yii;
use yii\helpers\BaseJson;
use yii\helpers\Url;
use yii\filters\AccessControl;

use common\models\User;
use common\util\Response;
use common\util\Flags;
use common\util\Requester;
use common\util\StrProcessor;

use frontend\models\Song;
use frontend\models\History;
use frontend\controllers\RaBaseController;
use frontend\modules\channel\models\Channel;
use frontend\modules\album\models\Album;
use frontend\modules\playlist\models\Playlist;



class MusicPanelController extends RaBaseController{

      public function behaviors(){
      return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                  [ 'actions' => ['channels',
                                  'albums',
                                  'album-art',
                                  ],
                    'allow' => true,
                    'roles' => ['@'],
                  ],
                  [
                    'actions' => [ 'album',
                                   'song',
                                   'linked-song',
                                   'playlist'
                                 ],
                    'allow' => true,
                    'roles' => ['?', '@'],
                  ]

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

    public function actionChannels(){
      if (!Yii::$app->request->isAjax)
        return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

      $channels = Channel::find()->all();

      $mirror = array();
      foreach ($channels as $channel) {
        $mirror[$channel->id] = [
          'name' => $channel->name,
          'urlView' => Url::to(['/channel/channel/view', 'id' => $channel->id]),
        ];
      }
      return Response::getInstance($mirror, Flags::ALL_OK)->jsonEncode();
    }

    public function actionAlbums(){
      $id = Yii::$app->request->get('id');

      if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id)) )
        return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

      $channel = Channel::findOne($id);
      $albums = $channel->albums;
      $arrAlbum = array();

      foreach($albums as $album)
        $arrAlbum[] = [
          'id' => $album->id,
          'status' => 0,
        ];

      $resp['channel'] = [
        'id' => $channel->id,
        'name' => $channel->name,
        'urlView' => Url::to(['/channel/channel/view', 'id' => $channel->id]),
      ];
      $resp['albums'] = $arrAlbum;
      return Response::getInstance($resp, Flags::ALL_OK)->jsonEncode();
    }

    public function actionAlbum(){
      $id = Yii::$app->request->get('id');

      if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id)) )
        return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

      $album = Album::findOne($id);

      $mirror = $this->buildCollectionMirror($album);
      $artistLabel = '';
      foreach($album->artists as $artist){
        $mirror['artist'] = $artist->name;
        $mirror['urlArtistView'] = Url::to(['/artist/artist/view', 'id' => $artist->id]);
      }
      $mirror['urlView'] = Url::to(['/album/album/view', 'id' => $album->id]);
      $mirror['urlAdd']  = Url::to(['/user/user/create-playlist', 'id' => $album->id]);
      $mirror['urlShare'] = Url::to(['/user/share/target', 'content' => 'album', 'id' => $album->id]);

      return Response::getInstance($mirror, Flags::ALL_OK)->jsonEncode();
    }

    public function actionAlbumArt(){
      $id = Yii::$app->request->get('id');
      if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id)) )
        return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

      $album = Album::findOne($id);
      $filename = Album::dataPath() . $album->art;

      $mixed['thumb'] = Url::to(['/ra/thumbnail', 'id' => $album->art, 'entity' => 'album']);
      $mixed['link'] = Url::to(['/album/album/view', 'id' => $album->id]);

      return Response::getInstance($mixed, Flags::ALL_OK)->jsonEncode();
    }

    public function actionSong(){
        $ampache = Yii::$app->get('mediaServer');
        $id = Yii::$app->request->get('id');

        if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id)) )
          return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


        $song = Song::findOne($id);

        $url = $ampache->getSongUrl($song->id);
        $mixed = array();
        $mixed['url'] = $url;
        $mixed['urlAdd'] = Url::to(['/user/user/modal', 'action' => 'add-song-to-playlist', 'id' => $song->id]);
        $mixed['urlFav'] = Url::to(['/playlist/playlist/add-to-favs', 'id' => $song->id]);
        $mixed['name'] = $song->name;

        $user = User::findOne(Yii::$app->user->id);
        $profile = $user->getAssociatedModel()->profile;

        $status = $this->addNewHistoryRecord($profile->id, $song->id);


        return Response::getInstance($mixed, $status)->jsonEncode();
    }

    public function actionLinkedSong(){
      $id = Yii::$app->request->get('id');

      if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id)) )
        return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

      $playlist_id = Yii::$app->request->get('playlist');
      $mirror = array();

      if (($playlist_id!=null) && is_numeric($playlist_id)){
        $collection = Playlist::findOne($playlist_id);
        $mirror['owner'] = $collection->profile->name + " " + $collection->profile->last_name;
        $mirror['type'] = StrProcessor::functionalClassName(Playlist::className());
      }else {
        $song = Song::findOne($id);
        $collection = $song->album;
        $artistLabel = '';
        foreach($collection->artists as $artist){
          $artistLabel .= $artist->name. ' - ';
        }

        $mirror['artist'] = $artistLabel;
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

      if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id)) )
        return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

      $collection = Playlist::findOne($id);
      $mirror = $this->buildCollectionMirror($collection);
      $mirror['artist'] = 'Mixed';
      return Response::getInstance($mirror, Flags::ALL_OK)->jsonEncode();
    }
}

 ?>
