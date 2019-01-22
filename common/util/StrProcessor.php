<?php
namespace common\util;

use Yii;

class StrProcessor {

    public static function functionalClassName($className){
      return strtolower(substr($className, strrpos($className,  "\\")+1));
    }

    public static function stringContains($haystack, $needle){
      $result = strpos($haystack, $needle);
      if ($result === false)
        return false;
      return true;
    }

    public static function secondsToMinutes($time){
      $mins = floor ($time / 60);
      $time = $time % 60;
      $time = ($time<10) ? '0'.$time : $time;

      return $mins.":".$time;
    }

    public static function formatDate($format, $time){
        return date($format, $time);
    }

    public static function prettyDate($control, $time){
      $timediff = $control - $time;
      //throw new \Exception("Error Processing Request: ".$timediff." = ".$control." - ".$time, 1);

      $years = intval($timediff / 31536000);
      $remain = $timediff % 31536000;

      $months = intval($remain / 2628000);
      $remain = $timediff % 2628000;

      $days = intval($remain / 86400);
      $remain = $timediff % 86400;

      $hours = intval($remain / 3600);
      $remain = $remain % 3600;

      $mins = intval($remain / 60);
      $secs = $remain % 60;

      if ($secs >= 0)  $timestring = Yii::t('app', 'momentsAgo');

      if ($mins == 1)  $timestring = Yii::t('app', 'oneMinuteAgo');
      if ($mins > 1)   $timestring = Yii::t('app', 'minutesAgo, {time}', ['time' => $mins]);

      if ($hours == 1) $timestring = Yii::t('app', 'oneHourAgo');
      if ($hours > 1)  $timestring = Yii::t('app', 'hoursAgo, {time}', ['time' => $hours]);

      if ($days == 1)  $timestring = Yii::t('app', 'oneDayAgo');
      if ($days > 1)   $timestring = Yii::t('app', 'daysAgo, {time}', ['time' => $days]);

      if ($months == 1) $timeString = Yii::t('app', 'oneMonthAgo');
      if ($months > 1)  $timeString = Yii::t('app', 'monthsAgo, {time}', ['time' => $months]);

      if ($years == 1) $timeString = Yii::t('app', 'oneMonthAgo');
      if ($years > 1)  $timeString = Yii::t('app', 'monthsAgo, {time}', ['time' => $years]);

      return $timestring;
    }

    public static function cleanCssSelector($selector){
      $type = substr($selector, 0, 1);

      if (($type == '.') || ($type == '#'))
        return substr($selector, 1);

      //TO DO: para selectores mas complejos del tipo : [attr="value"]
    }

    public static function mapToClassName($str){
      $array = explode('_', $str);

      if ($array){
        $className = '';
        foreach ($array as $value)
          $className .= ucfirst($value);

        return $className;
      }
      return false;
    }

    public static function getRandomString($source = null){
      $hash = 'abecdefghijklmnopqrstuvwyzABCEDFGHIJKLMNOPQRSTUVWXYZ123456789#*_';
      if (!$source)
       $source = $hash;
      return sha1($source.'_'.$hash, false);
    }

}
