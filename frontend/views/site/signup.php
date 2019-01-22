<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\authclient\widgets\AuthChoice;

$this->title = \Yii::t('app','registro');
?>

  <div id="signup-box" class="col-lg-2 col-md-3 col-sm-3 col-xs-7">

    <div class="form-box-img"></div>

    <div class="form-box-separator"></div>

    <div class="signup-box-form">
        <?php $form = ActiveForm::begin(['id' => 'signup-fom']); ?>
        <?= $form->field($model, 'name')->textinput([
          'class'=>'form-input ra-form-cmp',
          'placeholder' => \Yii::t('app','name'),
        ])->label(false);?>

        <?= $form->field($model, 'lastname')->textinput([
          'class'=>'form-input ra-form-cmp',
          'placeholder' => \Yii::t('app','lastName'),
        ])->label(false);?>

        <?= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput([
          'class'=>'form-input ra-form-cmp',
          'placeholder' => \Yii::t('app','mail'),
          ])->label(false);?>

        <?= $form->field($model, 'password')->passwordInput([
          'class'=>'form-input ra-form-cmp',
          'placeholder' => \Yii::t('app','pass'),
        ])->label(false); ?>

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

        <?= Html::submitButton(strtoupper(\Yii::t('app','signup')), ['class'=>'form-btn ra-form-cmp']) ?>
      <?php ActiveForm::end() ?>
    </div>

    <div class="socialLogin">
      <div class="paragraph text-center"><?php echo \Yii::t('app', 'signInWith') ?> </div>
      <div class="text-center">
        <?php echo AuthChoice::widget([
          'baseAuthUrl' => ['site/auth'],
          'popupMode' => false,
           ]) ?>
      </div>
    </div>
    <div class="form-box-separator"></div>
    <?php
     $tos = '<a href="'.Url::to(['site/tos']).'">'.\Yii::t('app', 'tos').'</a>';
     $pp = '<a href="'.Url::to(['site/privacy-policy']).'">'.\Yii::t('app', 'privacy_policy').'</a>';
     ?>
    <div class="small-text-info tos"><?= \Yii::t('app','TOSLink1, {tos, pp}', ['tos' => $tos, 'pp' => $pp])?></div>

  </div>
