<?php
namespace searcher\services;

abstract class AbstractFilter{

  protected $query;

  public abstract function createQuery($toSearch);

  public abstract function prepareModel($params);

  public function getQuery(){
    return $this->query;
  }

}
