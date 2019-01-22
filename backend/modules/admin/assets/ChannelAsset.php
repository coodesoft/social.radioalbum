<?php
namespace admin\assets;

use yii\web\AssetBundle;


class ChannelAsset extends AdminAsset{

    public $js = [
      'js/channel.js'
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}


 ?>
