<?php
namespace common\services;

use yii\helpers\Url;
use common\util\StrProcessor;

class AppService {

  public static function isBackend(){
    return StrProcessor::stringContains(Url::to(), 'backend');
  }

  public static function isFrontend(){
    return StrProcessor::stringContains(Url::to(), 'frontend');
  }
}
