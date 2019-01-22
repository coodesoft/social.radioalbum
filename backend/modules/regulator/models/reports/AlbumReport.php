<?php
namespace regulator\models\reports;

use regulator\models\reports\ReportTarget;
use backend\modules\album\models\Album;

class AlbumReport extends BaseReport{

  public $representation = 'album';

  public $goDeep = true;

  protected function setTarget($id){
    $album = Album::findOne($id);
    $target = new ReportTarget();
    $target->id = $id;
    $target->descriptor = $album->name;

    if ($this->goDeep)
      $target->instance = $album;

    return $target;
  }

}
