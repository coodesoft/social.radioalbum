<?php
namespace regulator\models\reports;

use backend\models\Profile;
use common\util\StrProcessor;

class ProfileReport extends BaseReport{

  public $representation = 'profile';

  public $goDeep = true;

  protected function setTarget($id){
    $target = new ReportTarget();
    $profile = Profile::findOne($id);
    $model = $profile->getAssociatedModel();

    $target->id = $model->id;
    $target->type = $type = StrProcessor::functionalClassName($model->className());
    $target->descriptor = $profile->name . " " . $profile->last_name;

    if ($this->goDeep)
      $target->instance = $profile;
    return $target;
  }

}
