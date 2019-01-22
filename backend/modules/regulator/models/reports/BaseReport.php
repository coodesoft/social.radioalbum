<?php
namespace regulator\models\reports;

use Yii;

use backend\models\Profile;
use regulator\models\ReportType;

use common\util\StrProcessor;

abstract class BaseReport{

  public $id;

  public $sender;

  public $target;

  public $type;

  public $date;

  public $status;

  public $statusLabel;

  public $message;

  public $representation;

  public $goDeep = false;

  abstract protected function setTarget($id);

//  abstract protected function setMessage();

  public static function getModel(){
    return new static();
  }

  public static function init($baseReport, $goDeep = false){
    $report = static::getModel();

    $report->id = $baseReport->id;

    $profile = Profile::findOne($baseReport->sender_id);
    $report->sender = $profile;
    $report->target = $report->setTarget($baseReport->target_id);
    $report->type = ReportType::findOne($baseReport->report_type_id)->description;
    $report->date = StrProcessor::formatDate('d/m/Y', $baseReport->created_at);
    $report->status = $baseReport->status;
    $report->statusLabel = ($report->status) ? Yii::t('app', 'processed') : Yii::t('app', 'pending');
    $report->message = Yii::t('app', $report->type);
    return $report;
  }

}
