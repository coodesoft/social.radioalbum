<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\authclient\widgets\AuthChoice;
use yii\bootstrap\ActiveForm;

use yii\helpers\Html;
use yii\helpers\Url;

use common\util\Flags;

$class = $error['class'];
$msg = $error['msg'];


?>
  <div id="login-box" class="col-lg-2 col-md-3 col-sm-3 col-xs-7">
    <div class="form-box-img"></div>
    <div class="form-box-separator"></div>
    <div class="<?php echo $class ?> response-box">
      <span class="vertical-helper"></span>
      <div><?= $msg; ?></div>
    </div>
    <div class="login-box-form">
      <?php $form = ActiveForm::begin(['id' => 'login-fom']); ?>
        <?= $form->field($model, 'username')->textInput([
          'class'=>'form-input ra-form-cmp',
          'placeholder' => \Yii::t('app','user'),
          ])->label(false)->error(false);?>

        <?= $form->field($model, 'password')->passwordInput([
          'class'=>'form-input ra-form-cmp',
          'placeholder' => \Yii::t('app','pass'),
        ])->label(false)->error(false); ?>

        <?= Html::submitButton(\Yii::t('app','enter'), ['class'=>'form-btn ra-form-cmp']) ?>
      <?php ActiveForm::end() ?>
      <a class="form-btn ra-form-cmp" href="<?php echo Url::to(['site/signup']) ?>"><?php echo strtoupper(\Yii::t('app','signup')) ?></a>
    </div>
    <div class="small-text-info text-center"><a id="btn-registrarse" href="<?=Url::to(['site/request-password-reset'])?>"><?= \Yii::t('app','forgotPassword') ?></a></div>
    <div class="form-box-separator"></div>
    <div class="socialLogin">
      <div class="paragraph text-center"><?php echo \Yii::t('app', 'signInWith') ?> </div>
      <div class="text-center">
        <?php echo AuthChoice::widget([
          'baseAuthUrl' => ['site/auth'],
          'popupMode' => false,
           ]) ?>
      </div>
    </div>
</div>
</div>
