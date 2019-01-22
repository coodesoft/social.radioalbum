<?php
use common\widgets\gridView\GridView;
?>
<?= GridView::widget(['elements' => $artists, 'partialRender' => true, 'actions' => $gridActions, 'playable' => false]) ?>
