<?php
namespace backend\modules\listener\controllers;

use Yii;
use yii\filters\AccessControl;

use backend\controllers\UserController;

use backend\modules\listener\models\Listener;
/**
 * Listener controller
 */

class ListenerController extends UserController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                  'actions' => ['profile',
                                'configuration',
                                ],
                  'allow' => true,
                  'roles' => ['@'],
                ],
          ],
      ],
    ];
  }


  public function actionConfiguration(){
    $id = Yii::$app->user->id;
  }


}
