<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\util\Flags;

$class = $error['class'];
$msg = $error['msg'];


?>
  <div id="login-box" class="col-lg-2 col-md-3 col-sm-3 col-xs-7">
    <div class="form-box-img"></div>
    <div class="form-box-separator"></div>
    <div class="<?= $class; ?> response-box">
      <span class="vertical-helper"></span>
      <div><?= $msg; ?></div>
    </div>
    <div class="login-box-form">
      <?php $form = ActiveForm::begin(['id' => 'login-fom']); ?>
        <?php echo $form->field($model, 'username')->textInput([
          'class'=>'form-input ra-form-cmp',
          'placeholder' => \Yii::t('app','user'),
          ])->label(false)->error(false);?>

        <?php echo $form->field($model, 'password')->passwordInput([
          'class'=>'form-input ra-form-cmp',
          'placeholder' => \Yii::t('app','pass'),
        ])->label(false)->error(false); ?>

        <?php echo Html::submitButton(\Yii::t('app','enter'), ['class'=>'form-btn ra-form-cmp']) ?>
      <?php ActiveForm::end() ?>
    </div>
  </div>
</div>
