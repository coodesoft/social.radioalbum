<?php
use yii\helpers\Url;
use backend\modules\musicPanel\components\musicPanel\MusicPanelAsset;
use backend\modules\musicPanel\components\skinSelector\SkinSelector;
use backend\modules\musicPanel\components\webPlayer\WebPlayer;
$assets = MusicPanelAsset::register($this);
$pos = strrpos($assets->baseUrl, "/");
$urlImg = Url::to(["/img/art-back-alt-1.png"]);
?>

<div id="musicPanel" class="ra-panel">

  <div class="global-search"></div>

  <div id="webPlayer">
    <div id="wp_wrapper" class="wp-skin" data-bundle="<?=substr($assets->baseUrl, $pos+1)?>">
        <div id="album_wrapper">
          <div id="album-prev" class="wp-skin"></div>
          <div id="album-next" class="wp-skin"></div>
          <div id="album-art">
            <img src="<?php echo $urlImg ?>" alt="album art">
          </div>
          <div id="playback-info" class="wp-skin"></div>
        </div>
        <div id="channel-wrapper">
          <div id="channel-selector">
            <div id="channels"></div>
            <div id="channel-prev" class="wp-skin"></div>
            <div id="channel-next" class="wp-skin"></div>
          </div>
          <div id="channel-info"><span></span></div>
        </div>
        <div id="controls">
          <div id="play-song" class="wp-skin"></div>
          <div id="pause-song" class="wp-skin"></div>
          <div id="prev-song" class="wp-skin"></div>
          <div id="next-song" class="wp-skin"></div>
          <div id="volume-song" class="wp-skin"></div>
        </div>
    </div>
    <div id="wp_audio"></div>
  </div>

</div>
