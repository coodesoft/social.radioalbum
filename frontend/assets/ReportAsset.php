<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ReportAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
      'css/report.css',
    ];

    public $js = [
      'js/report.js'
    ];

    public $depends = [
      'common\assets\RaAsset',
    ];
}
