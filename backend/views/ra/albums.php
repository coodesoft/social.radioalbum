<?php
use common\widgets\gridView\GridView;
use yii\helpers\Url;

?>

<?php if (isset($partial) && $partial) {?>
  <?php echo GridView::widget(['elements' => $albums, 'partialRender' => true]) ?>
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
            <?php if (\Yii::$app->user->can('loadAdminMainPanel')){ ?>
              <a type="button" class="btn ra-btn" href="<?php echo Url::to(['/admin/album/add'])?>" data-action="nav"><?php echo \Yii::t('app','uploadAlbum') ?></a>
              <a type="button" class="btn ra-btn" href="<?php echo Url::to(['/admin/tagEditor/nav/navigate'])?>" data-action="nav"><?php echo \Yii::t('app','editTags') ?></a>
            <?php } ?>
            
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 text-center">
              <div id="searchFormContainer" class="col-md-offset-2 col-md-8 ra-hidden">
                <form action="<?php echo Url::to()?>">

                </form>
                <a id="searchLink" href="" data-action="explore" hidden></a>
                <a id="instantSearchLink" href="<?php echo Url::to(['/admin/user/instant-user-search'])?>" data-action="explore" hidden></a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="panel">
    <div class="panel-body">
        <?php echo GridView::widget(['elements' => $albums, 'lazyLoad' => $lazyLoad]) ?>
    </div>
  </div>
</div>

<?php } ?>
