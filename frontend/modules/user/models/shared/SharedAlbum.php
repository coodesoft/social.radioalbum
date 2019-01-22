<?php
namespace user\models\shared;

use yii\helpers\Url;

use frontend\modules\album\models\Album;
use user\components\post\Post;

class SharedAlbum extends AbstractSharedModel{


  public function getModel($param){
    $entity = Album::find()->where(['id' => $param])->with('artists')->one();
    $url = Url::to(['/album/album/view', 'id' => $param], true);
    $imgUrl = Url::to(['/ra/thumbnail', 'id' => $entity->art, 'entity' => 'album'], true);

    $model = new SharedAlbum();
    $model->setParams('album', $param, $entity->name, $url, $imgUrl);

    return $model;
  }

  public static function getContent($param){
    $entity = Album::find()->where(['id' => $param])->with('artists')->one();
    return Post::widget(['component' => 'album-preview', 'sharedEntity' => $entity]);
  }

}
