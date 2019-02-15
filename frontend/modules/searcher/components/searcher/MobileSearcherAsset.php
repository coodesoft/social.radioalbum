<?php
namespace searcher\components\searcher;
use yii\web\AssetBundle;

class MobileSearcherAsset extends AssetBundle{


  public $sourcePath = '@searcher/components/searcher';

    public $css = [
      'css/mobileSearcher.css',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
