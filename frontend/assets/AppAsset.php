<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/site.css',
        'https://fonts.googleapis.com/css?family=Roboto:300',
        'css/ra.css'
    ];

    public $js = [
      'js/inSite.js'
    ];

    public $depends = [
      'common\assets\RaAsset',
    ];
}
