<?php
use yii\helpers\Url;
use frontend\modules\musicPanel\components\webPlayer\webPlayerAsset;
use frontend\modules\musicPanel\components\webPlayer\previewWebPlayerAsset;

use frontend\modules\musicPanel\components\webPlayer\webPlayer;

if ($mode == 'preview')
  $assets = previewWebPlayerAsset::register($this);
else
  $assets = webPlayerAsset::register($this);

$pos = strrpos($assets->baseUrl, "/");
$urlImg = Url::to(["/img/art-back-alt-1.png"]);
?>

<div id="webPlayer">
  <div id="wp_wrapper" class="wp-skin" data-bundle="<?=substr($assets->baseUrl, $pos+1)?>">
      <div id="album_wrapper">
        <div id="album-prev" class="wp-skin" class="wp-skin" data-toggle="tooltip" data-placement="top" title="<?php echo \Yii::t('app', 'prevAlbum')?>"></div>
        <div id="album-next" class="wp-skin" class="wp-skin" data-toggle="tooltip" data-placement="top" title="<?php echo \Yii::t('app', 'nextAlbum')?>"></div>
        <a href="#" id="linkToAlbum" data-action="nav">
          <div id="album-art">
            <img src="<?php echo $urlImg ?>" alt="album art">
          </div>
        </a>
        <div id="playback-info" class="wp-skin"></div>
      </div>
      <div id="channel-wrapper">
        <div id="channel-selector">
          <div id="channels"></div>
          <div id="channel-prev" class="wp-skin"></div>
          <div id="channel-next" class="wp-skin"></div>
        </div>
        <div id="channel-label"><span></span></div>
      </div>
      <div id="controls">
        <div id="play-song" class="wp-skin" data-toggle="tooltip" data-placement="top" title="<?php echo \Yii::t('app', 'playback')?>"></div>
        <div id="pause-song" class="wp-skin" data-toggle="tooltip" data-placement="top" title="<?php echo \Yii::t('app', 'pause')?>"></div>
        <div id="prev-song" class="wp-skin" data-toggle="tooltip" data-placement="top" title="<?php echo \Yii::t('app', 'prevSong')?>"></div>
        <div id="next-song" class="wp-skin" data-toggle="tooltip" data-placement="top" title="<?php echo \Yii::t('app', 'nextSong')?>"></div>
        <div id="volume-song" class="wp-skin" data-toggle="tooltip" data-placement="top" title="<?php echo \Yii::t('app', 'volume')?>"></div>
        <div id="volume-song-bar" data-toggle="tooltip" data-placement="top" title="<?php echo \Yii::t('app', 'volume')?>"><div class="indicator"></div></div>
      </div>
  </div>
  <div id="wp_audio"></div>
</div>

<div class="horizontal-separator"></div>
<div id="playbackInfoWrapper">
  <div class="title text-center third-title"><?php echo strtoupper(\Yii::t('app', 'youAreListening'))?></div>

  <div class="playback-info" class="playbackChannelInfo">
    <div class="label"><?php echo strtoupper(\Yii::t('app', 'channel')) ?></div>
    <div class="content-info" id="channelInfo"><div class="visor active"></div></div>
    <div class="actions">
      <a class="nav-channel" data-action="nav" href="">
        <span class="fa-layers fa-fw" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'exploreChannel') ?>">
          <i class="fal fa-circle" data-fa-transform="grow-8"></i>
          <i class="fas fa-link" data-fa-transform="shrink-6 right-0.5"></i>
        </span>
      </a>
    </div>
  </div>

  <div class="playback-info" class="playbackAlbumInfo">
    <div class="label"><?php echo strtoupper(\Yii::t('app', 'album')) ?></div>
    <div class="content-info" id="albumInfo"><div class="visor active"></div></div>
    <div class="actions">
      <a class="nav-album" data-action="nav" href="">
        <span class="fa-layers fa-fw" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'exploreAlbum') ?>">
          <i class="fal fa-circle" data-fa-transform="grow-8"></i>
          <i class="fas fa-link" data-fa-transform="shrink-6 right-0.5"></i>
        </span>
      </a>
        <a class="add-album-collection" data-action="modal" href="">
          <span class="fa-layers fa-fw" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'addAlbumToPlaylists') ?>">
            <i class="fal fa-circle" data-fa-transform="grow-8"></i>
            <i class="fas fa-plus" data-fa-transform="shrink-6 right-0.5"></i>
          </span>
        </a>
        <a class="share-album" data-action="modal" href="">
          <span class="fa-layers fa-fw" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'shareAlbum') ?>">
            <i class="fal fa-circle" data-fa-transform="grow-8"></i>
            <i class="fas fa-share" data-fa-transform="shrink-6 right-0.5"></i>
          </span>
        </a>
    </div>
  </div>

  <div class="playback-info" id="playbackArtistInfo">
    <div class="label"><?php echo strtoupper(\Yii::t('app', 'artist'))?></div>
    <div class="content-info" id="artistInfo"><div class="visor active"></div></div>
    <div class="actions">
      <a class="nav-artist" data-action="nav" href="">
        <span class="fa-layers fa-fw" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'exploreArtist') ?>">
          <i class="fal fa-circle" data-fa-transform="grow-8"></i>
          <i class="fas fa-link" data-fa-transform="shrink-6 right-0.5"></i>
        </span>
      </a>
    </div>
  </div>

  <div class="playback-info" id="playbackSongInfo">
    <div class="label"><?php echo strtoupper(\Yii::t('app', 'song'))?></div>
    <div class="content-info" id="songInfo"><div class="visor"></div></div>
    <div class="actions">
      <a class="add-song-collection" data-action="modal" href="">
        <span class="fa-layers fa-fw" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'addToPlaylist') ?>">
          <i class="fal fa-circle" data-fa-transform="grow-8"></i>
          <i class="fas fa-plus" data-fa-transform="shrink-6 right-0.5"></i>
        </span>
      </a>
      <a class="add-song-favs" data-action="modal" href="">
        <span class="fa-layers fa-fw" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'addToFavs') ?>">
          <i class="fal fa-circle" data-fa-transform="grow-8"></i>
          <i class="fas fa-star" data-fa-transform="shrink-6 right-0.5"></i>
        </span>
      </a>
    </div>
  </div>

</div>

<div class="horizontal-separator"></div>
