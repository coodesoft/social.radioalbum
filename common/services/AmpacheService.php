<?php
namespace common\services;
use common\util\Requester;
use common\models\User;
use yii\helpers\Url;
use Yii;

class AmpacheService{

  private $catalog_manager_user = 'audio';

  private $catalog_manager_password = 'audio';

  private $server_url = "/ampache/server/xml.server.php?";

  private $token;

  private $session_expire = null;

  private function getMediaServerUrl(){
    return "http://".$_SERVER['SERVER_NAME']. $this->server_url;
  }

  private function getConnectionParams(){
    $time = time();
    $key = hash('sha256',$this->catalog_manager_password);
    $passphrase = hash('sha256', $time . $key);

    return [
      'timestamp' => $time,
      'action'    => 'handshake',
      'auth'      => $passphrase,
      'version'   => '380001',
      'user'      => $this->catalog_manager_user,
    ];
  }


  private function getMediaServerConnectionToken(){
    $actual_time = new \DateTime();
    if (($this->session_expire == null) || ($this->session_expire<$actual_time->getTimeStamp())){
      $params = $this->getConnectionParams();
      $connection = Requester::get($this->getMediaServerUrl(), $params);
      $session = simplexml_load_string($connection, null, LIBXML_NOCDATA);

      $this->session_expire = strtotime($session->session_expire);
      $this->token = $session->auth;
    }
    return $this->token;
  }

  private function buildChannelMirror($obj){
    $channel = array();
    $channel['id'] = $obj['id']->__toString();
    $channel['name'] = $obj->name->__toString();
    return $channel;
  }

  private function buildAlbumMirror($obj, $tags, $songs){
    $album = array();
    $channels = array();
    foreach($tags as $tag)
      $channels[] = $tag->__toString();

    $album['id'] = $obj['id']->__toString();
    $album['name'] = $obj->name->__toString();
    $album['art'] = $obj->art->__toString();
    $album['channels'] = $channels;

    $arrSongs = array();
    foreach($songs as $song){
      $mirror = $this->buildSongMirror($song);
      $arrSongs[] = $mirror;
    }
    $album['songs'] = $arrSongs;
    return $album;
  }

  private function buildSongMirror($obj){
    $props = array();
    $props['name']          = $obj->title->__toString();
    $props['path_song']     = $obj->filename->__toString();
    $props['id']            = $obj['id']->__toString();
    $props['time']          = $obj->time->__toString();
    $props['rate']          = $obj->rate->__toString();
    $props['bitrate']       = $obj->bitrate->__toString();
    $props['size']          = $obj->size->__toString();
    $props['album']         = $obj->album->__toString();

    return $props;
  }

  private function buildArtistMirror($obj){
    $artist = array();
    $artist['id'] = $obj['id']->__toString();
    $artist['name'] = $obj->name->__toString();
    $artist['presentation'] = $obj->summary->__toString();
    $artist['yearformed'] = $obj->yearformed->__toString();
    $artist['photo'] = $obj->art->__toString();

    $albums = array();
    foreach($obj->albums->album as $album){
      $albums[] = $album['id']->__toString();
    }
    $artist['album'] = $albums;

    return $artist;

  }

  private function getData($action, $params = null, $option = true){
    $token = $this->getMediaServerConnectionToken();

    if ($params == null)
      $params = ['auth' => $token, 'action' => $action];
    else{
      $params['auth'] = $token;
      $params['action'] = $action;
    }

    $session = Requester::get($this->getMediaServerUrl(), $params, $option);

    if ($option)
        return simplexml_load_string($session, null, LIBXML_NOCDATA);
    else
        return $session;
  }

  public function getChannels(){
    $tags = $this->getData('tags')->xpath('tag');
    $channels = array();
    foreach($tags as $tag){
      $mirror = $this->buildChannelMirror($tag);
      $channels[$mirror['id']] = $mirror;
    }

    return $channels;
  }

  public function getAlbums(){
    $ampacheAlbums = $this->getData('albums', ['include[]' => 'songs'])->xpath('album');
    $albums = array();
    foreach($ampacheAlbums as $ampacheAlbum){
      $tags = $ampacheAlbum->xpath('tag');
      $songs = $ampacheAlbum->xpath('tracks')[0]->song;
      $mirror = $this->buildAlbumMirror($ampacheAlbum, $tags, $songs);
      $albums[$mirror['id']] = $mirror;
    }

    return $albums;
  }

  public function getSongs(){
    $songs = $this->getData('songs', ['limit' => 'none'])->xpath('song');
    $arrSong = array();
    foreach($songs as $song){
        $mirror = $this->buildSongMirror($song);
        $arrSong[$mirror['id']] = $mirror;
    }
    return $arrSong;
  }

  public function getArtists(){
    $artistArray = $this->getData('artists', ['include[]' => 'albums'])->xpath('artist');
    $artists = array();
    foreach($artistArray as $ampacheArtist){
      $mirror = $this->buildArtistMirror($ampacheArtist);
      $artists[$mirror['id']] = $mirror;
    }
    return $artists;
  }


  public function getSongUrl($idSong){
    $result = $this->getData('song', ['filter' => $idSong])->xpath('song');
    $url = '';
    foreach($result as $rs)
        $url = $rs->url->__toString();

    return $url;

  /*  $user = User::findOne(Yii::$app->user->id);
    $timestamp = time();
    $username = $user->id;
    $password = $user->password_hash;

    $tokenSource = $timestamp . $username . $password;
    $token = Yii::$app->getSecurity()->generatePasswordHash($tokenSource);

    $params = 'id='.$idSong.'&t='.$timestamp.'&u='.$username.'&token='.$token;
    $url = 'http://localhost/mserver/web/index.php?r=media/song&'.$params;
    return $url;*/
  }

}
