<?php
namespace user\assets;

use yii\web\AssetBundle;

class SocialAsset extends AssetBundle{


    public $sourcePath = '@user/assets';

    public $css = [
      'css/notification.css',
    ];

    public $js = [
      'js/notificationWall.js',
    ];


    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
