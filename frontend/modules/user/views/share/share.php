<?php
use user\assets\UserAsset;

use yii\helpers\Url;

UserAsset::register($this);
?>

<div id="selectShareTarget">
  <div id="shareTargetWrapper">
    <a href="<?php echo Url::to(['/user/share/modal', 'content' => $content, 'id' => $id]) ?>" data-action="modal">
      <div class="share-target" id="shareRa"></div>
    </a>
    <div class="clickeable"
         data-action="share.facebook"
         data-share-url="<?php echo $e_url ?>"
         data-share-title="<?php echo $e_title ?>"
         data-share-image="<?php echo $e_image ?>" >
      <div class="share-target" id="shareFb"></div>
    </div>
  </div>
</div>
