<?php
namespace common\widgets\mainPanel;

use yii\base\Widget;

class MainPanel extends Widget{

    public $items;

    public $searcher;

    public $app = 'frontend';

    public function init(){
      parent::init();
    }

    public function run(){
      return $this->render('panel', ['items' => $this->items, 'app' => $this->app]);
    }
}


?>
