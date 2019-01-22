<?php
namespace common\assets;

use yii\web\AssetBundle;

class ComponentAsset extends AssetBundle{

  public $sourcePath = '@common/assets';

  public $css =[
    'css/themes/ra-dark.css',
  ];

  public $js = [
    'js/ra.status.js',
    'js/ra.flags.js',
    'js/functions.js',
    'js/ra.register.js',
    'js/ra.requester.js',
    'js/ra.formProcessor.js',
    'js/ra.browser-1.1.js',
    'js/ra.modalBox.js',
    'js/ra.texts.js',
  ];

  public $depends = [
      'yii\web\YiiAsset',
      'yii\bootstrap\BootstrapPluginAsset',
  ];
}
