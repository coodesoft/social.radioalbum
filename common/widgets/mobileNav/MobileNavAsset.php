<?php
namespace common\widgets\mobileNav;

use yii\web\AssetBundle;


class MobileNavAsset extends AssetBundle{

    public $sourcePath = '@common/widgets/modalBox';

    public $css =[
      'css/widget.css',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}


 ?>
