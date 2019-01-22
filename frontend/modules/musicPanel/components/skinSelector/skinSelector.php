<?php
namespace frontend\modules\musicPanel\components\skinSelector;

use common\widgets\RaBaseWidget;

class skinSelector extends RaBaseWidget{

  public function init() {
    parent::init();
  }

  public function run() {
    return $this->render('view');
  }

}
?>
