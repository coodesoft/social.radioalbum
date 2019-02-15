<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Url;
$this->title = \Yii::t('app','Políticas de privacidad');
?>


<div id="ToS">

    <h1 class="title"><?php echo \Yii::t('app', 'privacy_policy') ?></h1>
    <div class="horizontal-separator"></div>
    <p ><?php echo \Yii::t('app', 'ppIntro') ?></p>
    <div class="horizontal-separator transparent"></div>

    <h2 class="subtitle"><?php echo \Yii::t('app', 'dataCollected') ?></h2>
    <div class="horizontal-separator transparent middle"></div>
    <p ><?php echo \Yii::t('app', 'dataCollectedAbout') ?></p>

    <div class="horizontal-separator transparent"></div>
    <h3  class="subtitle"><?php echo \Yii::t('app', 'dataCollectedUsage') ?></h3>
    <div class="horizontal-separator transparent middle"></div>
    <p ><?php echo \Yii::t('app', 'dataCollectedUsageAbout') ?></p>

    <div class="horizontal-separator transparent"></div>
    <h2 class="subtitle"><?php echo \Yii::t('app', 'cookies') ?></h2>
    <div class="horizontal-separator transparent middle"></div>
    <p><?php echo \Yii::t('app', 'cookiesDefinition') ?></p>
    <div class="horizontal-separator transparent middle"></div>
    <p><?php echo \Yii::t('app', 'cookieAbout') ?></p>

    <div class="horizontal-separator transparent"></div>
    <h2 class="subtitle"><?php echo \Yii::t('app', 'linkToOthers') ?></h2>
    <div class="horizontal-separator transparent middle"></div>
    <p><?php echo \Yii::t('app', 'linkToOthersAbout') ?></p>

    <div class="horizontal-separator transparent"></div>
    <h2 class="subtitle"><?php echo \Yii::t('app', 'personalInfoControl') ?></h2>
    <div class="horizontal-separator transparent middle"></div>
    <p><?php echo \Yii::t('app', 'personalInfoControlAbout') ?></p>


</div>
