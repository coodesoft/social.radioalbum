<?php

/* @var $this \yii\web\Viewa */
/* @var $content string */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

use common\widgets\Alert;
use common\widgets\mainPanel\MainPanel;
use common\widgets\loadBar\LoadBar;
use common\widgets\socialShare\SocialShare;
use frontend\assets\AppAsset;
use frontend\modules\musicPanel\components\musicMain\musicMain;

use user\components\notificationPanel\NotificationPanel;
use user\components\post\Post;

AppAsset::register($this);
$this->title = 'RadioAlbum';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags() ?>
    <?php echo SocialShare::widget() ?>

    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
  <?php echo LoadBar::widget() ?>
  <div class="block-panel" id="leftPanel">
    <?php echo MainPanel::widget(['items' => $this->params['items']]) ?>
  </div>
  <div class="block-panel" id="rightPanel">
      <?php echo musicMain::widget();?>
  </div>
  <div class="block-panel" id="centralPanel">

    <div id="navBar">
      <nav class="navbar navbar-left">
        <?php
          echo Nav::widget([
            'options' =>['class'=>'navbar-nav'],
            'items' => $this->params['social'],
            'encodeLabels' => false,
          ]);
        ?>
      </nav>
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

    <?php echo NotificationPanel::widget() ?>

    <div id="centralContainer" class="full-height">
      <?php echo Post::widget(['component' => 'panel', 'content' => $this->params['postActions']]); ?>
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
