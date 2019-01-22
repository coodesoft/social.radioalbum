<?php
namespace common\util;

use Yii;
use yii\helpers\Url;

class ArrayProcessor {

  public static function toString($array){
      $string = '';
      if (is_array($array))
        foreach($array as $key => $item){
          if (!is_int($key))
            $string .= " $key : " . ArrayProcessor::toString($item)." <br>";
          else
            $string .= ArrayProcessor::toString($item);
        }
      else
       $string = $array;
      return $string;
  }

  public static function objectToArrayRepresentation($element, $endpoint, $actions){
    $obj = array();
    $obj['id'] = $element->id;
    $obj['name'] = $element->name;
    $obj['art'] = Url::to(['/ra/thumbnail', 'id' => $element->art, 'entity' => $endpoint]);
    $obj['url'] = Url::to(['/'.$endpoint.'/'.$endpoint.'/view', 'id'=>$element->id]);

    $obj['actions'] = $actions;
    return $obj;
  }

  public static function userToArrayRepresentation($entity, $route, $actions){
    $obj = array();
    $obj['name'] = $entity['name'];
    $obj['id'] = $entity['id'];
    $obj['art'] = Url::to(['/ra/thumbnail', 'id' => $entity['profile']['photo'], 'entity' => 'profile']);
    $obj['url'] = Url::to([$route, 'id' => $obj['id']]);

    $actions['pop'] = [];
    $actions['pop'][] = ['text' => Yii::t('app', 'report'), 'url' => Url::to(['/report/load', 'id' => $entity['profile']['id'], 'entity' => 'profile'])];
    $obj['actions'] = $actions;
    return $obj;
  }

  public static function profileToArrayRepresentation($entity){
    $obj = array();
    $obj['id'] = $entity['id'];
    $obj['art'] = Url::to(['/ra/thumbnail', 'id' => $entity['photo'], 'entity' => 'profile']);

    if ($entity['artist_id']){
      $obj['name'] = $entity['artist_name'];
      $obj['url'] = Url::to(['/artist/artist/view', 'id' => $entity['artist_id']]);
    }
    if ($entity['listener_id']){
      $obj['name'] = $entity['listener_name'];
      $obj['url'] = Url::to(['/listener/listener/view', 'id' => $entity['listener_id']]);
    }

    return $obj;
  }

}
