<?php
namespace admin\components\migrator;

use common\widgets\RaBaseWidget;

class Migrator extends RaBaseWidget{

  public $view;

  public $collection;

  public function init(){
    parent::init();
  }

  public function run(){
    return $this->render($this->view, ['collection' => $this->collection]);
  }
}
?>
