<?php
use frontend\modules\playlist\components\playlist\PlayList;

use frontend\modules\playlist\assets\PlaylistAsset as PlModuleAsset;
PlModuleAsset::register($this);

?>

<?php if (isset($partial) && $partial) { ?>
  <?php echo PlayList::widget(['enviroment' => 'list', 'playlists' => $elements, 'partialRender' => true]) ?>
<?php } else {?>
<div id="playlistViewList" class="ra-container">
  <div id="sectionHead">
    <div class="title text-center"><?php echo strtoupper(\Yii::t('app', 'collections'))?></div>
    <div class="subtitle text-center"><?php echo \Yii::t('app', 'discoverPeopleMusic')?></div>
  </div>
  <?php echo PlayList::widget(['enviroment' => 'list', 'playlists' => $elements, 'lazyLoad' => $lazyLoad]) ?>
</div>
<?php } ?>
