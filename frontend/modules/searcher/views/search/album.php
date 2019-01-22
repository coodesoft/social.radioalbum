<?php
use common\widgets\gridView\GridView;
use yii\helpers\Url;

$url = Url::to(['/album/album/list', 'entity' => $entity, 'segment' => 1]);
$lazyLoad = ['route' => $url, 'visible' => !$stopSearch];

echo GridView::widget(['elements' => $content, 'lazyLoad' => $lazyLoad]);
?>
