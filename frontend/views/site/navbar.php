<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
  'brandLabel' => 'Radio Album',
  'brandUrl' => ['/webplayer/wp/index'],
  'options' => ['class' => 'navbar-inverse navbar-fixed-top',],
]);
if (!Yii::$app->user->isGuest) {
  echo Nav::widget([
  'options' => ['class' => 'navbar-nav navbar-right'],
  'items' => [
      ['label' => \Yii::t('app','inicio'), 'url' => ['/site/index']],
      ['label' => \Yii::t('app','novedades'), 'url' => ['/novedades']],
      ['label' => \Yii::t('app','nosotros'), 'url' => ['/estatica/nosotros']],
      ['label' => \Yii::t('app','contacto'), 'url' => ['/site/contact'],'options' =>['class'=>'']],
      ['label' => \Yii::t('app','admin'),
      'items' => [
          ['label' => \Yii::t('app','editorCanciones'), 'url' => ['/tageditor'], 'options' => ['class' => 'blanco']],
          ['label' => \Yii::t('app','editorPaginas'), 'url' => ['/editor-paginas'], 'options' => ['class' => 'blanco']],
          ['label' => \Yii::t('app','logOut') . Yii::$app->user->identity->username . ')','url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post'], 'options' => ['class' => 'blanco']],
        ],
      ],
    ],
  ]);
  } else {
    echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
      ['label' => \Yii::t('app','inicio'), 'url' => ['/site/index']],
      ['label' => \Yii::t('app','novedades'), 'url' => ['/novedades']],
      ['label' => \Yii::t('app','nosotros'), 'url' => ['/estatica/nosotros']],
      ['label' => \Yii::t('app','contacto'), 'url' => ['/site/contact'],'options' =>['class'=>'']],
    ],
  ]);
}

NavBar::end();
 ?>
