<?php
namespace common\widgets\mobileNav;

use common\widgets\RaBaseWidget;

class MobileNav extends RaBaseWidget{

    public $type;

    public function init(){
      parent::init();
    }

    public function run(){
      switch ($this->type) {
        case 'post':
          return $this->render('view');
          break;
        case 'news':
          return $this->render('news');
          break;

        default:
          // code...
          break;
      }

    }
}


?>
