<?php
use common\util\Flags;
use yii\helpers\Url;
use yii\helpers\BaseJson;
/* @var $this yii\web\View */
?>
<div class="migration-area">
  <div class="page-header">
      <h2><?= \Yii::t('app','areaMigMusica') ?></h2>
  </div>
  <?php if ($isProcessed){
    $this->title = \Yii::t('app','areaActualizaDB');
    $album_flag = isset($album)? $album->getFlag(): null;
    $channel_flag = isset($channel)? $channel->getFlag(): null;
    $song_flag = isset($song)? $song->getFlag(): null;

  //  var_dump(json_encode($song->getResponse()['debug']));

    if ($album_flag == Flags::ALL_OK)
      $album_flag = \Yii::t('app','albunesActualizaOk');
    else
      $album_flag = \Yii::t('app','albunesActualizaE');

    if ($channel_flag == Flags::ALL_OK)
      $channel_flag = \Yii::t('app','canalesActualizaOk');
    else
      $channel_flag = \Yii::t('app','canalesActualizaE');

    if ($song_flag == Flags::ALL_OK)
      $song_flag = \Yii::t('app','songsActualizaOk');
    else
      $song_flag = \Yii::t('app','songsActualizaE');

   ?>

    <div class="panel panel-default">
      <div class="panel-heading"><?= \Yii::t('app','infoActualizacion') ?></div>
      <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item"><?= $album_flag; ?></li>
            <li class="list-group-item"><?= $channel_flag; ?></li>
            <li class="list-group-item"><?= $song_flag; ?></li>
          </ul>
      </div>
    </div>
  <?php } else {
    if ($populate){
      $action = Url::to(['catalog/populate-multimedia']);
      $label = \Yii::t('app','cargarCatalogo');
    } else{
      $action = Url::to(['catalog/update-multimedia']);
      $label = \Yii::t('app','actualizarCatalogo');
    }
  ?>
    <div class="panel panel-default">
      <div class="panel-body">
          <form  method="post" id="catalogMigration-form" action="<?= $action ?>">
          <div class="form-group">
            <button type="submit" class="btn btn-default"><?= $label ?></button>
          </div>
      </div>
    </div>
  <?php }  ?>

</div>
