<?php
use common\widgets\gridView\GridView;
use yii\helpers\Url;
use user\assets\AlbumAsset;
AlbumAsset::register($this);
?>

<?php if (isset($partial) && $partial) {?>
  <?php echo GridView::widget(['elements' => $elements, 'partialRender' => true]) ?>
<?php } else{ ?>
<div class="ra-container">

  <div class="panel">
    <div class="panel-body">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 messages text-center"></div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <?php if (\Yii::$app->user->can('LoadArtistMainPanel')){ ?>
              <a type="button" class="btn ra-btn" href="<?php echo Url::to(['/user/artist-upload/add'])?>" data-action="nav"><?php echo \Yii::t('app','uploadAlbum') ?></a>
            <?php } ?>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="panel">
    <div class="panel-body">
        <?php echo GridView::widget(['elements' => $elements, 'lazyLoad' => $lazyLoad]) ?>
    </div>
  </div>
</div>

<?php } ?>
