<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Role;
use common\util\ArrayProcessor;

?>
<div class="row">
  <div class="col-md-12 messages text-center"></div>
</div>
<div class="row">
  <div class="col-md-12 userAdminContent">
    <form action="<?php echo Url::to(['/admin/user/create'])?>">
      <div id="userForm" class="row">
        <div class="col-md-offset-2 col-md-8">
           <div class="form-group">
             <label for="inputUsername"><?php echo \Yii::t('app', 'user') ?></label>
             <input name="User[username]" type="email" class="form-control" id="inputUsername" placeholder="usuario@example.com" required>
           </div>
           <div class="form-group">
             <label for="inputPassword"><?php echo \Yii::t('app', 'pass') ?></label>
             <input name="User[password]" type="password" class="form-control" id="inputPassword" placeholder="********"required>
           </div>
           <div class="form-group">
              <div class="checkbox">
                <label><input id="showPassword" data-input="#inputPassword" type="checkbox"><?php echo \Yii::t('app', 'showPassword') ?></label>
              </div>
           </div>
           <div class="form-group">
             <select class="form-control" name="User[role]">
               <?php foreach($roles as $role){?>
                 <?php if ($role->id != Role::LISTENER){ ?>
                   <option value="<?php echo $role->id?>"><?php echo $role->type?></option>
                 <?php } ?>
              <?php } ?>
             </select>
           </div>
            <div class="form-group">
                 <div class="form-group text-center">
                     <?php echo Html::submitButton(\Yii::t('app', 'enviar'), ['class' => 'btn ra-btn']) ?>
                 </div>
            </div>
            <div class="form-group">
              <div class="text-center alert alert-danger user-response ra-hidden" role="alert"></div>
            </div>
        </div>
      </div>
    </form>
  </div>
</div>
