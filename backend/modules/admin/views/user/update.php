<?php
use admin\assets\UserAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Role;
use common\util\ArrayProcessor;
use admin\controllers\UserController;
UserAsset::register($this);


$roles = Role::find()->all();
$roleOpts = array();
foreach($roles as $role){
    if (($model->role_id == Role::LISTENER || $model->role_id == Role::ARTIST) &&
        ($role->id == Role::LISTENER || $role->id == Role::ARTIST))
      $roleOpts[$role->id] = $role->type;

    if (($model->role_id == Role::ADMIN || $model->role_id == Role::REGULATOR) &&
        ($role->id == Role::ADMIN || $role->id == Role::REGULATOR))
      $roleOpts[$role->id] = $role->type;
}

?>
<div class="row">
  <div class="col-md-12 messages text-center"></div>
</div>
<div id="userForm" >
  <?php $form = ActiveForm::begin(); ?>
  <div class="row">
      <div class="col-md-6">
        <?php echo $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        <?php echo $form->field($model, 'status')->dropdownList($model->statusLabelArray(), ['prompt'=> \Yii::t('app', 'selectStatus')]) ?>
        <?php echo $form->field($model, 'role_id')->dropdownList($roleOpts, ['prompt'=> \Yii::t('app', 'selectRole')]) ?>
        <?php echo $form->field($model, 'id')->hiddenInput()->label(false) ?>
      </div>
      <div class="col-md-6">
        <div class="well text-center"><?php echo \Yii::t('app', 'passwordAreEncrypted')?></div>
        <div class="form-group">
          <input type="password" name="User[password]" value="" id="inputPassword" class="form-control" placeholder="******">
        </div>
        <div class="checkbox">
          <label><input id="showPassword" data-input="#inputPassword" type="checkbox"><?php echo \Yii::t('app', 'showPassword') ?></label>
        </div>
      </div>
  </div>
  <div class="row">
    <div class="form-group text-center">
        <?= Html::submitButton( Yii::t('app', 'actualizar'), ['class' =>  'btn ra-btn']) ?>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>
