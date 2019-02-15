<?php
namespace common\widgets\socialShare;

use yii\web\AssetBundle;


class FacebookShareAsset extends AssetBundle{

    public $sourcePath = '@common/widgets/socialShare';

    public $js = [
      'js/share.js',
      'js/facebook.js'
    ];
}


 ?>
