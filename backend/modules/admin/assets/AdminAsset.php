<?php
namespace admin\assets;

use yii\web\AssetBundle;


class AdminAsset extends AssetBundle{

    public $sourcePath = '@admin/assets';

    public $css = [
      'css/admin.css',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}


 ?>
