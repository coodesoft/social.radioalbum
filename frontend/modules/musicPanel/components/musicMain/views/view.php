<?php
use yii\helpers\Url;
use frontend\modules\musicPanel\components\musicMain\musicMain;
use frontend\modules\musicPanel\components\musicMain\musicMainAsset;
use frontend\modules\musicPanel\components\skinSelector\skinSelector;
use frontend\modules\musicPanel\components\skinSelector\skinSelectorAsset;
use frontend\modules\musicPanel\components\webPlayer\webPlayer;
use frontend\modules\musicPanel\components\webPlayer\webPlayerAsset;

$assets = musicMainAsset::register($this);
$pos = strrpos($assets->baseUrl, "/");
$urlImg = Url::to(["/img/art-back-alt-1.png"]);
?>

<div id="musicPanel" class="ra-panel">
  <div id="showSkinPanel"><?php echo \Yii::t('app', 'openSkinSelector')?></div>
  <div class="horizontal-separator"></div>
  <?php echo webPlayer::widget(['mode' => $mode]); ?>
  <div id="skinSelectorWrapper">
    <?php echo skinSelector::widget(); ?>
  </div>
</div>
