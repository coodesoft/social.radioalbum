<?php

/* @var $this \yii\web\Viewa */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;
use common\widgets\Alert;
use common\widgets\mainPanel\MainPanel;
use backend\modules\musicPanel\components\musicPanel\MusicPanel;

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
AppAsset::register($this);
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
  <div class="block-panel" id="leftPanel">
    <?= MainPanel::widget(['items' => $this->params['items'], 'app' => 'backend']) ?>
  </div>
  <div class="block-panel" id="centralPanel">
    <nav class="navbar">
    <?php
      echo Nav::widget([
        'options' =>['class'=>'navbar-nav'],
        'items' => $this->params['social'],
      ]);
      echo Nav::widget([
          'options' =>['class'=>'navbar-nav navbar-right'],
          'items' => $this->params['nav'],
      ]);
    ?>
    </nav>
    <div id="main-container" class="container-fluid">
        <?= $content ?>
    </div>
  </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
