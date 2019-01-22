<?php
namespace admin\services;
use backend\modules\artist\models\Artist;

use common\util\Requester;

class ArtistService{

  protected function compareAlbums($raAlbums, $ampAlbums){
    $mirror = array();
    $delete = array();
    foreach($raAlbums as $album){
      $id = $album->id_referencia;
      $pos = array_search($id, $ampAlbums);
      if ($pos !== false)
        unset($ampAlbums[$pos]);
      else
        $delete[] = $album->id;
    }
    if (!empty($delete))
      $mirror['delete'] = $delete;

    if (!empty($ampAlbums))
      $mirror['add'] = $ampAlbums;

    return $mirror;
  }

  public function compare($stored, $external){
    $mirror = array();

    //se comaparan los álbumes del artista en ampache y en radioalbum
    $albumResult = $this->compareAlbums($stored['albums'], $external['album']);
    $albumsDiff = (empty($albumResult)) ? false : true;


    //si todas las propiedades son iguales se retorna null
    if (($stored['name'] == $external['name']) &&
        ($stored['begin_date'] == $external['yearformed']) &&
        ($stored['presentation'] == $external['presentation']))
        return null;


    if ($stored['name'] != $external['name']){
      $mirror['name'] = $external['name'];
    } else
      $mirror['name'] = $stored['name'];


    if ($stored['begin_date'] != $external['yearformed']){
      $mirror['begin_date'] = $external['yearformed'];
    }

    if ($stored['presentation'] != $external['presentation']){
      $mirror['presentation'] = $external['presentation'];
    }

    $mirror['albums'] = $albumResult;
    $mirror['id'] = $stored['id'];
    return $mirror;
  }

}


 ?>
