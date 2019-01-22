<?php
namespace common\widgets\modalBox;

use common\widgets\RaBaseWidget;

class ModalBox extends RaBaseWidget{

    public $title;

    public $content;

    public $footer;

    public $type;

    public function init(){
      parent::init();
    }

    public function run(){
      return $this->render('view', [
        'title' => $this->title,
        'content' => $this->content,
        'footer' => $this->footer,
        'type' => $this->type,
      ]);
    }
}


?>
