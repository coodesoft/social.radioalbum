<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('app', 'reqPassReset');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="resetPass-box" class="col-lg-2 col-md-3 col-sm-3 col-xs-7">
    <div class="form-box-img"></div>
    <div class="title secondary-title text-center"><?= Html::encode($this->title) ?></div>

    <div class="form-box-separator"></div>

    <div>
      <span class="vertical-helper"></span>
      <div class="paragraph text-center"><?= \Yii::t('app','chooseNewPass') ?></div>
    </div>

    <div class="box-form">
      <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => \Yii::t('app', 'pass')])->label(false) ?>

        <div class="form-group text-center">
            <?php echo Html::submitButton(\Yii::t('app', 'enviar'), ['class' => 'btn ra-btn']) ?>
        </div>
      <?php ActiveForm::end() ?>
    </div>
</div>
