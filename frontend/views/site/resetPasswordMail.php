<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
$profile = $user->getAssociatedModel()->profile;
?>
<div class="password-reset">
    <p <?php echo \Yii::t('app', 'hi, {user}', ['user' => $profile->name ])?>,</p>

    <p><?php echo \Yii::t('app', 'clickResetPassLink') ?></p>

    <p><?php echo Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
