<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$profile = $user->profile
?>
<div class="edit-profile-area col-lg-6 col-sm-12">
  <div id="socialInfoPanel" class="panel panel-default">

    <div class="panel-body">
      <?php $form = ActiveForm::begin(['action' => Url::to(['/user/user/edit-social'])]) ?>

      <div class="col-md-12">
        <?php echo $form->field($user, 'name')->textInput()->label(\Yii::t('app', 'alias')); ?>
      </div>
      <div class="col-md-12">
        <?php echo $form->field($profile, 'facebook')->textInput()->label(\Yii::t('app', 'facebook')); ?>
      </div>
      <div class="col-md-12">
        <?php echo $form->field($profile, 'twitter')->textInput()->label(\Yii::t('app', 'twitter')); ?>
      </div>
      <div class="col-md-12">
        <?php echo $form->field($profile, 'visibility')->dropdownList([
            3 => \Yii::t('app', 'public'),
            1 => \Yii::t('app', 'private'),
          ])->label(\Yii::t('app', 'profileVis')); ?>
      </div>
      <div class="col-md-12">
        <?php echo $form->field($user, 'presentation')->textarea()->label(\Yii::t('app', 'presentation')); ?>
      </div>

      <div class="col-sm-12">
        <div class="form-group">
            <div class="edit-profile-button text-center">
              <?= Html::submitButton(\Yii::t('app', 'editProfile'), ['class' => 'btn ra-btn']) ?>
            </div>
        </div>
      </div>

      <?php ActiveForm::end() ?>
    </div>
  </div>
</div>
