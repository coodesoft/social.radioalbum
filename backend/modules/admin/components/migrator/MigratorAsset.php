<?php
namespace admin\components\migrator;

use yii\web\AssetBundle;


class MigratorAsset extends AssetBundle{

    public $sourcePath = '@admin/components/migrator';

    public $css = [

    ];
    public $js = [
      'js/migrator.js',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}


 ?>
