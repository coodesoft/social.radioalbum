<?php
use admin\assets\UserAsset;
use yii\helpers\Url;
UserAsset::register($this);
$this->title = $title;
?>
<div class="panel panel-default">
  <div class="panel-heading text-center"><?php echo $title ?></div>
  <div id="userAdmin" class="panel-body">
    <div class="container-fluid">
      <?php echo $body ?>
    </div>
  </div>
</div>
