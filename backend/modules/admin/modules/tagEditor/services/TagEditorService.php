<?php
namespace admin\modules\tagEditor\services;

use Yii;
use yii\base\InvalidParamException;

use common\util\Response;
use common\util\Flags;
use common\util\RAFileHelper;

require_once('lib/getid3/getid3.php');
require_once('lib/getid3/write.php');


class TagEditorService{

  private $encoding = 'UTF-8';

  private $extensions;

  private $writer;

  private $reader;

  public function __construct($extensions = null) {
    $this->reader = new \getID3;
    $this->reader->setOption(array('encoding' => $this->encoding));

    $this->writer = new \getid3_writetags;
    $this->writer->tagformats = array('id3v2.4');
    $this->writer->overwrite_tags = true;
    $this->writer->remove_other_tags = false;
    $this->writer->tag_encoding = $this->encoding;

    $this->setAllowedExtensions($extensions);
  }

  protected function internalSetTag($path, $tags){
    $this->writer->filename = $path;

    $newTags = array();
    foreach($tags as $tag => $value){
      if (!is_array($value)){
        $tmpArray = [];
        $tmpArray[] = $value;
        $value = $tmpArray;
      }
      $newTags[$tag] = $value;
    }

    $this->writer->tag_data = $newTags;
    if ($this->writer->WriteTags()) {
    	return Response::getInstance(true, Flags::SAVE_SUCCESS);
    	if (!empty($this->writer->warnings)) {
        return Response::getInstance($this->writer->warnings, Flags::WARNING);
    	}
    } else {
      return Response::getInstance($this->writer->errors, Flags::SAVE_ERROR);
    }
  }

  /**
   * @throws Exception si la ruta al directorio es invalida
   */
  public function setDirectoryTags($path, $tags){
      try {
        $files = RAFileHelper::findFiles($path);
      } catch (InvalidParamException $e) {
        throw new \Exception(Yii::t('app', 'invalidRoute'), 1);
      }

      $errors = array();
      $warnings = array();

      foreach ($files as $file) {
          $extension = RAFileHelper::getExtension($file);
          if (in_array($extension, $this->extensions)){
              $tmpArray = [];
              $songName = RAFileHelper::getFileName($file);
              $tmpArray[] = $songName;
              $tags['title'] = $tmpArray;

              $result = $this->internalSetTag($file, $tags);

              if ($result->getFlag() == Flags::WARNING)
                $warnings [] = $result->getResponse();
              elseif($result->getFlag() == Flags::SAVE_ERROR)
                $errors [] = $result->getResponse();
          }
      }

      if (!empty($warnings))
        return Response::getInstance($warnings, Flags::WARNING);

      if (!empty($errors))
        return Response::getInstance($errors, Flags::SAVE_ERROR);

      return Response::getInstance(true, Flags::ALL_OK);

  }

  /**
   * @throws Exception si la ruta al archivo es invalida
   */
  public function setFileTags($path, $tags){
    if (!is_file($path))
      throw new \Exception(Yii::t('app', 'invalidFile'). ': ' .$path, 1);

    return $this->internalSetTag($path, $tags);
  }

  /**
   * @throws Exception si la $path no es un archivo válido
   */
  public function getTags($path, $tags = null){
    if (!$tags)
      $tags = array('title', 'album', 'artist', 'genre');

    if (is_file($path)){
      $result = $this->reader->analyze($path);

      foreach($tags as $index => $name){
  			if (isset($result['tags']['id3v2'][$name]))
  				$tagValues[$name] = $result['tags']['id3v2'][$name];
  			else
  				$tagValues[$name] = [Yii::t('app', 'unknown')];
  		}
      return $tagValues;
    } else
      throw new \Exception(Yii::t('app', 'invalidFile'), 1);

  }

  public function getAllowedExtentions(){
    return $this->extensions;
  }

  public function setAllowedExtensions($extensions = null){
    if (isset($extensions))
      $this->extensions = is_array($extensions) ? $extensions : [$extensions];
    else
      $this->extensions = ['mp3'];
  }

}
