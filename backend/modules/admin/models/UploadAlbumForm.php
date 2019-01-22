<?php
namespace admin\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\util\RAFileHelper;
use common\util\Response;
use common\util\Flags;

use admin\modules\tagEditor\services\TagEditorService;


class UploadAlbumForm extends Model{

    public $songs;

    public $image;

    public $name;

    public $year;

    public $artist;

    public $channels;

    private $uploadRoute;

    public function __construct( $config = [] ){
      $this->uploadRoute = Yii::getAlias('@catalog') . "/";

      parent::__construct();
    }

    public function rules(){
        return [
            [['name', 'channels', 'artist'], 'required'],
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
        if ($this->validate()) {
            $newFolder = $this->uploadRoute . $this->name;
            if (!is_dir($newFolder)){
              RAFileHelper::createDirectory($newFolder);
            }
            $this->image->saveAs($newFolder ."/". $this->image->baseName . '.' . $this->image->extension);
            foreach ($this->songs as $file) {
                $file->saveAs($newFolder ."/". $file->baseName . '.' . $file->extension);

            }
            return $this->setAlbumTags($newFolder);
        } else {
            return Response::getInstance($this->errors, Flags::UPLOAD_ERROR);
        }
    }
}
