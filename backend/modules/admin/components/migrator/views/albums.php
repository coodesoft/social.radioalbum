<?php
use yii\helpers\Url;
use yii\helpers\Json;

use admin\components\migrator\MigratorAsset;
MigratorAsset::register($this);

$hide = (empty($collection['deleted']) &&
        empty($collection['add']) &&
        empty($collection['update'])) ? true : false;

$btnText = \Yii::t('app', 'updateAlbumes');
?>
<div id="albumsMigration">
  <form action="<?php echo Url::to(['/admin/catalog/update-albums'])?>">
    <div id="removeAlbums" class="panel panel-default">

      <div class="panel-heading">
        <h3 class="panel-title"><?php echo \Yii::t('app','eliminados') ?></h3>
      </div>
      <div class="panel-body">
        <?php if (!empty($collection['deleted'])) { ?>
          <div class="checkbox selectAll">
            <label><input type="checkbox" value=""><?php echo \Yii::t('app','selectTodos') ?></label>
          </div>
        <?php } else { ?>
          <div class="well"><?php echo \Yii::t('app', 'sinObjetoABorrar, {object}', ['object' => 'Albumes']) ?></div>
        <?php } ?>
        <?php foreach($collection['deleted'] as $album){ ?>
          <div class="checkbox">
            <label><input type="checkbox" name="albums[delete][]" value="<?php echo $album['id'] ?>" > <?php echo $album['name'] ?></label>
          </div>
        <?php } ?>
      </div>
    </div>

    <div id="addAlbums" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo \Yii::t('app','nuevos') ?></h3>
      </div>
      <div class="panel-body">
        <?php if (!empty($collection['add'])) { ?>
          <div class="checkbox selectAll">
            <label><input type="checkbox" value="" ><?php echo \Yii::t('app','selectTodos') ?></label>
          </div>
        <?php } else { ?>
          <div class="well"><?php echo \Yii::t('app', 'sinObjetoAAgregar, {object}', ['object' => 'Álbumes']) ?></div>
        <?php } ?>
        <?php foreach($collection['add'] as $album){ ?>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="albums[add][<?php echo $album['id'] ?>]" value='<?php echo Json::htmlEncode($album) ?>' > <?php echo $album['name'] ?>
            </label>
          </div>
        <?php } ?>
      </div>
    </div>

    <div id="updateAlbums" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo \Yii::t('app','actualizables') ?></h3>
      </div>
      <div class="panel-body">
        <?php if (!empty($collection['update'])) { ?>
        <div class="checkbox selectAll">
          <label><input type="checkbox" value="" ><?php echo \Yii::t('app','selectTodos') ?></label>
        </div>
        <?php foreach($collection['update'] as $album){ ?>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="albums[update][<?php echo $album['id'] ?>]" value='<?php echo Json::htmlEncode($album) ?>' > <?php echo $album['name'] ?>
            </label>
          </div>
          <?php } ?>
        <?php } else { ?>
          <div class="well"><?php echo \Yii::t('app', 'sinObjetoAActualiza, {object}', ['object' => 'Álbumes']) ?></div>
        <?php } ?>

      </div>
    </div>

  <?php if (!$hide) { ?>
    <div class="text-center">
      <button class="btn ra-btn" data-trigger="album"><?php echo $btnText?></button>
    </div>
  <?php } ?>
  </form>
</div>
