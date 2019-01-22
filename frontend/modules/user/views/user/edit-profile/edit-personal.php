<?php

use frontend\models\Gender;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$days = [];
$months = [];
$year = [];

for ($i=1; $i <=31 ; $i++) { $days[$i] = $i; }
for ($i=1; $i <=12 ; $i++) { $months[$i] = $i; }
for ($i = 1920; $i <= date('Y') ; $i++) { $year[$i] = $i; }

$visibility_options = [0 =>'', 1 => ''];

?>
<div class="edit-profile-area col-lg-6 col-sm-12">
  <div id="personalInfoPanel" class="panel panel-default">

    <div class="panel-body">
      <?php $form = ActiveForm::begin(['action' => Url::to(['/user/user/edit-personal']), 'options' => ['enctype' => 'multipart/form-data', 'data-content' => 'file']]) ?>

      <div class="col-sm-12">
        <?php echo $form->field($profile, 'name')->textInput()->label(\Yii::t('app', 'name')); ?>
      </div>
      <div class="col-sm-12">
        <?php echo $form->field($profile, 'last_name')->textInput()->label(\Yii::t('app', 'lastName')); ?>
      </div>
      <div class="col-sm-12">
        <?php echo $form->field($profile, 'birth_location')->textInput()->label(\Yii::t('app', 'birthLocation')); ?>
      </div>
      <div class="col-sm-12">
        <?php echo $form->field($profile, 'phone')->textInput()->label(\Yii::t('app', 'phone')); ?>
      </div>
      <div class="col-sm-12 birth-date">
        <div style="text-align:left; margin-bottom: 5px"><?php echo \Yii::t('app', 'birthDate')?></div>
        <div class="col-sm-4">
            <?php echo $form->field($model, 'birth_day')->dropdownList($days)->label(\Yii::t('app', 'day')); ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->field($model, 'birth_month')->dropdownList($months)->label(\Yii::t('app', 'month')); ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->field($model, 'birth_year')->dropdownList($year)->label(\Yii::t('app', 'year')); ?>
        </div>
      </div>
      <div class="col-sm-12">
        <?php echo $form->field($profile, 'gender_id')->dropdownList([
            1 => \Yii::t('app', 'male'),
            2 => \Yii::t('app', 'female'),
            3 => \Yii::t('app', 'custom'),
          ], ['class' => 'form-control gender-options'])->label(\Yii::t('app', 'gender')); ?>
      </div>
      <div class="col-sm-12">
          <?php if ($profile->gender_id != Gender::CUSTOM)
              echo $form->field($profile, 'gender_desc')->hiddenInput(['placeholder' => \Yii::t('app', 'inputYourGender'), 'class' => 'form-control gender-custom'])->label(false);
            else
              echo $form->field($profile, 'gender_desc')->textInput(['placeholder' => \Yii::t('app', 'inputYourGender'), 'class' => 'form-control gender-custom'])->label(false);
          ?>

      </div>
      <div class="col-sm-12">
        <div class="col-sm-3">
          <img id="profileImgPreview" src="<?php echo Url::to(['/ra/thumbnail', 'id' => $profile->photo, 'entity' => 'profile'])?>" alt="profile_img">
        </div>
        <div class="col-sm-9">
          <?php echo $form->field($model, 'photo')->fileInput()->label(false); ?>
        </div>
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
