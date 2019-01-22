<?php
namespace common\widgets\modalBox;

use yii\web\AssetBundle;


class ModalBoxAsset extends AssetBundle{

    public $sourcePath = '@common/widgets/modalBox';

    public $css =[
      'css/widget.css',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}


 ?>
