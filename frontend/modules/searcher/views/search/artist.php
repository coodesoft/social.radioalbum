<?php
use common\widgets\gridView\GridView;
use yii\helpers\Url;

$url = Url::to(['/artist/artist/list', 'segment' => 1]);
$lazyLoad = ['route' => $url, 'visible' => !$stopSearch];

echo GridView::widget(['elements' => $content, 'lazyLoad' => $lazyLoad]);
?>
