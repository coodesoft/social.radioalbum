<?php
namespace common\widgets\gridView;

use yii\web\AssetBundle;


class GridViewAsset extends AssetBundle{

    public $sourcePath = '@common/widgets/gridView';

    public $css = [
      'css/widget.css'
    ];

    public $js = [
      'js/gridview.js'
    ];

    public $depends = [
  //    'common\widgets\loadBar\LoadBarAsset',
      'common\assets\ComponentAsset',
    ];
}


 ?>
