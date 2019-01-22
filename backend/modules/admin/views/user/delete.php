<?php
use yii\helpers\Url;

$url = Url::to(['/admin/user/remove']);
$msg = \Yii::t('app','confirmRemoveUser, {user}', ['user' => $user->username]);
?>

<form id="userForm" action="<?php echo $url ?>">
  <div class="text-center">
    <?php echo $msg?>
    <input type="hidden" name="User[id]" value="<?= $user->id ?>"/>
    <div style="margin-top: 30px;">
      <button type="submit" class="ra-btn ra-big-btn"><?= \Yii::t('app','eliminar')?></button>
    </div>
  </div>
</form>
