<?php
namespace admin\assets;

use yii\web\AssetBundle;


class ArtistAsset extends AdminAsset{

    public $js = [
      'js/artist.js'
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}


 ?>
