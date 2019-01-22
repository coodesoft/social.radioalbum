<?php
namespace common\widgets\profile;

use common\widgets\RaBaseWidget;
use frontend\modules\listener\models\Listener;
use yii\helpers\Url;

use common\util\MobileDetect;

class Profile extends RaBaseWidget{

    public $user;

    public $sections;

    public $productions;

    public $action;

    public $relationships;

    public function init(){
      parent::init();

      if (get_class($this->user) != Listener::className())
        $this->sections = [
            'posts'  => ['label' => 'Publicaciones', 'uri' => 'posts'],
            'albums' => ['label' => 'Discos', 'uri' => 'albums'],
          ];
      else
        $this->sections = [
          'posts'  => ['label' => 'Publicaciones', 'uri' => 'posts'],
        ];

    }

    public function run(){
      $params = ['user' => $this->user,
                 'sections'=> $this->sections ,
                 'productions' => $this->productions,
                 'relationships' => $this->relationships,
                 'action' => $this->action
               ];
      $detect = new MobileDetect();

      $params['mobile'] = $detect->isMobile() ? true : false;

      return $this->render('view', $params);
    }
}


?>
