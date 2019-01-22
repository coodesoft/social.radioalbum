<?php
namespace frontend\services;

use common\services\DataService;

class HistoryService extends DataService{

  protected function createCustomQuery($value = null){
    $this->provider->query =  (new \yii\db\Query())
            ->select(['name', 'time', 'song.id', 'date'])
            ->from(['history rec'])
            ->join('RIGHT JOIN', 'song', 'song.id = rec.song_id')
            ->where(['profile_id' => $value])
            ->orderBy(['rec.date' => SORT_DESC]);
  }
}
