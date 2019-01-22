<?php
namespace user\services\messages;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class RelationshipPendingMessage extends NotificationMessageType {

  public static function getMessage($params){
    $text = Yii::t('app', 'followRequest, {user}', ['user' => '<span>'.$params['name'].'</span>']);
    $message = Html::tag('div', $text, ['class' => 'content']);
    $message.= Html::beginTag('div', ['class' => 'aditional-data']);
    $message.= Html::a(Yii::t('app', 'accept'), Url::to(['/user/social/accept-follow', 'recevier' => $params['sender_id'], 'time' => $params['updated_at']]), ['class' => 'btn ra-btn', 'data-action' => 'social.response_follow']);
    $message.= Html::a(Yii::t('app', 'decline'), Url::to(['/user/social/decline-follow', 'recevier' => $params['sender_id'], 'time' => $params['updated_at']]), ['class' => 'btn ra-btn', 'data-action' => 'social.response_follow']);
    $message.= Html::endTag('div');
    return $message;
  }

}
