<?php
use yii\helpers\Url;
use common\widgets\gridView\GridView;
use frontend\modules\channel\assets\ChannelAsset;

ChannelAsset::register($this);

?>
<div id="channelView" class="ra-container">
  <div class="col-sm-4 col-lg-2">
      <img id="imgChannel" src="<?php echo Url::to(['/ra/thumbnail', 'id' =>$element['art'], 'entity' => 'channel']) ?> "  alt="thumb-<?php echo $element['name']; ?>">
  </div>

  <div class="col-lg-10 col-sm-8">
      <div class="col-xs-12 title-container">
        <span class="main-title title"><?php echo $element['name'] ?></span>
      </div>
      <div class="col-xs-12 description-container paragraph">
          <?php echo $description = isset($element['description']) ? $element['description'] : \Yii::t('app', 'noDescription'); ?>
      </div>
      <div class="col-xs-12 channel-view-actions">
          <a class="view-channel-playback" href="<?php echo Url::to(['/webplayer/albums', 'id'=>$element['id'] ]) ?>" data-action="playback-collection">
            <i class="fal fa-play-circle fa-2x" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'playback') ?>"></i>
          </a>
      </div>
  </div>



  <div class="col-md-12">

      <?php if (isset($partial) && $partial) {
         echo GridView::widget(['elements' => $albums, 'partialRender' => true]);
      }else { ?>
        <div class="gridContainer">
          <?php echo GridView::widget(['elements' => $albums, 'lazyLoad' => $lazyLoad]); ?>
        </div>
      <?php } ?>
  </div>
</div>
