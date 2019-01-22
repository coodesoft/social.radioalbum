<?php
namespace user\services\messages;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;

use frontend\models\Profile;

class PostCommentMessage extends NotificationMessageType {

  public static function getMessage($params){
    $model = Profile::findOne($params['sender_id']);
    $post_id = Json::decode($params['meta_data']);

    $url     = Url::to(['/user/post/view', 'id'=>$post_id['pid']]);
    $text    = Yii::t('app', 'postComment, {user}', ['user' => '<span>'.$params['name'].'</span>']);
    $a       = Html::a($text, $url, ['data-action' => 'nav']);
    $message = Html::tag('div', $a, ['class' => 'content']);

    return $message;
  }

}
