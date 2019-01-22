<?php
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
  <div id="artistInfoPanel" class="panel panel-default">

    <div class="panel-body">
      <?php $form = ActiveForm::begin(['action' => Url::to(['/user/user/edit-artist'])]) ?>

      <div class="col-sm-12 birth-date">
        <div style="text-align:left; margin-bottom: 5px"><?php echo \Yii::t('app', 'beginDate')?></div>
        <div class="col-sm-4">
            <?php echo $form->field($model, 'begin_day')->dropdownList($days)->label(\Yii::t('app', 'day')); ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->field($model, 'begin_month')->dropdownList($months)->label(\Yii::t('app', 'month')); ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->field($model, 'begin_year')->dropdownList($year)->label(\Yii::t('app', 'year')); ?>
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
