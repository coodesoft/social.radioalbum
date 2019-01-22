<?php
use common\widgets\mainPanel\PanelAsset;
use searcher\components\searcher\Searcher;
use common\util\MobileDetect;
use yii\helpers\Url;

PanelAsset::register($this);
$urlImg = Url::to(["/img/logo-ra.png"]);
?>
  <div id="myPanel" class="ra-panel full-height">

    <div class="ra-panel-logo">
      <a href="<?php echo Url::to(['/'])?>"><img src=<?php echo $urlImg ?> alt=""></a>
    </div>

    <div class="ra-panel-items">
      <?php if (isset($items)) { ?>
        <ul>
          <?php foreach($items as $item) { ?>
            <li class="item">
              <a href="<?= $item['url'] ?>" data-context="<?= $item['context'] ?>" data-action="nav">
                <span class="vertical-helper"></span>
                <?php if (isset($item['thumb']) && $item['thumb']){ ?>
                  <div class="profile-thumb">
                    <img src="<?php echo Url::to(['/ra/thumbnail', 'entity' => 'profile', 'id' => $item['thumb']]) ?>" alt="profile-img">
                  </div>
                <?php }else{ ?>
                  <span class="fa-layers fa-fw" >
                    <i class="fas fa-circle" data-fa-transform="grow-12"></i>
                    <?php if ($item['img'] == 'cog') { ?>
                      <i class="fas fa-<?php echo $item['img']?>" data-fa-transform="rotate-70 up-4 left-3.5" style="color: rgb(51, 51, 51);"></i>
                      <i class="fas fa-<?php echo $item['img']?>" data-fa-transform="down-4.5 right-4" style="color: rgb(51, 51, 51);"></i>
                    <?php } else {?>
                      <i class="fas fa-<?php echo $item['img']?>" data-fa-transform="" style="color: rgb(51, 51, 51);"></i>
                  <?php } ?>
                  </span>
                <?php } ?>
                <div class="item-name">
                    <span><?= $item['name'] ?></span>
                </div>
              </a>
            </li>
          <?php } ?>

          <li class="item">
            <a href="<?= Url::to(['/site/logout'])?>"  data-method="post" data-context="logout">
            <span class="vertical-helper"></span>
            <span class="fa-layers fa-fw" >
              <i class="fas fa-circle" data-fa-transform="grow-12"></i>
              <i class="fas fa-sign-out" data-fa-transform="shrink-2 rotate-180" style="color: rgb(51, 51, 51);"></i>
            </span>
            <div class="item-name"><?= \Yii::t('app','salir') ?></div>
            </a>
          </li>
        </ul>
      <?php } ?>
    </div>
    <div class="global-search initial full-height">
      <div class="header">
          <div class="title centered"><?php echo \Yii::t('app', 'globalSearch')?></div>
          <div class="close-searchBox clickeable">
            <i class="fal fa-chevron-down"></i>
          </div>
      </div>
      <?php if ($app == 'frontend'){
              $detect = new MobileDetect();
              echo $detect->isMobile() ? Searcher::widget(['mobile' => true]) : Searcher::widget(['mobile' => false]);
            }
        ?>
    </div>

  </div>
