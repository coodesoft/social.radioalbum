<?php
use common\widgets\gridView\GridViewAsset;
use yii\helpers\Url;

GridViewAsset::register($this);

$classGrid = $clean ? 'clean-wall' : '';

?>
<div id="gridView" class="<?php echo $classGrid ?>">
  <ul data-lazy-component="grid-view">
    <?php  foreach($elements as $key => $element){ ?>

      <li  class="grid-item grid-initial col-lg-3 col-sm-4 col-xs-12">

          <img id="gridThumb<?php echo $element['id']?>" src="<?php echo $element['art']; ?> " alt="thumb-<?php echo $element['name']; ?>">
          <a href="<?php echo $element['url'] ?>" data-action="nav">
            <div id="baseBack" class="item-top item-thumb it-full">
                <div class="item-thumb-hover"></div>
            </div>
            <div class="item-thumb-name"><?php echo $element['name'] ?> </div>
          </a>

        <?php if (isset($element['actions']['main'])) { ?>
          <a href="<?php echo $element['actions']['main']['url'] ?>" data-action="<?php echo $element['actions']['main']['type'] ?>">
              <div class="fa-4x item-thumb-main-action">
                  <span class="fa-layers fa-fw" data-toggle="tooltip" data-placement="left" title="<?php echo $element['actions']['main']['tooltip'] ?>">
                    <i class="fal fa-circle"></i>
                    <?php if ($element['actions']['main']['icon'] == 'play') {?>
                    <i class="fal fa-<?php echo $element['actions']['main']['icon']?>" data-fa-transform="shrink-10 right-0.5"></i>
                  <?php } else { ?>
                    <i class="fal fa-<?php echo $element['actions']['main']['icon']?>" data-fa-transform="shrink-10"></i>
                  <?php } ?>
                  </span>
              </div>
          </a>
        <?php } ?>

        <?php if (isset($element['actions']['adicional']) && count($element['actions']['adicional']) >0){ ?>
          <div id="extActions" class="item-thumb item-bottom it-min extActions">
            <div>
              <div class="fa-2x text-center">
                <?php if (isset($element['actions']['adicional'])) {  ?>
                  <?php foreach ($element['actions']['adicional'] as $key => $action) { ?>
                    <a href="<?php echo $action['url'] ?>" data-action="<?php echo $action['type'] ?>">
                      <span class="fa-layers fa-fw" data-toggle="tooltip" data-placement="left" title="<?php echo $action['tooltip'] ?>">
                        <i class="fal fa-circle"></i>
                        <i class="fal fa-<?php echo $action['icon']?>" data-fa-transform="shrink-10"></i>
                      </span>
                    </a>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php } ?>

        <?php if (isset($element['actions']['pop'])) { ?>
          <div id="popActions" class="item-top text-right">
              <i id="popButton" class="fal fa-ellipsis-h fa-2x"></i>
              <div class="popActions-list ra-hidden">
                <ul class="fa-ul">
                  <?php foreach ($element['actions']['pop'] as $action) { ?>
                    <li>
                      <a href="<?php echo $action['url']?>" data-action="modal"><?php echo $action['text'] ?></a>
                    </li>
                  <?php } ?>
                </ul>
              </div>
          </div>
        <?php } ?>
      </li>
    <?php } ?>

  </ul>
  <p class="text-center ra-clear">
    <?php if ($lazyLoad['visible']){ ?>
      <a data-action="lazy-load" href="<?php echo $lazyLoad['route'] ?>" class="btn ra-dark-btn" data-lazy-target="grid-view">Cargar mas</a>
      <img class="ra-hidden ra-loader-xs" src="<?php echo Url::to(["/img/loader.gif"]) ?>" alt="radioalbum loader">
    <?php } ?>
  </p>
</div>
