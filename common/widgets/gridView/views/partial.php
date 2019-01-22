<?php
use yii\helpers\Url;
?>

<?php  foreach($elements as $key => $element){ ?>

  <li class="grid-item grid-initial col-lg-3 col-md-4 col-sm-5">

    <img id="gridThumb_<?php echo $element['name']?>" src="<?php echo $element['art']; ?> " alt="thumb-<?php echo $element['name']; ?>">
      <div id="baseBack" class="item-top item-thumb it-full">
        <a href="<?php echo $element['url'] ?>" data-action="nav">
          <div class="item-thumb-hover"></div>
        </a>
      </div>

    <div class="item-thumb-name"><?php echo $element['name'] ?> </div>
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
      <div id="extActions" class="item-thumb item-bottom it-min">
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
