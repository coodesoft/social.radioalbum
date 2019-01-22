<?php

namespace frontend\modules\playlist\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class PlaylistAsset extends AssetBundle
{

    public $sourcePath = '@frontend/modules/playlist/assets';

    public $css = [
      'css/playlists.css',
    ];

    public $js = [
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
