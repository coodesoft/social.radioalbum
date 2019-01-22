<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$visibility_options = [0 =>'', 1 => ''];
?>
<div class="edit-profile-area col-lg-6 col-sm-12">
  <div id="visibilityInfoPanel" class="panel panel-default">

    <div class="panel-body">
      <?php $form = ActiveForm::begin(['action' => Url::to(['/user/user/edit-visibility'])]) ?>

      <div id="statusDesc" class="col-sm-12">
        <div><?php echo \Yii::t('app', 'public') ?></div>
        <div><?php echo \Yii::t('app', 'private') ?></div>
      </div>
      <div class="edit-opt col-sm-12 clearfix">
        <?php echo ($isArtist) ? $form->field($model, 'begin_date')->radioList($visibility_options, ['class'=>'visibility-option'])->label(\Yii::t('app', 'beginDate')) : ''; ?>
      </div>
      <div class="edit-opt col-sm-12 clearfix">
        <?php echo $form->field($model, 'presentation')->radioList($visibility_options, ['class'=>'visibility-option'])->label(\Yii::t('app', 'presentation')); ?>
      </div>
      <div class="edit-opt col-sm-12 clearfix">
        <?php echo $form->field($model, 'full_name')->radioList($visibility_options, ['class'=>'visibility-option'])->label(\Yii::t('app', 'fullName')); ?>
      </div>
      <div class="edit-opt col-sm-12 clearfix">
        <?php echo $form->field($model, 'birth_date')->radioList($visibility_options, ['class'=>'visibility-option'])->label(\Yii::t('app', 'birthDate')); ?>
      </div>
      <div class="edit-opt col-sm-12 clearfix">
        <?php echo $form->field($model, 'birth_location')->radioList($visibility_options, ['class'=>'visibility-option'])->label(\Yii::t('app', 'birthLocation')); ?>
      </div>
      <div class="edit-opt col-sm-12 clearfix">
        <?php echo $form->field($model, 'phone')->radioList($visibility_options, ['class'=>'visibility-option'])->label(\Yii::t('app', 'phone')); ?>
      </div>
      <div class="edit-opt col-sm-12 clearfix">
        <?php echo $form->field($model, 'gender')->radioList($visibility_options, ['class'=>'visibility-option'])->label(\Yii::t('app', 'gender')); ?>
      </div>
      <div class="edit-opt col-sm-12 clearfix">
        <?php echo $form->field($model, 'social')->radioList($visibility_options, ['class'=>'visibility-option'])->label(\Yii::t('app', 'socialInfo')); ?>
      </div>

      <div class="col-sm-12">
        <div class="form-group">
            <div class="edit-profile-button text-center">
              <?php echo Html::submitButton(\Yii::t('app', 'editProfile'), ['class' => 'btn ra-btn']) ?>
            </div>
        </div>
      </div>

      <?php ActiveForm::end() ?>
    </div>
  </div>
</div>
