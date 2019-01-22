<?php
namespace admin\modules\tagEditor\models;

use yii\base\Model;
use common\util\RAFileHelper;
use common\util\Response;
use common\util\Flags;

use admin\modules\tagEditor\services\TagEditorService;
use admin\modules\tagEditor\util\DirNavigator;


class TagEditForm extends Model{

    public $name;

    public $album;

    public $artist;

    public $channel;


    public function rules(){
        return [
            ['artist', 'string', 'skipOnEmpty' => true],
            ['channel', 'string', 'skipOnEmpty' => true],
            ['name', 'string', 'skipOnEmpty' => true],
            ['album', 'string', 'skipOnEmpty' => true],
        ];
    }

    public function attributeLabels(){
        return [
            'name' =>  \Yii::t('app', 'name'),
            'album' =>  \Yii::t('app', 'album'),
            'channels' => \Yii::t('app', 'selectChannels'),
            'artist' => \Yii::t('app', 'artista'),
        ];
    }

    public function setTags($path){
      $tagEditor = new TagEditorService(['mp3']);
      $tags = array();
      $tags['artist'] = $this->artist;
      $tags['title']   = $this->name;
      $tags['album']  = $this->album;
      $tags['genre']  = $this->channel;
      $path = DirNavigator::getFullPath(DIRECTORY_SEPARATOR . $path);
      return $tagEditor->setFileTags($path, $tags);
    }

}
