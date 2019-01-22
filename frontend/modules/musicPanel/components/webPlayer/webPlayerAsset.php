<?php
namespace frontend\modules\musicPanel\components\webPlayer;
use common\assets\RaAsset;
use yii\web\AssetBundle;

class webPlayerAsset extends AssetBundle{

    public $sourcePath = '@frontend/modules/musicPanel/components/webPlayer';

    public $css = [
      'css/panel.css'
    ];

    public $js = [
      'js/propeller.min.js',
      'js/jPlayer/dist/jplayer/jquery.jplayer.min.js',
      'js/marquee/jquery.marquee.min.js',
      'js/ra.history.js',
      'js/ra.playbackVisor.js',
      'js/ra.webplayer.js',
      'js/panel.js',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
      'yii\jui\JuiAsset',
    ];
}

 ?>
