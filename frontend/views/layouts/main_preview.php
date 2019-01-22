<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\authclient\widgets\AuthChoice;
use yii\bootstrap\ActiveForm;

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

use common\widgets\mainPanel\MainPanel;
use frontend\assets\RaPreviewAsset;
use frontend\modules\musicPanel\components\musicMain\musicMain;

RaPreviewAsset::register($this);
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
  <div class="block-panel preview-left-panel text-center" id="leftPanel">
      <div class="logo"><img src=<?php echo Url::to('@web') ."/img/logo-circulo-verde-url.png"?> alt=""></div>
      <div class="horizontal-separator"></div>
      <a target="_blank" href="<?php echo Url::to(['/site/signup'])?>" class="btn ra-btn"><?php echo \Yii::t('app', 'signup') ?></a>
      <div class="horizontal-separator"></div>
      <div class="title secondary-title"><?php echo \Yii::t('app', 'alreadyHaveAccount') ?></div>
      <a target="_blank" href="<?php echo Url::to(['/site/login'])?>" class="btn ra-btn"><?php echo \Yii::t('app', 'enter') ?></a>
  </div>

  <div class="block-panel" id="rightPanel">
      <?php echo musicMain::widget(['mode' => 'preview']);?>
  </div>

  <div class="block-panel" id="centralPanel">
    <div id="navBar">
      <nav class="navbar navbar-right">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse" id="mainNav">
          <?php
            echo Nav::widget([
                'options' =>['class'=>'navbar-nav'],
                'items' => $this->params['nav'],
            ]);
          ?>
        </div>
      </nav>
    </div>

    <div id="previewContainer" class="ra-container">
      <div id="main-container" class="container-fluid full-height">
            <?php echo $content ?>
      </div>
      <?php echo $this->params['footer']; ?>
    </div>
  </div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
