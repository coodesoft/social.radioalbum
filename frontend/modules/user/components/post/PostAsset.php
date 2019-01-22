<?php
namespace user\components\post;

use yii\web\AssetBundle;

class PostAsset extends AssetBundle{


    public $sourcePath = '@user/components/post';

    public $js = [
      'js/autosize/autosize.min.js',
      'js/ra.post.js',
    ];

    public $css = [
      'css/post.css',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
