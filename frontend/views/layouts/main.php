<?php

/* @var $this \yii\web\Viewa */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\PublicAppAsset;
use common\widgets\Alert;

use common\components\usermenu\UserMenu;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
PublicAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--<meta name="google-signin-client_id" content="883305077763-n5cuq4ci3rgv2ltjvlo94so1l5q543bu.apps.googleusercontent.com"> -->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="main-container" class="public-area container-fluid">
  <div id="home-page">
    <?= $content ?>
  </div>
</div>

<?php $this->endBody() ?>

<!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->
</body>
</html>
<?php $this->endPage() ?>
