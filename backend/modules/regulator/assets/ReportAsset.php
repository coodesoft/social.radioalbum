<?php
namespace regulator\assets;

use yii\web\AssetBundle;

class ReportAsset extends AssetBundle{

    public $sourcePath = '@regulator/assets';

    public $css = [
      'css/report.css',
    ];

    public $js = [
      'js/report.js',
    ];
    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
