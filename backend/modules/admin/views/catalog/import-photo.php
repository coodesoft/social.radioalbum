<?php

use common\util\Flags;
use yii\helpers\Json;

$class = '';

if ($response->getFlag() == Flags::UPDATE_ERROR){
  $class = 'ra-error-well';
  $msg = Json::encode($response->getResponse());
} elseif ($response->getFlag() == Flags::UPDATE_SUCCESS){
  $class = 'ra-success-well';
  $msg = \Yii::t('app', 'photoImportSuccess');
}

?>

<div class="well <?php echo $class?>">
  <?php if ($response->getFlag() == Flags::UPDATE_ERROR) { ?>
  <p><?php echo \Yii::t('app', 'photoImportError')?></p>
<?php } ?>
  <p><?php echo $msg ?></p>
</div>
