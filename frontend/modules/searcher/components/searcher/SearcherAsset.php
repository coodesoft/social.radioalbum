<?php
namespace searcher\components\searcher;
use yii\web\AssetBundle;

class SearcherAsset extends AssetBundle{


  public $sourcePath = '@searcher/components/searcher';

    public $js = [
      'js/ra.searcher.js',
    ];

    public $css = [
      'css/searcher.css',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
