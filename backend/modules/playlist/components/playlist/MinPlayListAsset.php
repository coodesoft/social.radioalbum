<?php
namespace backend\modules\playlist\components\playlist;

use yii\web\AssetBundle;


class MinPlayListAsset extends AssetBundle{

    public $sourcePath = '@backend/modules/playlist/components/playlist';

    public $css = [
      'css/minimal/minimal.css'
    ];
    public $js = [
      'js/widget.js'
    ];

    public $depends = [
      'common\assets\ComponentAsset',

    ];
}


 ?>
