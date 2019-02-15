<?php

use frontend\modules\musicPanel\components\mobilePlaybackVisor\MobilePlaybackVisorAsset;
MobilePlaybackVisorAsset::register($this);
?>


<div id="mobileVisor">

    <div id="listeningLabel" class="visor"><?php echo \Yii::t('app', 'youAreListening')?></div>
    <div id="listeningContent" class="visor">
      <div class="playback-info" class="playbackChannelInfo">
        <div class="content-info" id="albumInfo"><div class="mobile-visor active"></div></div>
        <div class="actions">
          <a class="nav-album" data-action="nav" href="">
            <span class="fa-layers fa-fw" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'exploreAlbum') ?>">
              <i class="fal fa-circle" data-fa-transform="grow-8"></i>
              <i class="fas fa-link" data-fa-transform="shrink-6 right-0.5"></i>
            </span>
          </a>
        </div>
      </div>
    </div>


</div>
