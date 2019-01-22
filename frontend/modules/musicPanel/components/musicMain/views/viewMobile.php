<?php
use yii\helpers\Url;
use frontend\modules\musicPanel\components\musicMain\musicMainAsset;
use frontend\modules\musicPanel\components\webPlayer\webPlayer;

$assets = musicMainAsset::register($this);
$pos = strrpos($assets->baseUrl, "/");
$urlImg = Url::to(["/img/art-back-alt-1.png"]);
?>

<div id="musicPanel" class="ra-panel">
  <?php echo webPlayer::widget(['mode' => $mode]); ?>

</div>
