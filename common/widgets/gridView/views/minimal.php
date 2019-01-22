<?php
use common\widgets\gridView\GridViewAsset;
use yii\helpers\Url;

GridViewAsset::register($this);
?>

<div id="gridView" class="grid-minimal">
  <ul data-lazy-component="grid-view">
    <?php  foreach($elements as $key => $element){ ?>

      <li  class="grid-item grid-initial col-lg-6 col-md-6 col-sm-5 col-sx-6">

        <img id="gridThumb<?php echo $element['id']?>" src="<?php echo $element['art']; ?> " alt="thumb-<?php echo $element['name']; ?>">
        <a href="<?php echo $element['url'] ?>" data-action="nav">
          <div id="baseBack" class="item-top item-thumb it-full">
              <div class="item-thumb-hover"></div>
          </div>
          <div class="item-thumb-name"><?php echo $element['name'] ?> </div>
        </a>
      </li>
  <?php } ?>
</ul>
</div>
