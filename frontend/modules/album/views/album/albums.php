<?php
use common\widgets\gridView\GridView;
?>

<?php if (isset($partial) && $partial) {?>
  <?php echo GridView::widget(['elements' => $elements, 'partialRender' => true]) ?>
<?php } else {?>
<div class="gridContainer ra-container">
   <div id="sectionHead">
     <div class="title text-center"><?php echo strtoupper(\Yii::t('app', 'albumes'))?></div>
     <div class="subtitle text-center"><?php echo \Yii::t('app', 'muchMusicEnjoy')?></div>
   </div>
  <?php echo GridView::widget(['elements' => $elements, 'lazyLoad' => $lazyLoad, 'clean' => true]) ?>
</div>
<?php } ?>