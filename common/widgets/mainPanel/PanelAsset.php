<?php
namespace common\widgets\mainPanel;

use yii\web\AssetBundle;;


class PanelAsset extends AssetBundle{

    public $sourcePath = '@common/widgets/mainPanel';

    public $css = [
      'css/panel.css'
    ];

    public $js = [
      'js/panel.js'
    ];
    
    public $depends = [
      'common\assets\ComponentAsset',
    ];
}


 ?>
