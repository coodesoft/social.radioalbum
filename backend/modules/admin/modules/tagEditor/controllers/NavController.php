<?php
namespace admin\modules\tagEditor\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Json;

use backend\controllers\RaBaseController;
use admin\modules\tagEditor\models\TagEditForm;

use common\util\Flags;
use common\util\Response;


class NavController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['navigate', 'edit'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
          ],
      ],
    ];
  }

  protected function attachTagsToFiles($path, $files){
    $filesWithTags = array();

    $navigator = $this->module->get('dirNavigator');
    $tagEditor = $this->module->get('tagEditor');

    try {
      foreach($files as $file){
          $filePath = $navigator::getFullPath(DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $file);
          $tags = $tagEditor->getTags($filePath);
          $filesWithTags[] = ['name' => $file, 'tags' => $tags];
      }
      return $filesWithTags;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
    return false;
  }

  /**
   * request param : 'navigate' retorna el string de la ruta relativa
   */

  public function actionNavigate(){
    $navigator = $this->module->get('dirNavigator');
    $path = Yii::$app->request->get('dir');

    $path = isset($path) ? Html::decode($path) : null;
    $objects = $navigator->navigate($path);
    if (isset($objects['file'])){
      $result =  $this->attachTagsToFiles($path, $objects['file']);
      if (is_array($result))
        $objects['file'] = $result;
    }
    if ($path)
      return $this->renderSection('navigate-partial', ['objects' => $objects, 'parent' => $path]);

    return $this->renderSection('navigate', ['objects' => $objects]);
  }

  public function actionEdit(){
    $tagEditor = $this->module->get('tagEditor');
    $tagForm = new TagEditForm();

    $tags = Yii::$app->request->get('tags');


    if (Yii::$app->request->isPost){
      if ($tagForm->load(Yii::$app->request->post())){
          $songPath = Yii::$app->request->post('SongFile')['path'];
          $songPath = urldecode($songPath);
          if ($songPath && $tagForm){
            $result = $tagForm->setTags($songPath);

            if ($result->getFlag() == Flags::WARNING)
              $message = ['text' => Yii::t('app', 'okButWarning') . ArrayProcessor::toString($result->getResponse()), 'type' => 'warning'];

            if ($result->getFlag() == Flags::SAVE_ERROR)
              $message = ['text' => Yii::t('app', 'errorAndDescription') . ArrayProcessor::toString($result->getResponse()), 'type' => 'danger'];
            else
              $message = ['text' => Yii::t('app', 'editTagSuccess'), 'type' => 'success'];

            return Response::getInstance($message, $result->getFlag())->jsonEncode();
        }
        return Response::getInstance(Yii::t('app', 'errorParam'), Flags::ERROR)->jsonEncode();
      }


    }
    $songPath = Yii::$app->request->get('song');
    if ($songPath && $tags){
      $tags = Json::decode($tags);
      $tagForm->name = $tags['title'][0];
      $tagForm->album = $tags['album'][0];
      $tagForm->artist = $tags['artist'][0];
      $tagForm->channel = $tags['genre'][0];
      return $this->renderSection('edit', ['model' => $tagForm]);
   }





  }

}
