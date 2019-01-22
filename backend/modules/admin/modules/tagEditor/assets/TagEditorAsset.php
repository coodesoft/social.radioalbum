<?php
namespace admin\modules\tagEditor\assets;

use yii\web\AssetBundle;

class TagEditorAsset extends AssetBundle{

    public $sourcePath = '@admin/modules/tagEditor/assets';

    public $js = [
      'js/ra.tagEditor.js',
      'js/tagEdit.js'
    ];

    public $css = [
      'css/tagEditor.css'
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}


 ?>
