<?php
namespace user\models\shared;

use yii\helpers\Url;

use user\models\Post as PostModel;
use user\components\post\Post;

class SharedPost extends AbstractSharedModel{


  public function getModel($param){}

  public static function getContent($param){
    $entity = PostModel::find()->where(['id' => $param])->with(['profile', 'album.artists'])->one();
    return Post::widget(['component' => 'post-preview', 'sharedEntity' => $entity]);
  }


}
