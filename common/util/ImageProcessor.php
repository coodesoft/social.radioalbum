<?php
namespace common\util;

use Yii;
use common\util\mapper\Mapper;

class ImageProcessor{

  public static function cropSquareImage($filename){
    if (is_file($filename)){
      list($width, $height) = getimagesize($filename);

      $mime = mime_content_type($filename);

      switch ($mime) {
        case 'image/png':
        $tmpArt = imagecreatefrompng($filename);
        break;
        case 'image/jpeg':
          $tmpArt = imagecreatefromjpeg($filename);
          break;
        case 'image/bmp':
          $tmpArt = imagecreatefromwbmp($filename);
          break;
        case 'image/webp':
          $tmpArt = imagecreatefromwebp($filename);
          break;
        case 'image/gif':
          $tmpArt = imagecreatefromgif($filename);
          break;
      }

      if ($width>=$height){
        $imagen_p = imagecreatetruecolor($height, $height);
        imagecopyresampled($imagen_p, $tmpArt, 0, 0, 0, 0, $height, $height, $width, $height);
      }else{
        $imagen_p = imagecreatetruecolor($width, $width);
        imagecopyresampled($imagen_p, $tmpArt, 0, 0, 0, 0, $width, $width, $width, $height);
      }

      ob_start();
        imagejpeg($imagen_p);
        $newImage = ob_get_contents();
      ob_end_clean();

      return $newImage;
    }
    return null;
  }

  public static function thumbnail($img = null, $entity = null){
    if (isset($img) && isset($entity)){
      $model = ($entity == 'profile' || $entity == 'album' || $entity == 'channel') ? Mapper::mapModel($entity) : null;
      if ($model){
          $path = $model::dataPath();
          $image = $path . $img;
      } else
        $image = Yii::getAlias('@frontend') . '/web/img/art-back-alt-1.png';
    } else
      $image = Yii::getAlias('@frontend') . '/web/img/art-back-alt-1.png';


      $mime = mime_content_type($image);
      ob_clean();
      return \Yii::$app->response->sendFile($image, null, ['mimeType' => $mime])->send();
  }

}
