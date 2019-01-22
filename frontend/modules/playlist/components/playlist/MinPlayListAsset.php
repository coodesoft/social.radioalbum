<?php
namespace frontend\modules\playlist\components\playlist;

use yii\web\AssetBundle;


class MinPlayListAsset extends AssetBundle{

    public $sourcePath = '@frontend/modules/playlist/components/playlist';

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
