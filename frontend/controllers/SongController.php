<?php
namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\BaseJson;
use yii\helpers\Url;

use common\models\Playlist;
use common\util\Response;
use common\util\Flags;
use common\widgets\modalBox\ModalBox;

//use common\widgets\playList\PlayList;

use frontend\controllers\RaBaseController;

/**
 * Listener controller
 */

class SongController extends RaBaseController {

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                  'actions' => ['modal',
                                'view',
                                'create',
                                'delete',
                                 ],
                  'allow' => true,
                  'roles' => ['@'],
                ],
          ],
      ],
    ];
  }

  public function actionModal(){
      $id  = Yii::$app->request->get('id');
      $action = Yii::$app->request->get('action');

      $playlists = Playlist::find()->all();
      $modal;
      switch ($action) {
        case 'add-to-playlist':
            $content = \common\widgets\playList\PlayList::widget(['playlists' => $playlists,
                                         'route' => 'playlist/add-song',
                                         'element' => $id,
                                         'extended' => false]);
            $modal = ModalBox::widget([
              'title' => 'Eliminar Lista de Reproducción',
              'content' => $content
            ]);
          break;
        case 'update':
          break;
        default:
          break;
      }
      return $modal;
  }
}
