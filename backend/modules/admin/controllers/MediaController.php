<?php
namespace admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\UploadedFile;

use backend\controllers\RaBaseController;
use backend\modules\album\models\Album;

use admin\models\UploadAlbumForm;


use common\util\ArrayProcessor;
use common\util\Response;
use common\util\Flags;
use common\services\DataService;

class MediaController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['view', 'album', 'add', 'enable', 'disable', 'edit'],
                    'allow' => true,
                    'roles' => ['admin', 'regulator'],
                ],
          ],
      ],
    ];
  }

  protected function getDataSegment($route, $view, $service, $segment){
    $rows = $service->getData($segment);
    $segment = $segment + 1;
    $params = Yii::$app->request->getQueryParams();
    $params['segment'] = $segment;
    $infinite['route'] = Url::to(array_merge([$route], $params));

    $infinite['status'] =  $service->isLastPage();
    $infinite['content'] = $this->renderPartial($view, ['albums'=> $rows]);
    return Response::getInstance($infinite, Flags::ALL_OK)->jsonEncode();
  }

  public function actionView(){
    $service = new DataService();
    $query = Album::find();

    $service->setQuery($query);
    $segment = Yii::$app->request->get('segment');
    if ($segment){
      return $this->getDataSegment('/admin/media/view', 'list-lazy', $service, $segment);
    } else{
      $rows = $service->getData();
      $visible = ($service->isLastPage()) ? false : true;
      $lazyRoute = Url::to(['/admin/media/view', 'segment' => 1]);
      $body = $this->renderPartial('albums', ['albums' => $rows, 'lazyLoad' => ['route' => $lazyRoute, 'visible' => $visible]]);
      return $this->renderSection('view', ['body' => $body, 'title' => \Yii::t('app', 'catalogAdminArea')]);
    }
  }
  
  public function actionAlbum(){
	$id = Yii::$app->request->get('id');
	
	if (is_numeric($id) && $id>0){
		$album = Album::findOne($id);
		return $this->renderSection('album', ['album' => $album]);
	}
	throw new \Exception('Incorrect Param Type', 1);
	
  }
  
  public function actionEdit(){
	$id = Yii::$app->request->get('id');
	
	if (Yii::$app->request->isPost) {
	    
	} else{
	    
	}

  }
  
  public function actionAdd(){
      $model = new UploadAlbumForm();
      if (Yii::$app->request->isPost) {
          $model->load(Yii::$app->request->post());
          $model->image = UploadedFile::getInstance($model, 'image');
          $model->songs = UploadedFile::getInstances($model, 'songs');
          $upload = $model->upload();
          if ($upload->getFlag() === Flags::ALL_OK) {
              $message = ['text' => Yii::t('app', 'uploadAlbumSuccess'), 'type' => 'success'];
              return Response::getInstance($message, Flags::UPLOAD_SUCCESS)->jsonEncode();
          }
          
          $response = ArrayProcessor::toString($upload->getResponse());
          $message = ['text' => $response, 'type' => 'danger'];
          return Response::getInstance($message, $upload->getFlag())->jsonEncode();
      }
      return $this->renderSection('add', ['model' => $model]);
  }
  
  public function actionEnable(){
	$id = Yii::$app->request->get('id');
	$album = Album::findOne($id);
	$album->status = 1;
	if ( $album->save() ) 
	    return Response::getInstance(Url::to(['/admin/media/disable', 'id' => $id]), FLags::SAVE_SUCCESS)->jsonEncode(); 
	          
	return Response::getInstance(Json::encode($album->errors), Flags::SAVE_ERROR)->jsonEncode();
	        
	  
  }

  public function actionDisable(){
	$id = Yii::$app->request->get('id');
	$album = Album::findOne($id);
	$album->status = 0;
	if ( $album->save() )
	    return Response::getInstance(Url::to(['/admin/media/enable', 'id' => $id]), FLags::SAVE_SUCCESS)->jsonEncode(); 
	
	    return Response::getInstance(Json::encode($album->errors), Flags::SAVE_ERROR)->jsonEncode(); 
  }
  
  public function actionModal(){
	$id = Yii::$app->request->get('id');
	  
  }
  
  public function actionRemove(){
	$id = Yii::$app->request->get('id');
	  
  }

}
