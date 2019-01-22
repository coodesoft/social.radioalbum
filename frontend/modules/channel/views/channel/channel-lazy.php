<?php
use common\widgets\gridView\GridView;
?>
<?php echo GridView::widget(['elements' => $albums, 'partialRender' => true]) ?>
