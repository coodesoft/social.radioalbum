<?php
namespace searcher\services;

use yii\helpers\Url;
use common\util\ArrayProcessor;
use frontend\modules\channel\models\Channel;

class ChannelFilter extends AbstractFilter{

  public function createQuery($toSearch = null){
    if ($toSearch){
      $toSearch = strtolower($toSearch);
      $this->query = Channel::find()->where(['like', 'name', $toSearch])->orderBy('name');
    } else
      $this->query = Channel::find()->orderBy('name');
  }

  public function prepareModel($params = null){
    $actions = [];
    $channels = [];

    foreach($params as $channel){
      $actions['main']        = ['icon' => 'play', 'url' => Url::to(['/webplayer/albums', 'id' => $channel->id]), 'type' => 'playback-channel', 'tooltip' => \Yii::t('app', 'playback')];
      $channels[] = ArrayProcessor::objectToArrayRepresentation($channel, 'channel', $actions);
    }

    return $channels;
  }
}
