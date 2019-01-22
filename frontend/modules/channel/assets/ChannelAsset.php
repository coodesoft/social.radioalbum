<?php

namespace frontend\modules\channel\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ChannelAsset extends AssetBundle
{

    public $sourcePath = '@frontend/modules/channel/assets';

    public $css = [
      'css/channel.css',
    ];

    public $js = [
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
