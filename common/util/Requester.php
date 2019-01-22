<?php
namespace common\util;

class Requester{

  public static function get($url, $params = null, $transfer = true){
    if ($params != null){
      $paramStr = "";
      $keys = array_keys($params);
      $last_key = array_pop($keys);
      $last_param = array_pop($params);

      foreach($params as $key => $value){
        $paramStr.= $key ."=" . $params[$key] ."&";
      }
      $paramStr.= $last_key."=".$last_param;
      $url .= $paramStr;
    }
    $curl = curl_init($url);
    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => $transfer,
      CURLOPT_SSL_VERIFYPEER => false,
      ));
    $connection = curl_exec($curl);
    curl_close($curl);
    return $connection;
  }
}
?>
