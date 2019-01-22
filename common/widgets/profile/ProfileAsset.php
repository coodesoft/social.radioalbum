<?php
namespace common\widgets\profile;

use yii\web\AssetBundle;

class ProfileAsset extends AssetBundle{

    public $sourcePath = '@common/widgets/profile';

    public $css = [
      'css/widget.css'
    ];

    public $js = [
      'js/widget.js'
    ];
    public $depends = [
      'common\assets\ComponentAsset',
    ];
}


 ?>
