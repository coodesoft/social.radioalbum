<?php
namespace admin\services\crud;
use yii\helpers\Json;
use yii\web\UploadedFile;

use backend\models\Channel;
use backend\modules\album\models\Album;

use common\util\ImageProcessor;
use common\util\StrProcessor;
class ChannelCrudService extends CrudService{

  protected function transaction(){
    return Channel::getDb()->beginTransaction();
  }

  protected function beforeAdd($obj = null){
    $obj = Json::decode($obj);
    $channel = new Channel();
    $channel->id_referencia =  (string)$obj['id'];
    $channel->name = $obj['name'];
    return $channel;
  }

  protected function afterAdd($model, $obj, $errors){
    return $errors;
  }

  protected function beforeRemove($params = null){
    $channel = Channel::findOne($params);
    if (!empty($channel->albums))
      $channel->unlinkAll('albums', true);
    return $channel;
  }

  protected function afterRemove($params = null){}

  protected function beforeUpdate($obj = null){
    $channel = Channel::findOne(['id_referencia' => $obj['id']]) ;
    if ($channel){
      $channel->name = $obj['name'];

      if ($obj['description'])
        $channel->description = $obj['description'];

      $image = UploadedFile::getInstance($channel, 'art');
      if ($image){
        $name = StrProcessor::getRandomString($image->baseName);
        $obj['art'] = Channel::dataPath() . $name;

        $image->saveAs($obj['art']);

        $result = ImageProcessor::cropSquareImage($obj['art']);
        if ($result){

          if (is_file(Channel::dataPath() . $channel->art))
            unlink(Channel::dataPath() . $channel->art);

          $channel->art = $name;
          file_put_contents($obj['art'], $result);

        }
      }
    }
    return $channel;
  }

  protected function afterUpdate($params = null){  }

}
