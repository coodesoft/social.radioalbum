<?php
use yii\helpers\Url;
use frontend\modules\musicPanel\components\webPlayer\mobileWebPlayerAsset;
use frontend\modules\musicPanel\components\webPlayer\previewMobileWebPlayerAsset;

use frontend\modules\musicPanel\components\webPlayer\webPlayer;

if ($mode == 'preview')
  $assets = previewMobileWebPlayerAsset::register($this);
else
  $assets = mobileWebPlayerAsset::register($this);

$pos = strrpos($assets->baseUrl, "/");
$urlImg = Url::to(["/img/art-back-alt-1.png"]);
?>

<div id="webPlayer">
  <div id="wp_wrapper">
      <div id="controls">
        <div class="horizontal-separator first-separator"></div>
        <div id="play-song" class="wp-control" data-toggle="tooltip" data-placement="top" title="<?php echo \Yii::t('app', 'playback')?>">
          <i class="fal fa-pause-circle fa-2x control-icon pause-display ra-hidden"></i>
          <i class="fal fa-play-circle fa-2x control-icon play-display"></i>
        </div>
        <div class="horizontal-separator"></div>
        <div id="prev-song" class="wp-control" data-toggle="tooltip" data-placement="top" title="<?php echo \Yii::t('app', 'prevSong')?>">
          <i class="fal fa-chevron-circle-left fa-2x control-icon control-flow"></i>
        </div>
        <div class="horizontal-separator"></div>
        <div id="next-song" class="wp-control" data-toggle="tooltip" data-placement="top" title="<?php echo \Yii::t('app', 'nextSong')?>">
          <i class="fal fa-chevron-circle-right fa-2x control-icon control-flow"></i>
        </div>
        <div class="horizontal-separator"></div>
        <div id="volumeControl" class="wp-control">
          <span class="fa-stack control-icon ra-hidden volume-mute">
            <i class="fal fa-circle fa-stack-2x"></i>
            <i class="fas fa-volume-mute fa-stack-1x"></i>
          </span>

          <span class="fa-stack control-icon volume-on">
            <i class="fal fa-circle fa-stack-2x"></i>
            <i class="fas fa-volume fa-stack-1x"></i>
          </span>
        </div>
      </div>
      <div class="horizontal-separator"></div>
  </div>
  <div id="wp_audio"></div>
</div>
