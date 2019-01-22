<?php
namespace searcher\assets;
use yii\web\AssetBundle;

class SearcherAsset extends AssetBundle{


  public $sourcePath = '@searcher/assets';

    public $js = [];

    public $css = [
      'css/search.css',
    ];

}
