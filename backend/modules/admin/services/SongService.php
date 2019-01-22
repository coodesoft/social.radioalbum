<?php
namespace admin\services;


class SongService{

  public function compare($stored, $external){
      if (($stored['album']['name'] == $external['album']) &&
         ($stored['name'] == $external['name']))
         return null;

      $mirror = array();
      if ($stored['album']['name'] != $external['album']){
        $mirror['album']['old'] = $stored['album']['name'];
        $mirror['album']['new'] = $external['album'];
      } else
        $mirror['album'] = $external['album'];

      if ($stored['name'] != $external['name']){
        $mirror['name']['old'] = $stored['name'];
        $mirror['name']['new'] = $external['name'];
      } else
        $mirror['name'] = $external['name'];
      $mirror['id'] = $stored['id'];
      return $mirror;

  }
}


 ?>
