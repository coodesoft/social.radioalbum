<?php
namespace admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;

use backend\controllers\RaBaseController;
use backend\models\Channel;
use backend\models\Song;

use backend\modules\artist\models\Artist;
use backend\modules\album\models\Album;

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
                    'actions' => ['view', 'album'],
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

  }
  
  public function actionEnable(){
	$id = Yii::$app->request->get('id');
	  
  }

  public function actionDisable(){
	$id = Yii::$app->request->get('id');
  
  }
  
  public function actionModal(){
	$id = Yii::$app->request->get('id');
	  
  }
  
  public function actionRemove(){
	$id = Yii::$app->request->get('id');
	  
  }

}
