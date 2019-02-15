<?php
namespace common\widgets\errorMessage;

use common\widgets\RaBaseWidget;

class ErrorMessage extends RaBaseWidget{

    public $message;

  public function run(){
    return $this->render('view', ['msg' => $this->message]);
  }
}


?>
