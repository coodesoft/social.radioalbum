<?php
use common\widgets\gridView\GridView;
?>
<?php if (isset($partial) && $partial) {?>
  <?php echo GridView::widget(['elements' => $artists, 'partialRender' => true]) ?>
<?php } else{ ?>
  <div class="gridContainer ra-container">
    <?php echo GridView::widget(['elements' => $artists, 'lazyLoad' => $lazyLoad]) ?>
  </div>
<?php } ?>
