<?php
namespace frontend\modules\musicPanel\components\webPlayer;

class mobileWebPlayerAsset extends webPlayerAsset{

    public $sourcePath = '@frontend/modules/musicPanel/components/webPlayer';

    public $css = [
      'css/panelMobile.css'
    ];

    public $js = [
      'js/propeller.min.js',
      'js/jPlayer/dist/jplayer/jquery.jplayer.min.js',
      'js/marquee/jquery.marquee.min.js',
      'js/ra.history.js',
      'js/ra.playbackVisor.js',
      'js/ra.webplayer.mobile.js',
      'js/panel.mobile.js',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
      'yii\jui\JuiAsset',
      'frontend\modules\musicPanel\components\mobilePlaybackVisor\MobilePlaybackVisorAsset',
    ];
}

 ?>
