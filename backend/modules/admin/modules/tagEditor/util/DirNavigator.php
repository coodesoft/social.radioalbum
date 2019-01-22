<?php
namespace admin\modules\tagEditor\util;

use Yii;
use common\util\RAFileHelper;

class DirNavigator{

  private $root;

  public function __construct($root = null){
    if (!$root)
       $root = Yii::getAlias('@catalog');

    $this->root = $root;
  }


  protected function _navigate($path){
    if (is_dir($path)) {
      if ($dh = opendir($path)) {
        $result = [];
        while (($file = readdir($dh)) !== false) {

          if ($file!="." && $file!=".."){
            if (is_dir($path ."/".$file))
              $result['dir'][] = $file;
            else{
              $mime = RAFileHelper::getMimeType($path ."/".$file);
              if ($mime == 'audio/mpeg')
                $result['file'][] = $file;
            }
          }
        }
        closedir($dh);
        return $result;
      }
    }else
      throw new \Exception(Yii::t('app', 'invalidDir') . ": ". $path, 1);
  }

  public function navigate($path = null){
    $fullPath = $this->root;

    if ($path){
      $fullPath .=  DIRECTORY_SEPARATOR . $path;

    }
    return $this->_navigate($fullPath);
  }


  public static function getFullPath($path){
    return RAFileHelper::normalizePath(Yii::getAlias('@catalog') . $path);
  }

}
