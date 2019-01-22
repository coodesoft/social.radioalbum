<?php
use common\widgets\gridView\GridView;
use yii\helpers\Url;
?>
<?php if (isset($partial) && $partial) {?>
  <?php echo GridView::widget(['elements' => $albums, 'partialRender' => true]) ?>
<?php } else{ ?>
<div class="row">
  <div class="col-md-12">
    <a class="btn ra-btn" href="<?php echo Url::to(['/channel/channel/add']) ?>" data-action="nav"><?php echo \Yii::t('app', 'uploadAlbum')?></a>
    <button id="showSearchBox" class="btn ra-btn"><?php echo \Yii::t('app', 'search') ?></button>
  </div>
</div>

<div class="row">
  <div class="col-md-12 text-center">
    <div class="row">
      <div id="userSearchFormContainer" class="col-md-offset-2 col-md-8 ra-hidden">
        <form action="<?php echo Url::to(['/admin/user/user-search'])?>">
          <table class="table table-bordered table-striped">
          </table>
        </form>
        <a id="searchUsersLink" href="" data-action="explore" hidden></a>
        <a id="instantSearchUsersLink" href="<?php echo Url::to(['/admin/user/instant-user-search'])?>" data-action="explore" hidden></a>
      </div>
    </div>
  </div>
</div>

<div class="gridContainer  ra-container">
      <?php echo GridView::widget(['elements' => $albums, 'lazyLoad' => $lazyLoad]) ?>
</div>
<?php } ?>
