<?php
namespace user\components\post;

use yii\web\AssetBundle;

class SharePostAsset extends AssetBundle{


    public $sourcePath = '@user/components/post';

    public $js = [
      'js/autosize/autosize.min.js',
      'js/ra.sharePost.js',
    ];

    public $css = [
      'css/share.css',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
