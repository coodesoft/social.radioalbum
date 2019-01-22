<?php
namespace frontend\modules\album\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;

use common\models\User;
use common\util\Flags;
use common\util\Response;

use frontend\controllers\RaBaseController;
use frontend\modules\album\models\Album;

use searcher\services\Searcher;
use searcher\services\AlbumFilter;

/**
 * Album controller
 */

class AlbumController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['view', 'list', 'albums', 'list-by-channel'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
          ],
      ],
    ];
  }

  public function actionView($id){
    $user = User::findOne(Yii::$app->user->id);
    $profile = $user->getAssociatedModel()->profile;

    if (!isset($id) && !is_numeric($id))
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $id = Yii::$app->request->get('id');
    $album= Album::findOne($id);

    return  $this->renderSection('album', ['element' => $album,
                                           'profile_id' => $profile->id]);
  }


  public function actionList(){
    $entity = Yii::$app->request->get('entity');
    $segment = Yii::$app->request->get('segment');

    $albums = array();
    $service = new Searcher();

    $filter = new AlbumFilter();
    $filter->createQuery($entity);

    $params['entity'] = $entity;
    $params['segment'] = $segment;

    return $this->listElements($filter, '/album/album/list', $params, 'albums');
  }

  public function actionAlbums(){
    $list = Album::find()->select('id, name')->orderBy('name')->all();
    return Response::getInstance($list, Flags::ALL_OK)->jsonEncode();
  }

  public function actionListByChannel(){
    $entity = Yii::$app->request->get('entity');
    $segment = Yii::$app->request->get('segment');
    $id = Yii::$app->request->get('id');

    if (!isset($id) && !is_numeric($id))
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    $albums = array();
    $service = new Searcher();

    $filter = new AlbumFilter();
    $filter->relatedChannelId = $id;
    $filter->createQuery($entity);

    $params['entity'] = $entity;
    $params['id'] = $id;
    $params['segment'] = $segment;

    return $this->listElements($filter, '/album/album/list-by-channel', $params, 'albums');
  }
}
