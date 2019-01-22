<?php
use yii\bootstrap\Tabs;

use user\assets\EditProfileAsset;
EditProfileAsset::register($this);


$tabs = Tabs::widget($items);
?>

<div id="editProfile" class="ra-container tab-container">
  <?php echo $tabs ?>
</div>
