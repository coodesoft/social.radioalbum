<?php
namespace frontend\modules\artist\services;

use Yii;
use yii\helpers\Url;

class ArtistService {

  public function userToArrayRepresentation($artist, $actions){
    $obj = array();
    $obj['name'] = $artist['name'];
    $obj['id'] = $artist['id'];
    $obj['art'] = Url::to(['/ra/thumbnail', 'id' => $artist['profile']['photo'], 'entity' => 'profile']);
    $obj['url'] = Url::to(['/artist/artist/view', 'id' => $obj['id']]);

    $actions['pop'] = [];
    $actions['pop'][] = ['text' => Yii::t('app', 'report'), 'url' => Url::to(['/report/load', 'id' => $artist['profile']['id'], 'entity' => 'profile'])];
    $obj['actions'] = $actions;
    return $obj;
  }

}
