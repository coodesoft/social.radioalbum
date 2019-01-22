<?php
namespace backend\modules\playlist\components\playlist;

use yii\web\AssetBundle;


class PlayListAsset extends AssetBundle{

    public $sourcePath = '@backend/modules/playlist/components/playlist';

    public $css = [
      'css/extended/extended.css'
    ];
    public $js = [
      'js/widget.js'
    ];

    public $depends = [
      'common\assets\ComponentAsset',

    ];
}


 ?>
