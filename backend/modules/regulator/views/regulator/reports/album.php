<?php
use yii\helpers\Url;

use common\util\StrProcessor;

use regulator\assets\ReportAsset;
ReportAsset::register($this);
?>

<div id="reportView" class="album-report-view report-container ra-container">

  <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Detalle del reporte con id: <?php echo $report->id ?> </h3>
        </div>
        <div class="panel-body">
          <div class="col-sm-6 profile-container report-section">
            <div class="col-sm-12 secondary-title title centered"><?php echo \Yii::t('app', 'profileReportToFull') ?></div>
            <div class="col-md-6 col-sm-12">
              <img src="<?php echo Url::to(['/ra/thumbnail', 'id' => $sender->photo , 'entity' => 'profile']) ?>" alt="<?php echo $report->representation?> ">
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="col-sm-12 report-info-block">
                <div class="strong"><?php echo \Yii::t('app', 'name') ?> </div>
                <?php echo $sender->name . " ". $sender->last_name ?>
              </div>
              <div class="col-sm-12 report-info-block">
                <div class="strong"><?php echo \Yii::t('app', 'type') ?> </div>
                <?php echo ucfirst(StrProcessor::functionalClassName($sender->getAssociatedModel()->className())) ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6 album-container report-section">
            <div class="col-sm-12 secondary-title title centered"><?php echo \Yii::t('app', 'reportedAlbum') ?></div>
            <div class="col-md-6 col-sm-12">
              <img src="<?php echo Url::to(['/ra/thumbnail', 'id' => $target->art , 'entity' => $report->representation]) ?>" alt="<?php echo $report->representation?> ">
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="col-sm-12 report-info-block">
                <div class="strong"><?php echo \Yii::t('app', 'name') ?> </div>
                <?php echo $target->name?>
              </div>
              <div class="col-sm-12 report-info-block">
                <div class="strong"><?php echo \Yii::t('app', 'type') ?> </div>
                <?php echo ucfirst(StrProcessor::functionalClassName($target->className())) ?>
              </div>
              <div class="col-sm-12 report-info-block">
                <div class="strong"><?php echo \Yii::t('app', 'status') ?> </div>
                  <div id="targetStatus">
                    <?php echo ($target->status) ? \Yii::t('app', 'active') : \Yii::t('app', 'inactive') ?>
                  </div>
              </div>
            </div>
          </div>
          <div class=" col-sm-12 content-container report-section">
            <div class="col-sm-12 secondary-title title"><?php echo \Yii::t('app', 'detail') ?></div>
            <div class="col-sm-12">
              <?php echo $report->message ?>
            </div>
          </div>

          <div class=" col-sm-12 content-container report-section">
            <div class="col-sm-12 secondary-title title"><?php echo \Yii::t('app', 'status') ?></div>
            <div class="col-sm-12">
              <div id="statusLabel">
                <?php echo ($report->status) ? \Yii::t('app', 'processed') : \Yii::t('app', 'pending') ?>
              </div>
            </div>
            <div class="col-sm-12 centered">
              <form action="<?php echo Url::to(['/regulator/regulator/status-report'])?>" class="action-status">
                <input type="hidden" name="Report[id]" value="<?php echo $report->id?>">
                <button id="changeReportStatus" class="ra-btn btn" type="submit" ><?php echo ($report->status) ? Yii::t('app', 'markPending') : Yii::t('app', 'markProcessed');?></button>
              </form>
            </div>
          </div>

          <div class="col-sm-12 action-container report-section">
            <div class="col-sm-12 secondary-title title"><?php echo \Yii::t('app', 'actions') ?></div>

            <div class="col-sm-12">
              <?php $message = ($target->status == 1) ? 'disableAlbum' : 'enableAlbum' ?>
              <form action="<?php echo Url::to(['/album/album/status'])?>" class="album-status">
                <input type="hidden" name="Album[id]" value="<?php echo $target->id ?>">
                <button id="changeTargetStatus" class="ra-btn btn" type="submit"><?php echo ($target->status) ? \Yii::t('app', 'disableAlbum') : \Yii::t('app', 'enableAlbum') ?></button>
              </form>
            </div>
          </div>

        </div>
      </div>
  </div>

</div>
