<?php
namespace frontend\modules\musicPanel\components\webPlayer;

use common\widgets\RaBaseWidget;
use common\util\MobileDetect;



class webPlayer extends RaBaseWidget{

  public $mode = 'full';

  public function run(){
    $detect = new MobileDetect();

    if ( $detect->isMobile() )
      return $this->render('viewMobile', ['mode' => $this->mode] );
    else
      return $this->render('view', ['mode' => $this->mode] );
  }

}
?>
