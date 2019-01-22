<?php
use yii\helpers\Url;
use yii\helpers\Json;

use admin\components\migrator\MigratorAsset;

use backend\modules\artist\models\Band;
use backend\modules\artist\models\Soloist;

MigratorAsset::register($this);

$hide = (empty($collection['delete']) &&
        empty($collection['add']) &&
        empty($collection['update'])) ? true : false;

$btnText = \Yii::t('app', 'updateArtistas');
?>
<div id="artistsMigration">
  <form action="<?php echo Url::to(['/admin/catalog/update-artists'])?>">
    <div id="removeArtists" class="panel panel-default">

      <div class="panel-heading">
        <h3 class="panel-title"><?php echo \Yii::t('app','eliminados') ?></h3>
      </div>
      <div class="panel-body">
        <?php if (!empty($collection['delete'])) { ?>
          <div class="checkbox selectAll">
            <label><input type="checkbox" value=""><?php echo \Yii::t('app','selectTodos') ?></label>
          </div>
        <?php } else { ?>
          <div class="well"><?php echo \Yii::t('app', 'sinObjetoABorrar, {object}', ['object' => 'Artistas']) ?></div>
        <?php } ?>
        <?php foreach($collection['delete'] as $artist){ ?>
          <div class="checkbox">
            <label><input type="checkbox" name="artists[delete][]" value="<?php echo $artist['id'] ?>"> <?php echo $artist['name'] ?></label>
          </div>
        <?php } ?>
      </div>
    </div>

    <div id="addArtists" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo \Yii::t('app','nuevos') ?></h3>
      </div>
      <div class="panel-body">
        <?php if (!empty($collection['add'])) { ?>
          <div class="checkbox selectAll">
            <label><input type="checkbox" value="" ><?php echo \Yii::t('app','selectTodos') ?></label>
          </div>
        <?php } else { ?>
          <div class="well"><?php echo \Yii::t('app', 'sinObjetoAAgregar, {object}', ['object' => 'Artistas']) ?></div>
        <?php } ?>
        <?php foreach($collection['add'] as $artist){ ?>
          <div class="checkbox">
            <label><input type="checkbox" name="artists[add][<?php echo $artist['id'] ?>]" value='<?php echo Json::htmlEncode($artist) ?>' > <?php echo $artist['name'] ?></label>
          </div>
        <?php } ?>
      </div>
    </div>

    <div id="updateArtists" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo \Yii::t('app','actualizables') ?></h3>
      </div>
      <div class="panel-body">
        <?php if (!empty($collection['update'])) { ?>
        <div class="checkbox selectAll">
          <label><input type="checkbox" value="" ><?php echo \Yii::t('app','selectTodos') ?></label>
        </div>
        <?php foreach($collection['update'] as $artist){ ?>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="artists[update][<?php echo $artist['id'] ?>]" value='<?php echo Json::htmlEncode($artist)?>' > <?php echo $artist['name'] ?>
            </label>
          </div>
          <?php } ?>
        <?php } else { ?>
          <div class="well"><?php echo \Yii::t('app', 'sinObjetoAActualiza, {object}', ['object' => 'Artistas']) ?></div>
        <?php } ?>

      </div>
    </div>

  <?php if (!$hide) { ?>
    <div class="text-center">
      <button class="btn ra-btn" data-trigger="artist"><?php echo $btnText?></button>
    </div>
  <?php } ?>
  </form>
</div>
