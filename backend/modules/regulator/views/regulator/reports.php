<?php
use yii\helpers\Url;

use common\util\StrProcessor;
use common\util\mapper\Mapper;
use regulator\models\ReportType;

use regulator\assets\ReportAsset;
ReportAsset::register($this);
?>

<div id="reportsAdminPanel" class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo \Yii::t('app', 'reportAdminArea') ?></h3>
  </div>
  <div class="panel-body ra-container" id="listReports">
    <table class="ra-table table-striped">
      <tr>
        <th class="col-md-1 main-title text-left"><?php echo \Yii::t('app', 'id')?></th>
        <th class="col-md-2 main-title"><?php echo \Yii::t('app', 'profileReportTo')?></th>
        <th class="col-md-2 main-title"><?php echo \Yii::t('app', 'reportedElement')?></th>
        <th class="col-md-1 main-title"><?php echo \Yii::t('app', 'type')?></th>
        <th class="col-md-1 main-title"><?php echo \Yii::t('app', 'date')?></th>
        <th class="col-md-3 main-title centered"><?php echo \Yii::t('app', 'actions')?></th>
        <th class="col-md-2 main-title centered"><?php echo \Yii::t('app', 'status')?></th>
      </tr>
        <?php foreach ($reports as $key => $report) { ?>
          <tr class="item-report report_<?php echo $report->id?>_status">
            <td class="col-md-1"><?php echo $report->id?></td>
            <td class="col-md-2 link-report">
              <?php                                   // EN LGUN MOMENTO SE VA A UNIFICAR EL ACCESO AL PERFIL
                $toMap = StrProcessor::functionalClassName($report->sender->getAssociatedModel()->className());
                $route = Mapper::mapRoute($toMap);
                $url =  Url::to([$route, 'id' => $report->sender->getAssociatedModel()->id])
                ?>
                <a class="paragraph" href="<?php echo $url ?>" data-action="nav"><?php echo $report->sender->name ." ". $report->sender->last_name?></a>
            </td>
            <td class="col-md-2 link-report">
              <?php
                $route = Mapper::mapRoute($report->target->type);
                $url =  Url::to([$route, 'id' => $report->target->id]);
              ?>
              <a href="<?php echo $url ?>" data-action="nav"><?php echo $report->target->descriptor ?></a>
            </td>
            <td class="col-md-1"><?php echo $report->type ?></td>
            <td class="col-md-1"><?php echo $report->date ?></td>
            <td class="col-md-3 actions-container">
                  <div class="action-report">
                    <a href="<?php echo Url::to(['/regulator/regulator/view-report', 'id' => $report->id])?>" data-action="nav">
                      <i class="fal fa-address-card fa-2x" data-toggle="tooltip" data-placement="bottom" title="<?php echo \Yii::t('app', 'viewReport') ?>"></i>
                    </a>
                  </div>
                  <?php $icon = (!$report->status) ? 'fa-check-circle': 'fa-times-circle'; ?>
                  <?php $tooltip = (!$report->status) ? 'markProcessed' : 'markPending'; ?>
                  <div class="action-report">
                    <form action="<?php echo Url::to(['/regulator/regulator/status-report'])?>" class="action-status">
                      <input type="hidden" value="<?php echo $report->id?>" name="Report[id]">
                      <div>
                        <i class="clickeable fal <?php echo $icon ?> fa-2x" data-toggle="tooltip" data-placement="bottom" title="<?php echo \Yii::t('app', $tooltip) ?>"></i>
                      </div>
                    </form>
                  </div>
                  <div class="action-report">
                    <a class="delete-report" href="<?php echo Url::to(['/regulator/regulator/delete-report', 'id' => $report->id])?>" data-action="modal">
                      <i class="clickeable fal fa-trash-alt fa-2x" data-toggle="tooltip" data-placement="bottom" title="<?php echo \Yii::t('app', 'removeReport') ?>"></i>
                    </a>
                  </div>
            </td>
            <?php $status = ($report->status) ? 'processed' : 'pending'; ?>
            <td class="col-md-2 centered report-status report-<?php echo $status?>"><?php echo $report->statusLabel ?></td>
          </tr>
        <?php }?>
    </table>

  </div>
</div>
