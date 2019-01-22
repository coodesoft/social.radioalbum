<?php
namespace admin\services;


class AlbumService{

  protected function compareChannels($stored, $external){
    $mirror = array();
    foreach($stored['channels'] as $storedCh){
      $equals = false;
      foreach ($external['channels'] as $e => $extCh)
        if ($extCh == $storedCh['name']){
          unset($external['channels'][$e]);
          $equals = true;
          break;
        }

      if (!$equals)
        $mirror['delete'][] = $storedCh['name'];

    }

    foreach($external['channels'] as $extCh)
      $mirror['add'][] = $extCh;

    return $mirror;
  }

  public function compare($stored, $external){
    $mirror = array();

    $result = $this->compareChannels($stored, $external);
    if (!empty($result)){
      $mirror['channels'] = $result;
      $mirror['name'] = $stored['name'];
      $mirror['id'] = $stored['id'];
      $mirror['art'] = $external['art'];
    }
    return $mirror;
  }
}


 ?>
