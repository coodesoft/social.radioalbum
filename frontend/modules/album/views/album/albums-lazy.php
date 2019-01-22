<?php
use common\widgets\gridView\GridView;
?>
  <?= GridView::widget(['elements' => $albums, 'partialRender' => true, 'actions' => $gridActions]) ?>
