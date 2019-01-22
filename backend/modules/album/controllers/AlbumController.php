<?php
namespace backend\modules\album\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\controllers\RaBaseController;
use backend\modules\album\models\Album;

use common\util\Flags;
use common\util\Response;
use common\util\mapper\Mapper;
use common\models\User;


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
                    'actions' => ['view'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['status'],
                    'allow' => true,
                    'roles' => ['admin', 'regulator'],
                ],
          ],
      ],
    ];
  }

  public function actionView($id){
    $user = User::findOne(Yii::$app->user->id);

    $id = Yii::$app->request->get('id');
    $album= Album::findOne($id);


    return  $this->renderSection('album', ['songs' => $album->songs]);
  }

  public function actionStatus(){
    $albumParam = Yii::$app->request->post('Album');

    if (isset($albumParam) && $album = Album::findOne($albumParam['id'])){
      $album->status = ($album->status == 1) ? 0 : 1;

      $statusLabel = ($album->status) ? Yii::t('app', 'active') : Yii::t('app', 'inactive');
      $btnLabel = ($album->status) ? Yii::t('app', 'disableAlbum') : Yii::t('app', 'enableAlbum');
      if ($album->save()){
        $response = [ 'id' => $album->id,
                      'statusLabel' => $statusLabel,
                      'btnLabel' => $btnLabel,
                    ];
        return Response::getInstance($response, Flags::SAVE_SUCCESS)->jsonEncode();
      }

      return Response::getInstance(['errors' => $album->errors], Flags::SAVE_ERROR)->jsonEncode();

    }
  }

}
