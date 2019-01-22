<?php
namespace common\util;

use common\util\Response;

class InfiniteScrollResponse extends Response {


  private function __construct(){
    $response = array();
  }

  public function setStatus($status){
    $this->response['status'] = $status;
  }

  public function setContent($content){
    $this->response['content'] = $content;
  }

  public function setRoute($route){
    $this->response['route'] = $route;
  }

  public function getStatus(){
    return $this->response['status'];
  }

  public function getContent(){
    return $this->response['content'];
  }

  public function getRoute(){
    return $this->response['route'];
  }

  public function toArray(){
    $response = ['status' => $this->getStatus(), 'content' => $this->getContent(), 'route' => $this->getRoute()];
    return ['response' => $response, 'flag' => $this->getFlag()];
  }

  public static function getInstance($status, $content, $route, $flag){
    $response = new InfiniteScrollResponse();
    $response->setStatus($status);
    $response->setContent($content);
    $response->setRoute($route);
    $response->setFlag($flag);

    return $response;

  }
}
