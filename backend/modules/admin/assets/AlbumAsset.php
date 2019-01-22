<?php
namespace admin\assets;

use yii\web\AssetBundle;


class AlbumAsset extends AdminAsset{

    public $js = [
      'js/album.js'
    ];
    public $css = [
      'css/album.css'
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}


 ?>
