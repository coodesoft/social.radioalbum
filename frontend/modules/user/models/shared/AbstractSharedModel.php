<?php
namespace user\models\shared;

use common\models\ComponentInterface;

abstract class AbstractSharedModel implements ComponentInterface{

  public $type;

  public $id;

  public $name;

  public $url;

  public $imgUrl;

  public function setParams($type, $id, $name, $url, $imgUrl){
    $this->type = $type;
    $this->id = $id;
    $this->name = $name;
    $this->url = $url;
    $this->imgUrl = $imgUrl;
  }


  abstract public function getModel($param);

}
