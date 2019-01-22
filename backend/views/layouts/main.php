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
</body>
</html>
<?php $this->endPage() ?>
