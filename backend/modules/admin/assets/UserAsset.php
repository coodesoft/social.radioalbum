<?php
namespace admin\assets;

use yii\web\AssetBundle;


class UserAsset extends AdminAsset{

    public $js = [
      'js/user.js'
    ];

    public $depends = [
      'common\assets\ComponentAsset',
      'yii\jui\JuiAsset',
    ];
}


 ?>
