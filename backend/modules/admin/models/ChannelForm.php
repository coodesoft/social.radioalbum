<?php
namespace admin\models;

use Yii;
use yii\base\Model;
use common\util\RAFileHelper;
use common\util\Response;
use common\util\Flags;
use common\util\StrProcessor;

use admin\modules\tagEditor\services\TagEditorService;
use admin\models\Channel;

class ChannelForm extends Model{

    public $id;

    public $art;

    public $name;

    public $description;

    public function rules(){
        return [
            [['name'], 'required'],
            ['description', 'string', 'skipOnEmpty' => true],
            [['art'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, ico, jpeg'],
        ];
    }

    public function attributeLabels(){
        return [
            'name' =>  \Yii::t('app', 'name'),
            'description' => \Yii::t('app', 'description'),
            'art' => \Yii::t('app', 'art'),
        ];
    }

    public function add(){
        if ($this->validate()){
          $channel = new Channel();
          $channel->name = $this->name;
          $channel->description = $this->description;
          if ($this->art){
              $channel->art = StrProcessor::getRandomString($channel->name);;
              //guardo la imagen de portada dentro del directorio de imágenes
              $this->art->saveAs(Channel::dataPath() . $channel->art);
          }

          if ($channel->save()){
            return Response::getInstance(true, Flags::ALL_OK);
          }

          // NO SE CHEQUEA SI LA IMÁGEN SE BORRA EXITOSAMENTE. CORREGIR
          unlink(Channel::dataPath() . $channel->art);
          return Response::getInstance($channel->errors, Flags::SAVE_ERROR);
        }
        return Response::getInstance($this->errors, Flags::FORM_VALIDATION);
    }

}
