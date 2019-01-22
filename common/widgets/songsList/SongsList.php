<?php
namespace common\widgets\songsList;

use common\widgets\RaBaseWidget;
use common\util\mapper\Mapper;
use common\util\MobileDetect;

use common\models\User;

use Yii;

class SongsList extends RaBaseWidget{

    public $songs;

    public $theme = 'ra-dark';

    public $profile_id;

    public $playlist_id;

    public $lazyLoad = [
      'route' => '',
      'visible' => true,
    ];

    public $partialRender = false;

    public $cols = [
      'time'=> 1,
      'name'=> 1,
      'date' => 0,
      'album'=> 1,
      'artist'=> 1,
      'actions' => [
          'action' => 1,
          'items' => ['add'=>1, 'play' =>1, 'favs' =>1, 'remove' =>0],
        ]
    ];

    public function init(){
      parent::init();
      $cols = [
        'time'=> 1,
        'name'=> 1,
        'date' => 0,
        'album'=> 1,
        'artist'=> 1,
        'actions' => [
            'action' => 1,
            'items' => ['add'=>1, 'play' =>1, 'favs' =>1, 'remove' =>0],
          ],
      ];
      $tmp = $this->cols;

      foreach($cols as $t => $col){
        if (isset($tmp[$t]))
          $cols[$t] =  $tmp[$t];
      }
      $this->cols = $cols;

      //**********************************************************
      $lazy = $this->lazyLoad ;

      $this->lazyLoad['route'] = isset($lazy['route'])  ? $lazy['route'] : '';
      $this->lazyLoad['visible'] = isset($lazy['visible'])  ? $lazy['visible'] : true;
    }

    public function run(){
      $mobile = new MobileDetect();
      $view = $mobile->isMobile() ? '-mobile' : '';

      if (!$this->partialRender){
        $view = 'view' . $view;
        return $this->render($view, ['songs' => $this->songs,
                                      'theme' => $this->theme,
                                      'cols'=> $this->cols,
                                      'profile_id' => $this->profile_id,
                                      'playlist_id' => $this->playlist_id,
                                      'lazyLoad' => $this->lazyLoad]);
      } else{
        $view = 'partial'.$view;
        return $this->render($view, ['songs' => $this->songs,
                                         'cols'=> $this->cols,
                                         'profile_id' => $this->profile_id,
                                         'playlist_id' => $this->playlist_id]);
      }
    }
}


?>
