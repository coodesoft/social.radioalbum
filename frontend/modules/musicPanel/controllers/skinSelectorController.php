<?php
namespace frontend\modules\musicPanel\components\skinSelector\controllers;

use Yii;
use yii\helpers\BaseJson;
use yii\filters\AccessControl;

class skinSelectorController extends RaBaseController{

  public function behaviors(){
  return [
    'access' => [
        'class' => AccessControl::className(),
        'rules' => [
              [
                'actions' => ['change-skin'],
                'allow' => true,
                'roles' => ['@'],
              ],
        ],
    ],
  ];
}

}

?>
