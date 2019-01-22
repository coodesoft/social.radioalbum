<?php
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use backend\modules\artist\models\Band;
use frontend\modules\artist\models\Soloist;
use yii\helpers\BaseJson;

$this->title = \Yii::t('app','areaMigArtist');
?>

<div class="migration-area">
    <div class="page-header">
        <h2><?= \Yii::t('app','areaMigArtist') ?></h2>
    </div>
    <?php if (!$isProcessed){ ?>
    <form  method="post" id="artistMigration-form" action="/radioalbum/site/backend/web/index.php/catalog/populate-artists">
      <div class="panel panel-default">
        <div class="panel-heading"><?= \Yii::t('app','artistasNuevos') ?></div>
        <div class="panel-body">
          <?php if (isset($artists['new'])){ ?>
            <ul class="list-group">
              <?php foreach($artists['new'] as $artist){ ?>
              <li class="list-group-item">
                <div class="item-name">
                  <?php echo $artist['name'] ?>
                  <input type="hidden" name="newArtists[<?php echo $artist['id']?>][name]" value="<?php echo $artist['name']?>">
                  <input type="hidden" name="newArtists[<?php echo $artist['id']?>][photo_url]" value="<?php echo $artist['photo_url']?>">
                  <input type="hidden" name="newArtists[<?php echo $artist['id']?>][presentation]" value="<?php echo $artist['presentation']?>">
                  <input type="hidden" name="newArtists[<?php echo $artist['id']?>][albums]" value='<?php echo BaseJson::encode($artist['albums'])?>'>
                </div>
                <div class="item-options">
                  <input type="radio" name="newArtists[<?php echo $artist['id']?>][type]" value="<?php echo Band::className()?>"><?= \Yii::t('app','banda') ?><br>
                  <input type="radio" name="newArtists[<?php echo $artist['id']?>][type]" value="<?php echo Soloist::className()?>"><?= \Yii::t('app','solista')?><br>
                </div>
              </li>
              <?php } ?>
            </ul>
          <?php } ?>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading"><?= \Yii::t('app','artistasActualizar') ?></div>
        <div class="panel-body">
        <?php if (isset($artists['update'])){ ?>
          <ul class="list-group">
            <?php foreach($artists['update'] as $artist){ ?>
            <li class="list-group-item">
              <div class="item-name">
                <?php echo $artist['name'] ?>
                <input type="hidden" name="updateArtists[<?php echo $artist['id']?>][name][val]" value="<?php echo $artist['name']?>">
                <input type="hidden" name="updateArtists[<?php echo $artist['id']?>][photo_url][val]" value="<?php echo $artist['photo_url']?>">
                <input type="hidden" name="updateArtists[<?php echo $artist['id']?>][presentation][val]" value="<?php echo $artist['presentation']?>">
                <input type="hidden" name="updateArtists[<?php echo $artist['id']?>][albums][val]" value='<?php echo BaseJson::encode($artist['albums'])?>'>
                <input type="hidden" name="updateArtists[<?php echo $artist['id']?>][type]" value="<?php echo $artist['type']?>">
              </div>
              <div class="item-options">
                <div class="checkbox">
                  <label><input type="checkbox" name="updateArtists[<?php echo $artist['id']?>][name][opt]" value="1"><?= \Yii::t('app','name')?></label>
                </div>
                <div class="checkbox">
                  <label><input type="checkbox" name="updateArtists[<?php echo $artist['id']?>][photo_url][opt]" value="1"><?= \Yii::t('app','foto')?></label>
                </div>
                <div class="checkbox">
                  <label><input type="checkbox" name="updateArtists[<?php echo $artist['id']?>][presentation][opt]" value="1"><?= \Yii::t('app','presentacion') ?></label>
                </div>
                <div class="checkbox">
                  <label><input type="checkbox" name="updateArtists[<?php echo $artist['id']?>][albums][opt]" value="1"><?= \Yii::t('app','discos') ?></label>
                </div>
              </div>
            </li>
            <?php } ?>
          </ul>
        <?php } ?>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading"><?= \Yii::t('app','artistasEliminar') ?></div>
        <div class="panel-body">
        <?php if (isset($artists['delete'])){ ?>
          <ul class="list-group">
            <?php foreach($artists['delete'] as $artist){ ?>
            <li class="list-group-item">
              <div class="item-name">
                <?php echo $artist['name'] ?>
              </div>
              <div class="item-options">
                <input type="hidden" name="deleteArtists[<?php echo $artist['id']?>]" value="<?php echo $artist['type']?>">
              </div>
            </li>
            <?php } ?>
          </ul>
        <?php } ?>
        </div>
      </div>
      <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
      <button type="submit" class="btn btn-default"><?= \Yii::t('app','artistasUPDB')?></button>
      </form>
      <?php } else{ ?>
      <div class="panel panel-default">
        <div class="panel-heading"><?= \Yii::t('app','infoActualizacion') ?></div>
        <div class="panel-body">
          <ul class="list-group">
              <?php if (empty($addErrors)){ ?>
                <p><?= \Yii::t('app','artistasLAllS') ?></p>
              <?php } else { ?>
                <p><?= \Yii::t('app','artistasError') ?></p>
                <ul>
                  <?php } foreach($addErrors as $err){ ?>
                    <li><?php echo BaseJson::encode($err) ?></li>
                  <?php } ?>
                </ul>
          </ul>
          <ul class="list-group">
              <?php if (empty($updateErrors)){ ?>
                <p><?= \Yii::t('app','artistasUPOk') ?></p>
              <?php } else { ?>
                <p><?= \Yii::t('app','artistasError') ?></p>
                <ul>
                  <?php } foreach($updateErrors as $err){ ?>
                    <li><?= BaseJson::encode($err) ?></li>
                  <?php } ?>
                </ul>
          </ul>
          <ul class="list-group">
              <?php if (empty($deleteErrors)){ ?>
                <p><?= \Yii::t('app','artistasDelOK')?></p>
              <?php } else { ?>
                <p><?= \Yii::t('app','artistasError') ?></p>
                <ul>
                  <?php } foreach($deleteErrors as $err){ ?>
                    <li><?php echo BaseJson::encode($err) ?></li>
                  <?php } ?>
                </ul>
          </ul>        </div>
      </div>
    <?php }?>
  </div>
</div>
