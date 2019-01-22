<?php
namespace common\assets;

use yii\web\AssetBundle;

class RaAppAsset extends AssetBundle{

  public $sourcePath = '@common/assets';

  public $css =[
    'css/themes/ra-dark.css',
    'css/ra-base.css',
    'https://fonts.googleapis.com/css?family=Open+Sans',
    'https://fonts.googleapis.com/css?family=Rubik+Mono+One'
  ];

  public $js = [
    'js/ra.application.js',

  ];

  public $depends = [
      'yii\web\YiiAsset',
      'yii\bootstrap\BootstrapPluginAsset',
  ];
}

 ?>
