<?php
namespace admin\models;

use Yii;
use yii\base\Model;
use common\util\RAFileHelper;
use common\util\Response;
use common\util\Flags;
use common\util\StrProcessor;

use admin\modules\tagEditor\services\TagEditorService;
use backend\modules\album\models\Album;
use backend\modules\artist\models\Artist;
use backend\models\Song;

class EditAlbumSongsForm extends Model{

    public $id;

    public $songs;

    public $songsToDelete;

    public $songsToEdit;

    public $songsToOrder;

    private $uploadRoute;

    private $album;

    public function __construct( $config = [] ){
      $this->uploadRoute = Yii::getAlias('@catalog') . "/";

      parent::__construct();
    }

    public function rules(){
        return [
            [['id'], 'required'],
            [['songs'], 'file', 'skipOnEmpty' => true, 'extensions' => 'mp3', 'maxFiles' => 20],
            ['songsToDelete', 'each', 'rule' => ['string']],
            ['songsToEdit', 'each', 'rule' => ['string']],
            ['songsToOrder', 'each', 'rule' => ['string']],

        ];
    }

    public function attributeLabels(){
        return [
            'songs' => \Yii::t('app', 'canciones'),
        ];
    }

    private function uploadSongs(){
      foreach ($this->album->artists as $key => $artist) {
        $artistName = $artist->name;
      }

      $newFolder = $this->uploadRoute . strtolower($artistName)."/" . $this->album->name;
      $errors = [];
      foreach ($this->songs as $key => $songFile) {
        $songPath = $newFolder ."/". $songFile->baseName . '.' . $songFile->extension;
        if (! $songFile->saveAs($songPath) ) {
          $errors[] = ['La canción '.$songFile->baseName.' no se pudo subir'];
        } else{
          $tagEditor = new TagEditorService(['mp3']);
          $metadata = $tagEditor->getAudioFileInfo($songPath, 'audio');

          $song = new Song();
          $song->name = $songFile->baseName;
          $song->path_song = $songPath;
          $song->time = intval( $tagEditor->getAudioFileInfo($songPath, 'playtime_seconds') );
          $song->rate = $metadata['sample_rate'];
          $song->bitrate = intval( $metadata['bitrate'] );
          $song->size = intval( $tagEditor->getAudioFileInfo($songPath, 'filesize') );
          try {
              $this->album->link('songs', $song);
          } catch (yii\base\InvalidCallException $e) {
              throw new \Exception('Se genero un error al linkear el album y la cancion '.$songFile->baseName.', con el siguiente mensaje de error: '.$e->getName(), 1);
          }
        }
      }

      if (count($errors) == 0)
        return Response::getInstance('true', Flags::UPLOAD_SUCCESS);
      else {
        return Response::getInstance($errors, Flags::UPLOAD_ERROR);
      }
    }

    private function deleteSongs(){
      $errors = [];
      if ($this->songsToDelete){
        foreach ($this->album->songs as $key => $song) {
          if (array_key_exists($song->id, $this->songsToDelete)){

            unset($this->songsToDelete[$song->id]);
            if ( unlink($song->path_song)){
              try {
                $this->album->unlink('songs', $song);
              } catch (yii\base\InvalidCallException $e) {
                $errors[] = 'Error eliminando la cancion: '.$song->name.". Detalle: ".$e->getMEssage();
              }
            }

          }
        }
        if ( count($errors)==0 )
          return Response::getInstance(true, Flags::DELETE_SUCCESS);
        return Response::getInstance($errors, Flags::DELETE_ERROR);
      }

      return Response::getInstance(true, Flags::ALL_OK);

    }

    private function updateSongs(){
      $errors = [];
      foreach ($this->songsToEdit as $key => $toEdit) {
        $song = Song::findOne($key);
        if ( $song ){
          $song->name = $toEdit;
          if ( !$song->save() )
            $errors[] = 'Se produjo un error al guardar la canción: '. $song->name.' Detall: '.json_encode($song->errors);
        } else
          $errors[] = 'La canción con id: '.$key.' no se puede localizar.';
      }

      if ( count($errors) == 0)
        return Response::getInstance(true, Flags::UPDATE_SUCCESS);
      return Response::getInstance($errors, Flags::UPDATE_ERROR);
    }

    public function edit(){
        if ( $this->validate() ){
          $this->album = Album::findOne($this->id);
          if ($this->album){
            $errors = [];
            $isError = false;

            $uResponse = $this->uploadSongs();
            if ($uResponse->getFlag() == Flags::UPLOAD_ERROR){
              $errors = array_merge($errors, $uResponse->getResponse());
              $isError = true;
            }

            $dResponse = $this->deleteSongs();
            if ($dResponse->getFlag() == Flags::UPLOAD_ERROR){
              $errors = array_merge($errors, $dResponse->getResponse());
              $isError = true;
            }

            $eResponse = $this->updateSongs();
            if ($eResponse->getFlag() == Flags::UPLOAD_ERROR){
              $errors = array_merge($errors, $eResponse->getResponse());
              $isError = true;
            }

            if ($isError)
              return Response::getInstance($errors, Flags::ERROR);

            return Response::getInstance(true, Flags::ALL_OK);
          }
          return Response::getInstance('No se encuentra el álbum que desea editar', Flags::ERROR);
        }
        return Response::getInstance($this->errors, Flags::UPDATE_ERROR);
    }


}
