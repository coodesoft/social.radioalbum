<?php
use yii\helpers\Url;
use yii\helpers\BaseJson;

use admin\components\migrator\MigratorAsset;
MigratorAsset::register($this);

$hide = (empty($collection['deleted']) &&
        empty($collection['add']) &&
        empty($collection['update'])) ? true : false;

$btnText = \Yii::t('app', 'updateCanciones');
?>
<div data-env="migrator">
  <form action="<?php echo Url::to(['/admin/catalog/update-songs'])?>">

    <div id="removeSongs" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo \Yii::t('app','eliminados') ?></h3>
      </div>
      <div class="panel-body">
        <?php if (!empty($collection['deleted'])) { ?>
          <div class="checkbox selectAll">
            <label><input type="checkbox" value=""><?php echo \Yii::t('app','selectTodos') ?></label>
          </div>
        <?php } else { ?>
          <div class="well"><?php echo \Yii::t('app', 'sinObjetoABorrar, {object}', ['object' => 'Canciones']) ?></div>
        <?php } ?>
        <?php foreach($collection['deleted'] as $song){ ?>
          <div class="checkbox">
            <label><input type="checkbox" name="songs[delete][]" value="<?php echo $song['id'] ?>" > <?php echo $song['name'] ?></label>
          </div>
        <?php } ?>
      </div>
    </div>

    <div id="addSongs" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo \Yii::t('app','nuevos') ?></h3>
      </div>
      <div class="panel-body">
        <?php if (!empty($collection['add'])) { ?>
          <div class="checkbox selectAll">
            <label><input type="checkbox" value="" ><?php echo \Yii::t('app','selectTodos') ?></label>
          </div>
        <?php } else { ?>
          <div class="well"><?php echo \Yii::t('app', 'sinObjetoAAgregar, {object}', ['object' => 'Canciones']) ?></div>
        <?php } ?>
        <?php foreach($collection['add'] as $song){ ?>
          <div class="checkbox">
            <label><input type="checkbox" name="songs[add][<?php echo $song['id'] ?>]" value='<?php echo BaseJson::htmlEncode($song) ?>'> <?php echo $song['name'] ?></label>
          </div>
        <?php } ?>
      </div>
    </div>

    <div id="updateSongs" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo \Yii::t('app','actualizables') ?></h3>
      </div>
      <div class="panel-body">
        <?php if (!empty($collection['update'])) { ?>
        <div class="checkbox selectAll">
          <label><input type="checkbox" value="" ><?php echo \Yii::t('app','selectTodos') ?></label>
        </div>
        <table class="table table-bordered table-striped">
          <tr>
            <th scope="col"><?php echo \Yii::t('app', 'ampache') ?></th>
            <th scope="col"><?php echo \Yii::t('app', 'radioalbum') ?></th>
          </tr>
          <?php foreach($collection['update'] as $song){ ?>
            <tr>
              <td>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="songs[update][<?php echo $song['id'] ?>]" value='<?php echo BaseJson::htmlEncode($song)?>' > <?php echo $name = (isset($song['name']['new'])) ? $song['name']['new'] : $song['name'] ?>
                    <div class="newValues"> <?php echo $name = isset($song['album']['new']) ? \Yii::t('app', 'album') .": ". $song['album']['new'] : ''?></div>
                  </label>
                </div>
              </td>
              <td>
                <div class="checkbox">
                  <div class="newValues"> <?php echo $name = (isset($song['name']['old'])) ? $song['name']['old'] : '<br>' ?></div>
                  <div class="newValues"> <?php echo $album = (isset($song['album']['old'])) ? \Yii::t('app', 'album') .": ". $song['album']['old'] : '' ?></div>
                </div>
              </td>
            </tr>
          <?php } ?>
        </table>
        <?php } else { ?>
          <div class="well"><?php echo \Yii::t('app', 'sinObjetoAActualiza, {object}', ['object' => 'Canciones']) ?></div>
        <?php } ?>

      </div>
    </div>

  <?php if (!$hide) { ?>
    <div class="text-center">
      <button class="btn ra-btn" data-trigger="song"><?php echo $btnText?></button>
    </div>
  <?php } ?>
  </form>
</div>
