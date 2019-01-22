<?php
use common\util\ArrayProcessor;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\Html;

use admin\modules\tagEditor\assets\TagEditorAsset;
TagEditorAsset::register($this);

$directories = isset($objects['dir']) ? $objects['dir'] : [];
$files = isset($objects['file']) ? $objects['file'] : [];
?>
<div id="tagEditorNavigationArea" class="directory-tree">
  <div class="panel panel-default">
    <div class="panel-heading text-center"><?php echo \Yii::t('app', 'tagEditorArea') ?></div>
    <div class="panel-body">
      <div class="container-fluid" >

        <div class="row">
          <div class="col-md-12">
              <button id="backButton" type="button" class="btn ra-btn disabled" aria-label="Left Align">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <?php echo \Yii::t('app', 'goBack')?>
              </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped ra-table">
              <thead>
                <tr>
                  <th><?php echo \Yii::t('app', 'directory') ?></th>
                  <th><?php echo \Yii::t('app', 'title') ?></th>
                  <th><?php echo \Yii::t('app', 'artistas') ?></th>
                  <th><?php echo \Yii::t('app', 'albumes') ?></th>
                  <th><?php echo \Yii::t('app', 'canales') ?></th>
                  <th><?php echo \Yii::t('app', 'actions') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($directories as $directory){ ?>
                    <tr>
                      <td colspan="6" class="left">
                        <span class="directory"><?php echo $directory ?></span>
                      </td>
                    </tr>
                <?php } ?>
                <?php foreach($files as $file){ ?>
                    <tr>
                      <td class="left"><?php echo $file['name'] ?></td>
                      <td><?php echo ArrayProcessor::toString($file['tags']['title']) ?></td>
                      <td><?php echo ArrayProcessor::toString($file['tags']['artist']) ?></td>
                      <td><?php echo ArrayProcessor::toString($file['tags']['album']) ?></td>
                      <td><?php echo ArrayProcessor::toString($file['tags']['genre']) ?></td>
                      <td class="actions">
                        <div data-crud="edit" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'edit')?>" data-name="<?php echo $file['name'] ?>" data-tags ='<?php echo Json::encode($file['tags']) ?>'>
                          <span class="fa-layers fa-fw">
                            <i class="fal fa-circle" data-fa-transform="grow-14"></i>
                            <i class="far fa-pencil-alt" data-fa-transform="shrink-3"></i>
                          </span>
                        </div>
                      </td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
