<?php
use common\components\usermenu\UserMenu;
use common\components\publibox\PubliBox;
use common\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

  NavBar::begin([
      'options' => [
          'class' => 'barra-superior navbar-inverse navbar-fixed-top',
      ],
  ]);

  $menuItems = [
      ['label' => \Yii::t('app','miMuro'), 'url' => ['/site/index']],
      ['label' => \Yii::t('app','msgs'), 'url' => ['/site/about']],
      ['label' => \Yii::t('app','canales'), 'url' => ['/site/logout']],
      ['label' => \Yii::t('app','artistas'), 'url' => ['/site/login']],
      ['label' => \Yii::t('app','albunes'), 'url' => ['/site/home']],
  ];

  echo Nav::widget([
      'options' => ['class' => 'navbar-nav navbar-right'],
      'items' => $menuItems,
  ]);

  NavBar::end();
  ?>

<div class="panel panel-izquierdo">
  <?php echo UserMenu::widget(); ?>
</div>

<div class="panel panel-derecho">
</div>

<div class="panel panel-central col-sm-8">
  <div class="col-sm-1">

  </div>
  <div class="col-sm-11">
      <?php echo PubliBox::widget(); ?>
  </div>

  </div>
