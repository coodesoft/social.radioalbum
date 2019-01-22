<?php
namespace user\assets;

use yii\web\AssetBundle;

class albumAsset extends AssetBundle{


    public $sourcePath = '@user/assets';

    public $css = [
      'css/album.css',
    ];

    public $js = [
      'js/album.js',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
