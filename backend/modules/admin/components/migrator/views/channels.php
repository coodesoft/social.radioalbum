<?php
use yii\helpers\Url;
use yii\helpers\BaseJson;

use admin\components\migrator\MigratorAsset;
MigratorAsset::register($this);

$hide = (empty($collection['deleted']) &&
        empty($collection['add']) &&
        empty($collection['update'])) ? true : false;

$btnText = \Yii::t('app', 'updateCanales');
?>
<div id="channelsMigration">
  <form action="<?php echo Url::to(['/admin/catalog/update-channels'])?>">
    <div id="removeChannels" class="panel panel-default">

      <div class="panel-heading">
        <h3 class="panel-title"><?php echo \Yii::t('app','eliminados') ?></h3>
      </div>
      <div class="panel-body">
        <?php if (!empty($collection['deleted'])) { ?>
          <div class="checkbox selectAll">
            <label><input type="checkbox" value=""><?php echo \Yii::t('app','selectTodos') ?></label>
          </div>
        <?php } else { ?>
          <div class="well"><?php echo \Yii::t('app', 'sinObjetoABorrar, {object}', ['object' => 'Canales']) ?></div>
        <?php } ?>
        <?php foreach($collection['deleted'] as $channel){ ?>
          <div class="checkbox">
            <label><input type="checkbox" name="channels[delete][]" value="<?php echo $channel['id'] ?>" > <?php echo $channel['name'] ?></label>
          </div>
        <?php } ?>
      </div>
    </div>

    <div id="addChannels" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo \Yii::t('app','nuevos') ?></h3>
      </div>
      <div class="panel-body">
        <?php if (!empty($collection['add'])) { ?>
          <div class="checkbox selectAll">
            <label><input type="checkbox" value="" ><?php echo \Yii::t('app','selectTodos') ?></label>
          </div>
        <?php } else { ?>
          <div class="well"><?php echo \Yii::t('app', 'sinObjetoAAgregar, {object}', ['object' => 'Canales']) ?></div>
        <?php } ?>
        <?php foreach($collection['add'] as $channel){ ?>
          <div class="checkbox">
            <label><input type="checkbox" name="channels[add][<?php echo $channel['id'] ?>]" value='<?php echo BaseJson::htmlEncode($channel) ?>' > <?php echo $channel['name'] ?></label>
          </div>
        <?php } ?>
      </div>
    </div>

    <div id="updateChannels" class="panel panel-default">
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
          <?php foreach($collection['update'] as $channel){ ?>
            <tr>
              <td>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="channels[update][<?php echo $channel['id'] ?>]" value="<?php echo BaseJson::htmlEncode($channel)?>" > <?php echo $channel['name'] ?>
                  </label>
                </div>
              </td>
              <td>
                <div class="checkbox">
                  <div class="newValues"> <?php echo $channel['oldName'] ?></div>
                </div>
              </td>
            </tr>
          <?php } ?>
        </table>
        <?php } else { ?>
          <div class="well"><?php echo \Yii::t('app', 'sinObjetoAActualiza, {object}', ['object' => 'Canales']) ?></div>
        <?php } ?>

      </div>
    </div>

  <?php if (!$hide) { ?>
    <div class="text-center">
      <button class="btn ra-btn" data-trigger="channel"><?php echo $btnText?></button>
    </div>
  <?php } ?>
  </form>
</div>
