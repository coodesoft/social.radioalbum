<?php
use common\widgets\gridView\GridViewAsset;
use yii\helpers\Url;

GridViewAsset::register($this);
?>
<div id="gridView" class="container-fluid">
  <ul data-lazy-component="grid-view">
    <?php // foreach($elements as $element){ ?>
      <li class="grid-item col-lg-3 col-md-4 col-sm-5">
        <img src="<?php echo $img = isset($elements[0]['art']) ? 'data:image/jpeg;base64,'. base64_encode($elements[0]['art']) : Url::to(["/img/art-back-1.png"]); ?> " alt="thumb-<?php echo $elements[0]['name']; ?>">

        <a href="<?php echo $elements[0]['url'] ?>" data-action="nav">
          <div class="item-thumb">
            <div class="item-thumb-hover"></div>
            <div class="item-thumb-name"><?php echo $elements[0]['name'] ?> </div>

            <?php if ($playable) { ?>
              <div class="item-thumb-play text-center">
                <div><i class="fas fa-camera-retro"></i></div>
              </div>
            <?php } ?>
            <div class="item-thumb-actions">
              <?php
                $offset ='';
                if (count($actions)==2)
                  $offset = 'col-xs-offset-2';

                if (count($actions)==1)
                  $offset = 'col-xs-offset-4';
              ?>
              <?php foreach ($actions as $key => $value) { ?>
                <div class="col-xs-4 <?php echo ($key==0) ? $offset : '' ?>">
                  <div class="item-thumb-action">
                    <span class="glyphicon glyphicon-<?php echo $value ?>" aria-hidden="true"></span>
                  </div>
                </div>

              <?php } ?>
            </div>
          </div>
        </a>

      </li>

      <?php // } ?>

  </ul>
  <p class="text-center ra-clear">
    <?php if ($lazyLoad['visible']){ ?>
      <a data-action="lazy-load" href="<?php echo $lazyLoad['route'] ?>" class="btn ra-dark-btn" data-lazy-target="grid-view">Cargar mas</a>
      <img class="ra-hidden ra-loader-xs" src="<?php echo Url::to(["/img/loader.gif"]) ?>" alt="radioalbum loader">
    <?php } ?>
  </p>
</div>
