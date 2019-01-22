<?php
namespace common\widgets\gridView;

use common\widgets\RaBaseWidget;

class GridView extends RaBaseWidget{

    public $elements;

    public $enviroment;

    public $clean;

    public $lazyLoad = [
      'route' => '',
      'visible' => true,
    ];

    public $partialRender = false;

    public function init(){
      parent::init();
      $lazy = $this->lazyLoad ;
      $this->lazyLoad['route'] = isset($lazy['route'])  ? $lazy['route'] : '';
      $this->lazyLoad['visible'] = isset($lazy['visible'])  ? $lazy['visible'] : true;
    }

    public function run(){

      if (isset($this->enviroment) && $this->enviroment == 'minimal')
        return $this->render('minimal', ['elements' => $this->elements, 'clean' => $this->clean]);



      if (!$this->partialRender)
        return $this->render('view', ['elements' => $this->elements, 'lazyLoad' => $this->lazyLoad, 'clean' => $this->clean]);
      else
       return $this->render('partial', ['elements' => $this->elements, 'clean' => $this->clean]);
    }
}


?>
