<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;

use common\widgets\songsList\SongsList;
use frontend\modules\album\assets\AlbumAsset;
AlbumAsset::register($this);
?>

<div class="ra-container" id="songsList">
  <div class="col-sm-4 col-lg-2">
      <img id="albumThumb" src="<?php echo Url::to(['/ra/thumbnail', 'id' =>$element['art'], 'entity' => 'album']) ?> "  alt="thumb-<?php echo $element['name']; ?>">

  </div>

  <div class="col-lg-10 col-sm-8">
      <div class="col-xs-12 title-container">
        <span class="main-title title"><?php echo $element['name'] ?></span>
      </div>
      <div class="col-xs-12 description-container paragraph">
          <?php echo $description = isset($element['description']) ? $element['description'] : \Yii::t('app', 'noDescription'); ?>
      </div>
      <div class="col-xs-12 album-view-actions">
        <a class="view-album-playback" href="<?php echo Url::to(['/webplayer/album', 'id'=>$element['id'] ]) ?>" data-action="playback-collection">
          <i class="fal fa-play-circle fa-2x" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'playback') ?>"></i>
        </a>
        <a class="view-album-add-to-collection" data-action="modal" href="<?php echo Url::to(['/user/user/create-playlist', 'id'=>$element['id'] ]) ?>">
          <span class="fa-layers fa-fw fa-2x" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'addAlbumToPlaylists') ?>">
            <i class="fal fa-circle"></i>
            <i class="fas fa-plus" data-fa-transform="shrink-8"></i>
          </span>
        </a>
        <a class="share-album" data-action="modal" href="<?php echo Url::to(['/user/share/target', 'content' => 'album', 'id'=>$element['id'] ]) ?>">
          <span class="fa-layers fa-fw fa-2x" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'shareAlbum') ?>">
            <i class="fal fa-circle"></i>
            <i class="fas fa-share" data-fa-transform="shrink-8"></i>
          </span>
        </a>
      </div>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-12">
  <?php
    echo SongsList::widget(['songs' => $element->songs,
                            'profile_id' => $profile_id,
                            'lazyLoad' => ['visible' => false]])
  ?>

</div>
</div>
