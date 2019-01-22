<?php
use searcher\components\searcher\Searcher;
use searcher\assets\SearcherAsset;

SearcherAsset::register($this);

?>
<div class="ra-container" id="globalSearchView">
  <?php echo Searcher::widget(['mobile' => false]);?>
</div>
