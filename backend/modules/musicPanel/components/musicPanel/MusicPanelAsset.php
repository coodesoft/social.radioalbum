<?php
namespace backend\modules\musicPanel\components\musicPanel;
use common\assets\RaAsset;

class MusicPanelAsset extends RaAsset{

    public $sourcePath = '@backend/modules/musicPanel/components/musicPanel';

    public $css = [
      'css/panel.css'
    ];

    public $js = [
      'js/propeller.min.js',
      'js/jPlayer/dist/jplayer/jquery.jplayer.min.js',
      'js/ra.history.js',
      'js/ra.webplayer.js',
      'js/panel.js',
    ];


}

 ?>
