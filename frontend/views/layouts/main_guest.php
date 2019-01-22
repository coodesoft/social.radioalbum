<?php

/* @var $this \yii\web\Viewa */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;

use common\components\usermenu\UserMenu;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

use common\widgets\mainPanel\MainPanel;
use frontend\assets\RaPreviewAsset;
use frontend\modules\musicPanel\components\musicMain\musicMain;

//RaPreviewAsset::register($this);
//AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="block-panel" id="rightPanel">
    <?php echo musicMain::widget();?>
</div>
<?php
NavBar::begin([
  'brandLabel' => 'Radio Album',
  'brandUrl' => ['/webplayer/wp/index'],
  'options' => ['class' => 'navbar-inverse navbar-fixed-top',],
]);

    echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
      ['label' => 'Inicio', 'url' => ['/site/index']],
      ['label' => 'Novedades', 'url' => ['/novedades']],
      ['label' => 'Nosotros', 'url' => ['/estatica/nosotros']],
      ['label' => 'Contacto', 'url' => ['/site/contact'],'options' =>['class'=>'']],
    ],
  ]);


NavBar::end();
?>
<div id="main-container" class="container-fluid">
  <div id="wrap">
  <?= Alert::widget() ?>
  <?= $content ?>
  </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
