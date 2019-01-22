<?php
namespace frontend\modules\musicPanel\components\musicMain;
use common\assets\RaAsset;
use yii\web\AssetBundle;

class musicMainAsset extends AssetBundle{

    public $sourcePath = '@frontend/modules/musicPanel/components/musicMain';

    public $css = [
      'css/panel.css'
    ];

    public $js = [
      'js/musicPanel.js'
    ];

public $depends = [
  'common\assets\ComponentAsset'
];
}

 ?>
