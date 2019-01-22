<?php
namespace frontend\modules\playlist\components\playlist;

use yii\web\AssetBundle;


class PlayListAsset extends AssetBundle{

    public $sourcePath = '@frontend/modules/playlist/components/playlist';

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
