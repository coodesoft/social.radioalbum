<?php
namespace common\services;

use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;

class DataService{

  public $provider;

  protected $pageSize = 24;

  public function __construct(){
    $this->provider = new ActiveDataProvider([
      'pagination' => [
          'pageSize' => $this->pageSize,
      ],
    ]);
  }

  public function setQuery($value = null){
    if ($value instanceof QueryInterface)
      $this->provider->query = $value;
    else
      $this->createCustomQuery($value);
  }

  public function getData($segment = null){
    if ($segment == null)
      $segment = 0;

    $this->provider->pagination->page = $segment;
    return $this->provider->getModels();
  }

  public function isLastPage(){
    return $this->provider->pagination->pageCount == ($this->provider->pagination->page + 1);
  }

  protected function createCustomQuery($value = null){}

}
