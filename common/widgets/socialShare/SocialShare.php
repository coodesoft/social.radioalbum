<?php
namespace common\widgets\socialShare;

use common\widgets\RaBaseWidget;

class SocialShare extends RaBaseWidget{

    public $network;


    public function init(){
      parent::init();
    }

    public function run(){

      switch ($this->network) {
        case 'facebook':
          return $this->render('facebook');
          break;

        default:
          return $this->render('facebook');
          break;
      }
    }
}


?>
