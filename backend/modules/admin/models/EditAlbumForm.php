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

class EditAlbumForm extends Model{

    public $id;

    public $songs;

    public $image;

    public $name;

    public $year;

    public $channels;

    public $description;

    public $status;

    private $uploadRoute;

    public function __construct( $config = [] ){
      $this->uploadRoute = Yii::getAlias('@catalog') . "/";

      parent::__construct();
    }

    public function rules(){
        return [
            [['name', 'channels', 'status', 'id'], 'required'],
            ['year', 'string', 'skipOnEmpty' => true],
          //  ['songsToDelete', 'each', 'rule' => ['integer']],
            ['description', 'string', 'skipOnEmpty' => true],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, ico, jpeg'],
        ];
    }

    public function attributeLabels(){
        return [
            'songs' => \Yii::t('app', 'canciones'),
            'name' =>  \Yii::t('app', 'name'),
            'image' => \Yii::t('app', 'albumArt'),
            'year' =>  \Yii::t('app', 'year'),
            'channels' => \Yii::t('app', 'selectChannels'),
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

    public function edit(){
        if ( $this->validate() ){
          $errors = [];
          $transaction = Album::getDb()->beginTransaction();

          $album = Album::findOne($this->id);

          $album->name = $this->name;
          $album->year = $this->year;
          $album->description = $this->description;
          $album->status = $this->status;

          //guardado de la portada del álbum
          if ($this->image){
              $artHash = StrProcessor::getRandomString($this->name);
              $newImgPath = Album::dataPath() . $artHash;

              //guardo la imagen de portada dentro del directorio de imágenes
              $savedArt = $this->image->saveAs($newImgPath);
              //check si se pudo guardar la nueva imagen
              if ($savedArt){
                //recupero la ruta de la imagen anterior
                $storedArt = Album::dataPath() . $album->art;
                //check si se pudo borrar la imagen anterior
                if (unlink($storedArt)){
                  //actualizo el nombre del Art con el nuevo hash
                  $album->art = $artHash;
                } elseif (unlink($newImgPath)){
                  $errors[] = 'Se subió la nueva imagen, pero no se pudo eliminar la previa. Se prodeció a borrar la nueva para mantener el coherencia entre la db y los datos físicos';
                } else{
                  $errors[] = 'Se subió la nueva imágen, pero no se pudo eliminar la previa. Al intentar borrar la nueva se produjo un error. Hay una imágen adicional en disco!!';
                }
              } else
                $errors [] = 'No se pudo almacenar la portada nueva';
          }

          if ($album->save()){
            try {
              $album->unlinkAll('channels', true);
              foreach ($this->channels as $channel_id) {
                $channel = Channel::findOne($channel_id);
                $album->link('channels', $channel);
              }
              $transaction->commit();
            } catch (\yii\base\InvalidCallException $e) {
              $errors[] = $e->getMessage();
              $transaction->rollBack();
            }
            return Response::getInstance($errors, Flags::UPDATE_SUCCESS);
          }
          return Response::getInstance(false, Flags::UPDATE_ERROR);
        }
        return Response::getInstance(false, Flags::FORM_VALIDATION);;
    }


}
