<?php
namespace backend\modules\artist\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;

use backend\modules\artist\models\Artist;
use backend\controllers\UserController;
/**
 * Site controller
 */
class ArtistController extends UserController{


  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['artist'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
          ],
      ],
    ];
  }

  public function actionArtist(){
    $actions = [];
    if (Yii::$app->user->can('loginInAdminArea')){
      $actions['adicional'][] = ['icon' => 'plus', 'url' => Url::to(), 'type' => 'modal'];
      $actions['adicional'][] = ['icon' => 'star', 'url' => Url::to(), 'type' => 'modal'];
      $actions['adicional'][] = ['icon' => 'share', 'url' => Url::to(), 'type' => 'nav'];
      $actions['main'][] = ['icon' => 'play', 'url' => Url::to(), 'type' => 'playback'];
    }

    $id = Yii::$app->request->get('id');
    $artist = Artist::findOne($id);
    return $this->renderSection('artist_profile', ['artist' => $artist, 'actions' => $actions]);
  }

}
