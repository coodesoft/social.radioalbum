<?php

use yii\helpers\Url;
use searcher\components\searcher\MobileSearcherAsset;
MobileSearcherAsset::register($this);
?>


<div id="globalSearchMobile">
  <div class="search-box search-min">
    <a href="<?php echo Url::to(['/searcher/search/view'])?>" data-action="nav">
      <span class="fa-layers fa-fw" >
        <i class="fas fa-circle" data-fa-transform="grow-12"></i>
        <i class="fas fa-search" data-fa-transform="shrink-2" style="color: rgb(51, 51, 51);"></i>
      </span>
    </a>
  </div>
</div>
