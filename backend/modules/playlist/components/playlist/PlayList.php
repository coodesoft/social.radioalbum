<?php
namespace backend\modules\playlist\components\playlist;

use common\widgets\RaBaseWidget;

class PlayList extends RaBaseWidget{

    public $playlists;

    public $profile;

    public $enviroment;

    public $element;

    public function init(){
      parent::init();
    }

    public function run(){
      switch ($this->enviroment) {
        case 'extended':
          return $this->render('extended', ['playlists' => $this->playlists,
                                          'profile'=>$this->profile,]);
          break;
        case 'minimal':
          return $this->render('minimal', ['playlists' => $this->playlists,
                                         'song' =>$this->element,
                                         'profile'=>$this->profile]);
          break;
        case 'update':
          return $this->render('update-list', ['playlist' => $this->element]);
          break;
        default:
          break;
      }
    }
}


?>
