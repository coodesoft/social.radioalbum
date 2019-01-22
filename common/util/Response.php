<?php
namespace common\util;

use yii\helpers\BaseJson;

class Response{


    protected $response;

    protected $flag;


    public function setResponse($resp){
      $this->response = $resp;
    }

    public function setFlag($flag){
      $this->flag = $flag;
    }

    public function getResponse(){
      return $this->response;
    }

    public function getFlag(){
      return $this->flag;
    }

    public function toArray(){
      return ['response' => $this->getResponse(), 'flag' => $this->getFlag()];
    }

    public function jsonEncode(){
      return BaseJson::encode($this->toArray());
    }

    public static function getInstance($response, $flag){
      $obj = new Response();
      $obj->setResponse($response);
      $obj->setFlag($flag);

      return $obj;
    }
}


?>
