<?php
namespace searcher\services;

use Yii;
use yii\helpers\Url;
use common\models\User;
use common\util\ArrayProcessor;
use frontend\modules\listener\models\Listener;

class ListenerFilter extends AbstractFilter{

  public function createQuery($toSearch = null){
    if ($toSearch){
      $toSearch = strtolower($toSearch);
      $this->query = Listener::find()->where(['like', 'name', $toSearch])->orderBy('name');
    } else
      $this->query = Listener::find()->orderBy('name');
  }

  public function prepareModel($params = null){
    $actions = [];
    $listeners = [];
    $user = User::findOne(Yii::$app->user->id);


    foreach($params as $listener)
    if ($user->getAssociatedModel()->profile->id != $listener->profile->id)
      $listeners[] = ArrayProcessor::userToArrayRepresentation($listener, '/listener/listener/view', $actions);

    return $listeners;
  }
}
