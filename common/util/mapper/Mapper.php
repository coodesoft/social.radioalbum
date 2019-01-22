<?php
namespace common\util\mapper;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\User;

class Mapper {

    private $map;

    public static function mapModel($model){
      $map = require('map.php');
      return isset($map['model'][$model]) ? $map['model'][$model] : null;
    }

    public static function mapRoute($model){
      $map = require('map.php');
      return isset($map['route'][$model]) ? $map['route'][$model] : null;
    }

}
