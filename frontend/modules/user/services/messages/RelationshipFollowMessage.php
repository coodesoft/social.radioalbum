<?php
namespace user\services\messages;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

use frontend\models\Profile;

class RelationshipFollowMessage extends NotificationMessageType {

  public static function getMessage($params){
    $model = Profile::find()->with(['listeners', 'artists'])->where(['id' => $params['sender_id']])->one();

    if (isset($model->artists))
      foreach ($model->artists as $artist)
        $url = Url::to(['/artist/artist/view', 'id' => $artist->id]);

    if (isset($model->listeners))
      foreach ($model->listeners as $listener)
        $url = Url::to(['/listener/listener/view', 'id' => $listener->id]);

    $text = Yii::t('app', 'startFollow, {user}', ['user' => '<span>'.$params['name'].'</span>']);
    $a = Html::a($text, $url, ['data-action' => 'nav']);
    $message = Html::tag('div', $a, ['class' => 'content']);
    return $message;
  }

}
