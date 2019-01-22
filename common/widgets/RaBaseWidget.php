<?php
namespace common\widgets;

use yii\base\Widget;

abstract class RaBaseWidget extends Widget{

    public function init(){
      parent::init();
    }

    public function run(){
      return $this->render('view');
    }
}
?>
