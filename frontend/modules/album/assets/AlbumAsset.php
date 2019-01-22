<?php

namespace frontend\modules\album\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AlbumAsset extends AssetBundle
{

    public $sourcePath = '@frontend/modules/album/assets';

    public $css = [
      'css/album.css',
    ];

    public $js = [
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
