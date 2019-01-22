<?php
namespace frontend\modules\musicPanel\components\skinSelector;
use common\assets\RaAsset;
use yii\web\AssetBundle;

class skinSelectorAsset extends AssetBundle{

    public $sourcePath = '@frontend/modules/musicPanel/components/skinSelector';

    public $css = [
      'css/skinSelector.css'
    ];

    public $js = [
      'js/changeSkin.js'
    ];

    public $depends = [
      'common\assets\ComponentAsset'
    ];
}

 ?>
