<?php
namespace user\components\post;

use yii\web\AssetBundle;

class PostPanelAsset extends AssetBundle{


    public $sourcePath = '@user/components/post';

    public $js = [
      'js/autosize/autosize.min.js',
      'js/ra.postPanel.js',
    ];

    public $css = [
      'css/post.css',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
