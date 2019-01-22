<?php
namespace user\assets;

use yii\web\AssetBundle;

class EditProfileAsset extends AssetBundle{


    public $sourcePath = '@user/assets';

    public $css = [
      'css/editProfile.css',
    ];

    public $js = [
      'js/editProfile.js',
    ];


    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
