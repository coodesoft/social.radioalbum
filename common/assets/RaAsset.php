<?php
namespace common\assets;

use yii\web\AssetBundle;

class RaAsset extends AssetBundle{

  public $sourcePath = '@common/assets';

  public $css =[
    'css/themes/ra-dark.css',
    'css/ra-base.css',
    'https://fonts.googleapis.com/css?family=Open+Sans',
    'https://fonts.googleapis.com/css?family=Rubik+Mono+One'
  ];

  public $js = [
    'js/ra.status.js',
    'js/ra.flags.js',
    'js/ra.requester.js',
    'js/ra.browser-1.1.js',
    'js/ra.register.js',
    'js/ra.texts.js',
    'js/ra.application.js',
    'js/ra.modalBox.js',
//    'js/fontawesome-all.min.js',
    'js/all.min.js'
  ];

  public $depends = [
      'yii\web\YiiAsset',
      'yii\bootstrap\BootstrapPluginAsset',
  ];
}

 ?>
