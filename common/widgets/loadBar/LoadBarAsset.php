<?php
namespace common\widgets\loadBar;

use yii\web\AssetBundle;


class LoadBarAsset extends AssetBundle{

    public $sourcePath = '@common/widgets/loadBar';

    public $css = [
      'css/loadBar.css'
    ];

    public $js = [
      'js/loadBar.js'
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}


 ?>
