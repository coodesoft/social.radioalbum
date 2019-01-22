<?php
namespace common\widgets\songsList;

use yii\web\AssetBundle;


class SongsListAsset extends AssetBundle{

    public $sourcePath = '@common/widgets/songsList';

    public $js = [
      'https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js',
      'js/songList.js',
    ];

    public $css = [
      'css/widget.css',
      'https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css',
    ];
    public $depends = [
      'common\assets\ComponentAsset',
    ];
}


 ?>
