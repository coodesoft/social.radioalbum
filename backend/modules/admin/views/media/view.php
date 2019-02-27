<?php
use yii\helpers\Url;

?>

<div class="panel panel-default">
  <div class="panel-heading text-center"><?php echo $title ?></div>
  <div id="userAdmin" class="panel-body">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 messages text-center"></div>
      </div>
      <div class="row">
        <div class="col-md-12">
        <a type="button" class="btn ra-btn" href="<?php echo Url::to(['/admin/media/add'])?>" data-action="nav">
          <?php echo \Yii::t('app', 'uploadAlbum') ?>
        </a>
        </div>
        <div class="col-md-12">
          <?php echo $body ?>
        </div>
      </div>
    </div>
  </div>
</div>
