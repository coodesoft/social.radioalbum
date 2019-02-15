<?php
use frontend\modules\playlist\components\playlist\PlayList;
use yii\helpers\Url;

$url = Url::to(['/playlist/playlist/list', 'entity' => $entity, 'segment' => 1]);
$lazyLoad = ['route' => $url, 'visible' => !$stopSearch];

echo PlayList::widget(['enviroment' => 'list', 'playlists' => $content, 'lazyLoad' => $lazyLoad])

?>
