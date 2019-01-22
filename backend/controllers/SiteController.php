<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Gender;
use common\models\User;
use common\util\Flags;
use common\util\Response;
use backend\models\Profile;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
     public function actionLogin(){
       return $this->actionIndex();
     }

    public function actionIndex(){
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['ra/main']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())){

          $result = $model->login();
          if ($result->getResponse()){
            return $this->redirect(['ra/main']);
          }
          $flag = $result->getFlag();
        } else
          $flag = Flags::FORM_LOAD_MODEL;


        $error = array('msg' => '', 'class' =>'');
        switch ($flag){
          case Flags::LOGIN_CREDENTIAL:
            $error['msg'] = Yii::t('app','errorAlLogin');
            $error['class'] = 'ra-error';
            break;
          case Flags::FORM_VALIDATION:
            $error['msg'] = Yii::t('app','errorIncUserPass');
            $error['class'] = 'ra-error';
            break;
          case Flags::UNAUTHORIZED_USER:
              $error['msg'] = Yii::t('app','errorUserNAut');
              $error['class'] = 'ra-error';
            break;
        }
        return $this->render('login', [
            'model' => $model,
            'error' => $error,
        ]);

    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
