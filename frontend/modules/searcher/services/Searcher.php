<?php
namespace searcher\services;

use common\util\Response;
use common\util\Flags;

use common\services\DataService;

class Searcher{

  private $service;

  public function search($filter, $segment = null){
    if (!$this->service)
      $this->service = new DataService();

    $query = $filter->getQuery();
    $this->service->setQuery($query);

    if ($segment)
      return $this->service->getData($segment);

    return $this->service->getData();
  }

  public function stopSearch(){
    return $this->service->isLastPage();
  }
}
