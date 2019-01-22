<?php
namespace searcher\services;

use yii\helpers\Url;
use common\util\ArrayProcessor;
use frontend\models\Song;

class SongFilter extends AbstractFilter{

  public function createQuery($toSearch = null){
    if ($toSearch){
      $toSearch = strtolower($toSearch);
      $this->query = Song::find()->where(['like', 'name', $toSearch]);
    } else
      $this->query = Song::find();
  }

  public function prepareModel($params = null){
    return $params;
  }

}
