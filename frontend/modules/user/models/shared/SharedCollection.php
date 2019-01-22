<?php
namespace user\models\shared;

use yii\helpers\Url;

use frontend\modules\playlist\models\Playlist;
use user\components\post\Post;


class SharedCollection extends AbstractSharedModel{


  public function getModel($param){

    $entity = Playlist::find()->where(['id' => $param])->one();
    $url = Url::to(['/playlist/playlist/view', 'id' => $param, 'env' => 'nav'], true);
    $imgUrl = Url::to(['/ra/thumbnail', 'id' => null, 'entity' => 'collection'], true);

    $model = new SharedCollection();
    $model->setParams('collection', $param, $entity->name, $url, $imgUrl);
    return $model;
  }

  public static function getContent($param){
    $entity = Playlist::find()->where(['id' => $param])->with('profile')->one();
    return Post::widget(['component' => 'collection-preview', 'sharedEntity' => $entity]);
  }


}
