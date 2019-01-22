<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
$this->title = \Yii::t('app','registro');
?>

  <div id="signup-box" class="oauth-signup col-lg-2 col-md-3 col-sm-3 col-xs-7">

    <div class="form-box-img"></div>

    <div class="title secondary-title text-center">
      <?php echo \Yii::t('app', 'almostThere') ?>
    </div>

    <div class="form-box-separator"></div>
    <div class="title text-center">
      <?php echo \Yii::t('app', 'chooseRoleExt') ?>
    </div>
    <div class="signup-box-form">
        <?php $form = ActiveForm::begin(['id' => 'signup-fom', 'action' => Url::to(['/site/oauth-login']) ]); ?>
        <?= $form->field($model, 'name')->hiddenInput()->label(false);;?>

        <?= $form->field($model, 'id')->hiddenInput()->label(false);;?>

        <?= $form->field($model, 'network')->hiddenInput()->label(false);;?>

        <?= $form->field($model, 'lastname')->hiddenInput()->label(false);?>

        <?= $form->field($model, 'username')->hiddenInput()->label(false);?>

        <?= $form->field($model, 'role')->inline(true)->dropdownList($roles, [
                                    'prompt' => [
                                      'text' => \Yii::t('app', 'chooseRole'),
                                      'options' => [
                                            'value' => 'none',
                                            'class' => 'prompt',
                                            'label' => \Yii::t('app', 'chooseRole')
                                          ]
                                      ],
                                      'class'=>'form-input ra-form-cmp',
                                    ])->label(false); ?>
        <input type="hidden" name="oauth" value="1">
        <?= Html::submitButton(strtoupper(\Yii::t('app','enter')), ['class'=>'form-btn ra-form-cmp']) ?>
      <?php ActiveForm::end() ?>
    </div>
    <div class="small-text-info tos"><?= \Yii::t('app','TOSLink1')?>
    </div>
  </div>
