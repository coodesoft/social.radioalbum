<?php
use common\widgets\gridView\GridView;
?>

<?= GridView::widget(['elements' => $channels, 'partialRender' => true, 'actions' => $gridActions]) ?>
