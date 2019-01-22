<?php

use yii\helpers\Url;
use searcher\components\searcher\SearcherAsset;
SearcherAsset::register($this);
?>

<div id="globalSearch" class="search-wrapper">
  <a href="<?php echo $url ?>" data-action="nav" id="searcherLink"></a>
  <form id="globalSearchForm" class="form" role="form">

  <div class="search-box search-full">
      <div class="form-group has-feedback">
        <input id="inputGlobalSearch" name="entity" type="search" class="form-control" placeholder="Buscar">
        <div id="iconSearcher" class="clickeable form-control-feedback">
          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
        </div>
      </div>
  </div>

  <div class="filters-box">
      <div class="header">
        <div class="title"><?php echo \Yii::t('app', 'filters') ?></div>
      </div>
      <div class="horizontal-separator"></div>
      <div class="content">
        <?php foreach ($filters as $key => $element) { ?>
          <div class="filter">
            <div class="title text-center"><?php echo $element['type'] ?></div>
            <div class="filter-options">
              <?php $t=0; foreach ($element['filters'] as $key => $filter) { ?>
                <div class="checkbox">
                  <label>
                    <input name="<?php echo $key ?>" type="checkbox" value="1" checked>
                    <?php echo $filter ?>
                  </label>
                </div>
              <?php $t++; } ?>
            </div>
          </div>
          <div class="horizontal-separator"></div>
        <?php } ?>
      </div>
  </div>

  </form>
</div>
