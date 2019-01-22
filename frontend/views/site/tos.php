<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Url;
$this->title = \Yii::t('app','Condiciones de servicio');
?>


<div id="ToS">

    <h1 class="title"><?php echo \Yii::t('app', 'tos') ?></h1>
    <div class="horizontal-separator"></div>
    <p ><?php echo \Yii::t('app', 'welcomeToRadioalbum') ?></p>

    <div class="horizontal-separator transparent"></div>
    <p ><?php echo \Yii::t('app', 'toSPurpose') ?></p>
    <div class="horizontal-separator transparent"></div>
    <h2 class="subtitle"><?php echo \Yii::t('app', 'ourServices') ?></h2>
    <div class="horizontal-separator transparent middle"></div>
    <p ><?php echo \Yii::t('app', 'intro') ?></p>

    <div class="horizontal-separator transparent"></div>
    <h2 class="subtitle"><?php echo \Yii::t('app', 'ourPrivacyPolicy') ?></h2>
    <div class="horizontal-separator transparent middle"></div>
    <?php $link = '<a href="'.Url::to(['site/privacy-policy']).'">'.\Yii::t('app', 'privacy_policy').'</a>'; ?>
    <p ><?php echo \Yii::t('app', 'ourPrivacyPolicyAbout, {link}', ['link' => $link] ) ?></p>

    <div class="horizontal-separator transparent"></div>
    <h3  class="subtitle"><?php echo \Yii::t('app', 'userTypes') ?></h3>
    <div class="horizontal-separator transparent middle"></div>
    <p ><?php echo \Yii::t('app', 'introUserType') ?></p>

    <div class="horizontal-separator transparent middle"></div>
    <p ><?php echo \Yii::t('app', 'listenerCanDo') ?></p>
    <ul>
        <li><?php echo \Yii::t('app', 'canAccessAllMusic')?></li>
        <li><?php echo \Yii::t('app', 'canCreateCollections')?></li>
        <li><?php echo \Yii::t('app', 'canPostAndComment')?></li>
        <li><?php echo \Yii::t('app', 'shareAlbum')?></li>
        <li><?php echo \Yii::t('app', 'sharePost')?></li>
    </ul>

    <div class="horizontal-separator transparent middle"></div>
    <p ><?php echo \Yii::t('app', 'artistCanDo') ?></p>
    <ul>
        <li><?php echo \Yii::t('app', 'canDoAllListenerDo')?></li>
        <li><?php echo \Yii::t('app', 'uploadYourDisc')?></li>
    </ul>

    <div class="horizontal-separator transparent"></div>
    <h2 class="subtitle"><?php echo \Yii::t('app', 'modifications') ?></h2>
    <div class="horizontal-separator transparent middle"></div>
    <p><?php echo \Yii::t('app', 'whatWeCanModif') ?></p>

    <div class="horizontal-separator transparent"></div>
    <h2 class="subtitle"><?php echo \Yii::t('app', 'userObligations') ?></h2>
    <div class="horizontal-separator transparent middle"></div>
    <p ><?php echo \Yii::t('app', 'yourObligations') ?></p>

    <div class="horizontal-separator transparent"></div>
    <h2 class="subtitle"><?php echo \Yii::t('app', 'raObligations') ?></h2>
    <div class="horizontal-separator transparent middle"></div>
    <p ><?php echo \Yii::t('app', 'ourObligations') ?></p>

    <div class="horizontal-separator transparent"></div>
    <h2 class="subtitle"><?php echo \Yii::t('app', 'intelectualProperty') ?></h2>
    <div class="horizontal-separator transparent middle"></div>
    <p ><?php echo \Yii::t('app', 'propIntelectualAbout') ?></p>

</div>
