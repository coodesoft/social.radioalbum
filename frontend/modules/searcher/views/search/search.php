<?php
use yii\bootstrap\Tabs;

use searcher\assets\SearcherAsset;
SearcherAsset::register($this);

$tabs = Tabs::widget(['items'=> $items ]);
?>


<div id="searchContainer" class="ra-container">
  <div class="search-header">
    <div class="title-search">
      <span class="underline"><?php echo \Yii::t('app', 'theSearch')?></span>: 
      <span class="italic"><?php echo $search ?></span>
    </div>
    <div class="title-result">
      <?php echo \Yii::t('app', 'results') ?>
    </div>
  </div>
  <div class="tab-container">
    <?php echo $tabs ?>
  </div>
</div>
