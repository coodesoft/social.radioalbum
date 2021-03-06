<?php
namespace common\util;

use yii\helpers\FileHelper;

class RAFileHelper extends FileHelper{


  /*
   * Hay que agregar validaciones de seguridad
   */
  public static function getFileName($path){
    $position = strrpos($path, DIRECTORY_SEPARATOR);
    $filename = substr($path, $position + 1);

    $position = strrpos($filename, '.');
    $filename = substr($filename, 0, $position);
    return $filename;
  }

  public static function getExtension($path){
    $position = strrpos($path, '.');

    if ($position<0)
      return null;

    return substr($path, $position+1);
  }

  public static function rrmdir($src) {
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            $full = $src . '/' . $file;
            if ( is_dir($full) ) {
                rrmdir($full);
            }
            else {
                unlink($full);
            }
        }
    }
    closedir($dir);
    return rmdir($src);
}

}
