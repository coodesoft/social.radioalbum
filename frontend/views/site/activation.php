<?php
use yii\helpers\Url;
?>

<div id="signup-box" class="col-lg-2 col-md-3 col-sm-3 col-xs-7">
  <div class="form-box-img"></div>
  <?php if ($status){ ?>
  <div class="signup-message">
    <div class="form-box-separator"></div>
    <p class="head"><?php echo \Yii::t('app','bienvenido1') ?></p>
    <p class="body"><?php echo \Yii::t('app','registroExitoso') ?></p>
    <p class="body">
      <?php echo \Yii::t('app','accesoAreaPropia',['link' => '<a href='.Url::to(['ra/main']).'>'. \Yii::t('app','aca').'</a>']) ?>
    </p>
  </div>
  <?php } else { ?>
  <div class="signup-message">
    <div class="form-box-separator"></div>
    <p class="head error"><?php echo \Yii::t('app','errorGenerico1') ?></p>
    <p class="body error"><?php echo \Yii::t('app','errorProcActiva') ?></p>
  </div>
  <?php } ?>

</div>
