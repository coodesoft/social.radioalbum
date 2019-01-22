<?php
namespace common\widgets\loadBar;

use common\widgets\RaBaseWidget;

class LoadBar extends RaBaseWidget{

    public $elements;

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
      if (!$this->partialRender)
        return $this->render('view', ['elements' => $this->elements, 'lazyLoad' => $this->lazyLoad]);
      else
       return $this->render('partial', ['elements' => $this->elements]);
    }
}


?>
