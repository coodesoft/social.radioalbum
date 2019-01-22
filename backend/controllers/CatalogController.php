<?php
namespace backend\controllers;

use Yii;
use yii\helpers\BaseJson;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use backend\modules\artist\models\Soloist;
use backend\modules\artist\models\Band;
use backend\modules\album\models\Album;

use common\util\Requester;
use common\util\Flags;
use common\util\Response;

use common\models\User;
use common\models\Operation;

use backend\models\Song;
use backend\models\Channel;
use backend\models\Profile;
use backend\models\ProfileOpts;
/**
 * Site controller
 */
class CatalogController extends RaBaseController{

  public $layout = 'main_logged';

  private $catalog_manager_user = 'backuser';

  private $catalog_manager_password = 'osvaldo';

  private $server_url = "/ampache/server/xml.server.php?";

  private $token;

  private $session_expire = null;

  private $opActions = ['media' => 'migrate_catalog',
                        'artists' => 'migrate_artists'
                      ];


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

  private function getMediaServerData($action, $params = null, $option = true){
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

  private function diffXMLElementArrayByProperties($origin, $destiny, $props, $callback = null){
    $toUpdate = array();
    $update = false;
    $callable = array();
    foreach($origin as $t => $oElement)
      foreach($destiny as $c => $dElement){
          if ($oElement['id']->__toString() == $dElement->id_referencia){
            if ($callback != null) $callback($oElement, $dElement);
            foreach($props as $prop){
              if (($oElement->{$prop}->__toString() != $dElement->{$prop})){
                $dElement->{$prop} = $oElement->{$prop}->__toString();
                $update = true;
              }
            if ($update){
              $toUpdate[] = $dElement;
              $update = false;
            }
          }
          unset($origin[$t]);
          unset($destiny[$c]);
        }
      }

      return ['update' => $toUpdate,
              'origin' => $origin,
              'destiny' => $destiny];
  }

  private function diffArrayByProperties($origin, $destiny, $props){
    $toUpdate = array();
    $update = false;
    foreach($origin as $t => $oElement)
      foreach($destiny as $c => $dElement){
          if ($oElement['id_referencia'] == $dElement['id_referencia']){
            foreach($props as $prop)
              if ($oElement[$prop] != $dElement[$prop]){
                $dElement[$prop] = $oElement[$prop];
                $update = true;
              }
            if ($update){
              $toUpdate[] = $dElement;
              $update = false;
            }
            unset($origin[$t]);
            unset($destiny[$c]);
            break;
          }
      }

      return ['update' => $toUpdate,
              'origin' => $origin,
              'destiny' => $destiny];
  }

  private function updateMassiveModel($array, $action, $callback = null){
    $errors = array();
    foreach($array as $obj){
      if ($callback != null)
        $callback($obj);
      if (!$obj->{$action}())
        $errors[] = ['ref' => $obj->id_referencia, 'error' => $obj->errors];
    }
    return $errors;
  }

  private function addNewArtists(){
    $artists = Yii::$app->request->post('newArtists');
    $errors = array();
    if (isset($artists)){
      foreach($artists as $k => $artist){
        if (isset($artist['type'])){
          $stored = $artist['type']::findOne(['id_referencia' => $k]);
          //pregunto si no tengo previamente almacenado al mismo artista referenciado por id_referencia
          if ($stored == null){
            $transaction = $artist['type']::getDb()->beginTransaction();
            try{
                $model = new $artist['type']();
                $model->id_referencia = $k;
                $model->name = substr($artist['name'], 0, 45);
                $model->presentation = "".substr($artist['presentation'], 0, 400)."";
                $model->begin_date = "".(new \DateTime())->getTimeStamp()."";

                $profile = new Profile();
                $profile->name = $model->name;
                $profile->photo = Requester::get($artist['photo_url']);

                $opts = new ProfileOpts();
                $opts->begin_date = 1;
                $opts->presentation = 1;
                $opts->full_name = 1;
                $opts->save();

                $profile->options_id = $opts->id;
                $profile->save();
                $model->profile_id = $profile->id;

                foreach(BaseJson::decode($artist['albums']) as $album){
                  $al = Album::findOne(['id_referencia'=>$album]);
                  if ($model->validate()){
                    $model->save();
                    $model->link('albums',$al);
                  }
                  else
                    $errors[] = ['artista' => $model->name, 'error' =>$model->errors];
                }
                $transaction->commit();
                unset($artists[$k]);
            } catch(\Exception $e){
              $transaction->rollBack();
              throw $e;
            } catch (\Throwable $e){
              $transaction->rollBack();
              throw $e;
            }
          }
        }
      }
    }
    return $errors;
  }

  private function updateArtists(){
    $artists = Yii::$app->request->post('updateArtists');
    $errors = array();
    if (isset($artists)){
      foreach($artists as $k => $artist){
        $transaction = $artist['type']::getDb()->beginTransaction();
        try{
          $stored = $artist['type']::findOne(['id_referencia' =>$k]);

          if (isset($artist['name']['opt'])){
            $stored->name = substr($artist['name']['val'], 0, 45);
            $stored->profile->name = $stored->name;
          }

          if (isset($artist['photo_url']['opt'])){
            $stored->profile->photo = Requester::get($artist['photo_url']['val']);
          }

          if (isset($artist['presentation']['opt']))
            $stored->presentation = "".substr($artist['presentation']['val'], 0, 400)."";

          if (isset($artist['albums']['opt'])){
              $albums = BaseJson::decode($artist['albums']['val']);
              foreach($stored->albums as $artistAlbum){
                $cortar = false;
                foreach($albums as $t => $album){
                  if ($artistAlbum->id_referencia == $album){
                      unset($albums[$t]);
                      $cortar = true;
                      break;
                  }
                }

                if (!$cortar)
                  $stored->unlink('albums', $artistAlbum, true);
              }
              foreach($albums as $album_id){
                $newAlbum = Album::findOne(['id_referencia' =>$album_id]);
                $stored->link('albums', $newAlbum);
              }
          }

          if ($stored->profile->update() === false){
            $errors['update'][] = ['artista' => $stored->name, 'error' =>$stored->profile->errors];
          }

          if ($stored->update() === false)
            $errors['update'][] = ['artista' => $stored->name, 'error' =>$stored->errors];

          $transaction->commit();
        } catch(\Exception $e){
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e){
            $transaction->rollBack();
            throw $e;
        }
      }
    }
    return $errors;
  }

  private function deleteArtists(){
    $toDelete = Yii::$app->request->post('deleteArtists');
    $errors = array();
    if (isset($toDelete)){
      foreach($toDelete as $id => $type){

        $artist = $type::findOne($id);

        $transaction = $type::getDb()->beginTransaction();
        try{
          $profile = Profile::findOne($artist->profile_id);
          $opts = ProfileOpts::findOne($profile->options_id);
          $artist->unlinkAll('albums', true);

          if (!$artist->delete() && !$profile->delete() && !$opts->delete())
            $errors['delete'][] = ['ref' => $id, 'error' => $artist->errors];
          $transaction->commit();
        } catch(\Exception $e){
          $transaction->rollBack();
          throw $e;
        } catch (\Throwable $e){
          $transaction->rollBack();
          throw $e;
        }
      }
    }
    return $errors;
  }
  //Es necesario que $tags sea de tipo XMLSimpleElement
  private function createChannels($tags = null){
     $errors = array();
     if ($tags === null)
       $tags = $this->getMediaServerData('tags')->xpath('tag');

     foreach($tags as $tag){
       $stored = Channel::findOne(['id_referencia' => $tag['id']->__toString()]);
       if ($stored == null){
         $ch = new Channel();
         $ch->name = $tag->name->__toString();
         $ch->id_referencia = $tag['id']->__toString();
         if (!$ch->save())
           $errors['add'][] = ['ref' => $ch->id_referencia, 'error' => $ch->errors];
       }
     }

     if (count($errors)>0)
       return Response::getInstance($errors, Flags::ERROR_UPDATE_DB);
     else
       return Response::getInstance(true, Flags::ALL_OK);
  }

  //Es necesario que $albums sea de tipo XMLSimpleElement
  private function createAlbums($albums = null){
     $errors = array();
     if ($albums === null)
       $albums = $this->getMediaServerData('albums')->xpath('album');

     foreach($albums as $album){
       $stored = Album::findOne(['id_referencia' => $album['id']->__toString()]);
       if ($stored == null){
         $a = new Album();
         $a->name = $album->name->__toString();
         $a->art = Requester::get($album->art->__toString());
         $a->year = $album->year->__toString();
         $a->id_referencia = $album['id']->__toString();

         if (!$a->save())
           $errors['add'][] = ['ref' => $a->id_referencia, 'error' => $a->errors];
         else{
           $chs = $album->xpath('tag');
           foreach($chs as $ch){
             $channel = Channel::findOne(['id_referencia' => $ch['id']->__toString()]);
             $a->link('channels', $channel);
           }
         }
       }
     }
     if (count($errors)>0)
       return Response::getInstance($errors, Flags::ERROR_UPDATE_DB);
     else
       return Response::getInstance(true, Flags::ALL_OK);
  }

  private function updateChannels(){
     $channels = Channel::find()->all();
     $tags = $this->getMediaServerData('tags')->xpath('tag');
     $errors = array();
     $diff = $this->diffXMLElementArrayByProperties($tags, $channels, ['name']);
     //creo los canales que no estan en radioalbum.
     //almacenados en el array $diff['origin']
     $result = $this->createChannels($diff['origin']);

     if ($result->getFlag() != Flags::ALL_OK)
       $errors = $result->getResponse();
     //actualizo los canales que presentan cambios en su nombre
     foreach($diff['update'] as $toUpdate)
       if (!$toUpdate->save())
         $errors['update'][] = ['ref' => $toUpdate->id_referencia, 'error' => $toUpdate->errors];
     //borro los canales que estan en radioalbum pero no en ampache
     foreach($diff['destiny'] as $toDelete){
       $albums = $toDelete->albums;
       //por cada album asociado al canal, lo deslinkeo
       foreach($albums as $album)
         $toDelete->unlink('albums', $album, true);

       if (!$toDelete->delete())
         $errors['delete'][] = ['ref' => $toDelete->id_referencia, 'error' => $toDelete->errors];
     }

     if (count($errors)>0)
       return Response::getInstance($errors, Flags::ERROR_UPDATE_DB);
    else
       return Response::getInstance(true, Flags::ALL_OK);
  }

  private function updateAlbums(){
     $aBase = Album::find()->with(['channels'])->all();
     $albums = $this->getMediaServerData('albums')->xpath('album');
     $errors = array();
     $diff = $this->diffXMLElementArrayByProperties($albums, $aBase, ['name'],
      //Esta funcion se ejecuta solo cuando el álbum de ampache y del de radioalbum
      //son el mismo(albumAmpache->id == albumRA->id_referenica)
       function($ref, $obj){
           $tags = $ref->xpath('tag');
           foreach($obj->channels as $channel){
             $unlink = true;
             foreach($tags as $t => $tag){
               if ($tag->__toString() == $channel->name){
                 unset($tags[$t]);
                 $unlink = false;
                 break;
               }
             }
             if ($unlink){
               $obj->unlink('channels', $channel, true);
             }
           }

           foreach($tags as $tag){
             $tg = Channel::findOne(['name' => $tag->__toString()]);
             $obj->link('channels', $tg);
         }
     });

     $result = $this->createAlbums($diff['origin']);

     if ($result->getFlag() != Flags::ALL_OK)
       $errors = $result->getResponse();

     foreach($diff['destiny'] as $toDelete){
       $toDelete->unlinkAll('channels', true);

       if (isset($toDelete->bands))
        $toDelete->unlinkAll('bands', true);

       if (isset($toDelete->soloists))
        $toDelete->unlinkAll('soloists', true);

        if (isset($toDelete->songs)){
          $songs = $toDelete->songs;
          foreach($songs as $song){
            $song->unlinkAll('playlists', true);
          //  $song->unlinkAll('genres', true);
          }
         $toDelete->unlinkAll('songs', true);
       }

       if (!$toDelete->delete())
        $errors['delete'][] = ['ref' => $obj->id_referencia, 'error' => $obj->errors];
     }

     $updated = $this->updateMassiveModel($diff['update'], 'save');
     if (count($updated)>0)
       $errors['update'] = $updated;

     if (count($errors)>0)
       return Response::getInstance($errors, Flags::ERROR_UPDATE_DB);
     else
       return Response::getInstance(true, Flags::ALL_OK);

   }

  private function updateSongs(){
     $albums = Album::find()->with('songs')->all();
     $errors = array();
     $storedSongs = array();
     $arrSong = array();
     foreach($albums as $album){
       $songs = $this->getMediaServerData('album_songs', ['filter' => $album->id_referencia])->xpath('song');
       foreach($songs as $song){
           $props = array();
           $props['name'] = $song->title->__toString();
           $props['path_song'] = $song->filename->__toString();
           $props['id_referencia'] = $song['id']->__toString();
           $props['album_id'] = $album->id;
           $props['time'] = $song->time->__toString();
           $props['rate'] = $song->rate->__toString();
           $props['bitrate'] = $song->bitrate->__toString();
           $props['size'] = $song->size->__toString();
           $arrSong[] = $props;
       }
     }
     foreach($albums as $album)
       foreach($album->songs as $song)
         $storedSongs[] = $song;

     $diff = $this->diffArrayByProperties($arrSong, $storedSongs, ['name', 'path_song', 'time', 'rate', 'bitrate', 'size']);

     $arrSong = $diff['origin'];
     $toDelete = $diff['destiny'];
     $toUpdate = $diff['update'];

     $deleted = $this->updateMassiveModel($toDelete, 'delete', function($obj){
       if (!empty($obj->playlists))
          $obj->unlinkAll('playlists', true);
       if (!empty($obj->genres))
          $obj->unlinkAll('genres', true);
     });

     if (count($deleted)>0)
       $errors['toDelete'] = $deleted;

     $updated = $this->updateMassiveModel($toUpdate, 'save');
       if (count($updated)>0)
         $errors['toUpdate'] = $updated;

     $cols = ['name', 'path_song','id_referencia', 'album_id', 'time', 'rate', 'bitrate', 'size'];
     $result = Yii::$app->db->createCommand()->batchInsert('song', $cols, $arrSong)->execute();
     if (count($arrSong) != $result)
       $errors['add'][] = ['# de Canciones no agregadas: '. (count($arrSong) - $result)];

     if (count($errors)>0)
         return Response::getInstance($errors, Flags::ERROR_UPDATE_DB);
     else
         return Response::getInstance(true, Flags::ALL_OK);
   }

  /*
   * **** Public Methods ****
   */

  public function actionMultimediaMigration(){
    if (Yii::$app->request->isAjax){
      $op = Operation::findOne(['name' => $this->opActions['media']]);
      if ($op->status == Operation::STATUS_INITIAL)
        $populate = true;
      else
        $populate = false;
      return $this->renderSection('media', ['isProcessed' => false, 'populate' => $populate]);

    } else
      return $this->redirect(['ra/main']);
  }

  public function actionPopulateMultimedia(){
    if (Yii::$app->request->isAjax){
      $channel = $this->createChannels();
      $album = $this->createAlbums();
      $song = $this->updateSongs();

    if ($channel->getFlag() == Flags::ALL_OK &&
        $song->getFlag() == Flags::ALL_OK &&
        $album->getFlag() == Flags::ALL_OK){
        $op = Operation::findOne(['name' => $this->opActions['media']]);
        $op->status = Operation::STATUS_COMPLETE;
        $op->save();
    } elseif ($channel->getFlag() == Flags::ALL_OK ||
              $song->getFlag() == Flags::ALL_OK ||
              $album->getFlag() == Flags::ALL_OK){
              $op = Operation::findOne(['name' => $this->opActions['media']]);
              $op->status = Operation::STATUS_PARTIAL;
              $op->save();
    }
    return $this->renderSection('media', [
      'isProcessed' => true,
      'channel'   => $channel,
      'album'  => $album,
      'song' => $song]);
    } else
      return $this->redirect(['ra/main']);
  }

  public function actionUpdateMultimedia(){
    if (Yii::$app->request->isAjax){
      $channel = $this->updateChannels();
      $album = $this->updateAlbums();
      $song = $this->updateSongs();

    return $this->renderSection('media', [
                  'isProcessed' => true,
                  'channel'   => $channel,
                  'album'  => $album,
                  'song' => $song]);
    } else
      return $this->redirect(['ra/main']);
  }

  public function actionLala(){
    $albums = $this->getMediaServerData('tags')->xpath('tag');
    return  BaseJson::encode($albums);
  //  return  BaseJson::encode([$arrSong, $storedSongs]);
  }

  public function actionArtistsMigration(){
    if (Yii::$app->request->isAjax){
      $artists = $this->getMediaServerData('artists', ['include[]' => 'albums'])->xpath('artist');
      $soloists = Soloist::find()->all();
      $bands = Band::find()->all();

      $arrArtist = array();
      foreach($artists as $artist){
        $ID = $artist['id']->__toString();
        $newArtist = array();
        $newArtist['id'] = $ID;
        $newArtist['photo_url'] = $artist->art->__toString();
        $newArtist['name'] = $artist->name->__toString();
        $newArtist['presentation'] = $artist->summary->__toString();

        $newAlbums = array();
        $albums = $artist->xpath('albums')[0];
        foreach($albums->album as $album){
          $newAlbums[] = $album['id']->__toString();
        }
        $newArtist['albums'] = $newAlbums;

        $exist = false;
        $objClass = null;
        foreach($soloists as $i => $soloist)
          if ($soloist->id_referencia == $ID){
            $exist = true;
            $objClass = get_class($soloist);
            unset($soloists[$i]);
            break;
          }

        if (!$exist)
          foreach($bands as $i => $band)
            if ($band->id_referencia == $ID){
              $exist = true;
              $objClass = get_class($band);
              unset($bands[$i]);
              break;
            }

        if ($exist == false){
          $arrArtist['new'][$ID] = $newArtist;
        } else{
          $newArtist['type'] = $objClass;
          $arrArtist['update'][$ID] = $newArtist;
        }
      }
      foreach($soloists as $soloist){
        $toDelete = array();
        $toDelete['id'] = $soloist->id;
        $toDelete['name'] = $soloist->name;
        $toDelete['type'] = get_class($soloist);
        $arrArtist['delete'][] = $toDelete;
      }

      foreach($bands as $band){
        $toDelete = array();
        $toDelete['id'] = $band->id;
        $toDelete['name'] = $band->name;
        $toDelete['type'] = get_class($band);
        $arrArtist['delete'][] = $toDelete;
      }
      return $this->renderSection('artists', ['artists' =>$arrArtist, 'isProcessed' => false]);
    } else {
      return $this->redirect(['ra/main']);
    }
  }

  public function actionPopulateArtists(){
    if (Yii::$app->request->isAjax){
      $addErrors = $this->addNewArtists();
      $updateErrors = $this->updateArtists();
      $deleteErrors = $this->deleteArtists();
      return $this->renderSection('artists', ['addErrors' => $addErrors,
                                           'updateErrors' =>$updateErrors,
                                           'deleteErrors' => $deleteErrors,
                                           'isProcessed' => true]);
    } else
      return $this->redirect(['ra/main']);
  }

}
