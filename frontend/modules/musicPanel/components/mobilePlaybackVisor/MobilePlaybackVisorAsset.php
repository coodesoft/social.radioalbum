<?php
namespace frontend\modules\musicPanel\components\mobilePlaybackVisor;
use common\assets\RaAsset;
use yii\web\AssetBundle;

class MobilePlaybackVisorAsset extends AssetBundle{

    public $sourcePath = '@frontend/modules/musicPanel/components/mobilePlaybackVisor';

    public $css = [
      'css/mobilePlaybackVisor.css'
    ];

    public $js = [
      'js/ra.mobilePlaybackVisor.js',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
      'yii\jui\JuiAsset',
    ];
}

 ?>
