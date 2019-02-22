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

class UploadAlbumForm extends Model{

    public $songs;

    public $image;

    public $name;

    public $year;

    public $artist;

    public $storedArtist;

    public $channels;

    private $uploadRoute;

    public function __construct( $config = [] ){
      $this->uploadRoute = Yii::getAlias('@catalog') . "/";

      parent::__construct();
    }

    public function rules(){
        return [
            [['name', 'channels'], 'required'],
            [['artist'], 'string', 'max' => 200],
            [['storedArtist'], 'string', 'max' => 10],
            ['year', 'string', 'skipOnEmpty' => true],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, ico, jpeg'],
            [['songs'], 'file', 'skipOnEmpty' => false, 'extensions' => 'mp3', 'maxFiles' => 20],
        ];
    }

    public function attributeLabels(){
        return [
            'songs' => \Yii::t('app', 'canciones'),
            'name' =>  \Yii::t('app', 'name'),
            'image' => \Yii::t('app', 'albumArt'),
            'year' =>  \Yii::t('app', 'year'),
            'channels' => \Yii::t('app', 'selectChannels'),
            'artist' => \Yii::t('app', 'artista'),
            'storedArtist' => \Yii::t('app', 'storedArtist')
        ];
    }

    public static function getYearsRange(){
      $years = array();
      $initial = 1950;
      $current = date("Y");

      for ($i = $initial; $i <= $current ; $i++) {
        $years[$i] = $i;
      }

      return $years;
    }

    public function setAlbumTags($path){
      $tagEditor = new TagEditorService(['mp3']);
      $tags = array();
      $tags['artist'] = $this->artist;
      $tags['year']   = $this->year;
      $tags['album']  = $this->name;
      $tags['genre']  = $this->channels;
      return $tagEditor->setDirectoryTags($path, $tags);
    }

    public function upload(){
        if ( $this->validate() ){
            $artist = null;
            //recupero el artista enviado
            $query = $this->storedArtist ? ['id' => $this->storedArtist] : "LOWER(name) = '".strtolower($this->artist)."'";
            $artist = Artist::find()->where($query)->one();

        
            $stored = null;
            if ($artist)
              $stored = $artist->getAlbumByName($this->name)->all();

            if (!$stored){
                $artistName = $artist ? $artist->name : $this->artist;
                $newFolder = $this->uploadRoute . strtolower($artistName)."/" . $this->name;

                //creo el directorio del álbum
                RAFileHelper::createDirectory($newFolder);

                $album = new Album();
                $album->name = $this->name;
                $album->status = 1;

                //guardado de la portada del álbum
                if ($this->image){
                    $album->art = StrProcessor::getRandomString($album->name);;
                    //guardo la imagen de portada dentro del directorio de imágenes
                    $this->image->saveAs(Album::dataPath() . $album->art);
                }

                //comienzo a almacenar en la db
                $transaction = Album::getDb()->beginTransaction();
                if ($album->save()){

                    foreach ($this->channels as $name){
                       //recupero los canales almacenados
                       $channel = Channel::findOne(['name' => $name]);

                       // Chequeo que el canal exista.
                       // En teoría siempre debiera existir, puesto que los canales
                       // sobre los que loopeo son recuperados desde la db y
                       // enviados a traves del form.
                       if (!$channel){
                           $channel = new Channel();
                           $channel->name = $name;

                           // Si no lo puedo guardar, borro el directorio y lanzo una excepción
                           if (!$channel->save()){
                               RAFileHelper::removeDirectory($newFolder);
                               throw new \Exception("Se detecto un canal nuevo pero no se pudo guardar", 1);
                           }
                       }
                    }

                    //Es posible que el artista enviado no este previamente almacenado
                    if (!$artist){
                       // Creamos una instancia minimalista del Artista.
                       $artist = Artist::createDefault();
                       $artist->name = $this->artist;

                       // Si no lo puedo guardar, borro el directorio y lanzo una excepción
                       if (!$artist->save()){
                           RAFileHelper::removeDirectory($newFolder);
                           throw new \Exception("Se detecto un artista nuevo pero no se pudo guardar", 1);
                       }
                    }

                    try {
                        $album->link('channels', $channel);
                        $album->link('artists', $artist);
                    } catch (yii\base\InvalidCallException $e) {
                        RAFileHelper::removeDirectory($newFolder);
                        $transaction->rollBack();
                        throw new \Exception('Se genero un error al linkear el album con el artista/canal, con el siguiente mensaje de error: '.$e->getName(), 1);
                    }

                    foreach ($this->songs as $songFile) {
                        $songPath = $newFolder ."/". $songFile->baseName . '.' . $songFile->extension;
                        $songFile->saveAs($songPath);

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
                            $album->link('songs', $song);
                        } catch (yii\base\InvalidCallException $e) {
                            RAFileHelper::removeDirectory($newFolder);
                            $transaction->rollBack();
                            throw new \Exception('Se genero un error al linkear el album la cancion '.$songFile->baseName.', con el siguiente mensaje de error: '.$e->getName(), 1);
                        }
                    }
                    $transaction->commit();
                    return Response::getInstance(true, Flags::ALL_OK);
                }

                RAFileHelper::removeDirectory($newFolder);
                $transaction->rollBack();
                return Response::getInstance(false, Flags::SAVE_ERROR);
            }
            return Response::getInstance('El artista ya tiene un álbum con ese nombre', Flags::SAVE_ERROR);
        }
        return Response::getInstance($this->errors, Flags::SAVE_ERROR);
    }


}
