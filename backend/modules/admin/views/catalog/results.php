<?php
use yii\bootstrap\Tabs;

echo Tabs::widget([
    'items' => [
        [
            'label' => \Yii::t('app','canales'),
            'content' => $channels,
            'headerOptions' => ['class' => 'ra-panel-tab'],
            'active' => true
        ],
        [
            'label' => \Yii::t('app','albumes'),
            'content' => $albums,
            'headerOptions' => ['class' => 'ra-panel-tab'],
        ],
        [
            'label' => \Yii::t('app','canciones'),
            'content' => $songs,
            'headerOptions' => ['class' => 'ra-panel-tab'],
        ],
    ],
]);

?>
