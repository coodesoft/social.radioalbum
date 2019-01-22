<?php
namespace user\components\notificationPanel;

use common\widgets\RaBaseWidget;

class NotificationPanel extends RaBaseWidget{

    public $content;

    public $lazy;

    public function init(){
      parent::init();
    }

    public function run(){
      if (!$this->lazy)
        return $this->render('view');
     else
        return $this->render('notifications', ['content' => $this->content]);
    }
}


?>
