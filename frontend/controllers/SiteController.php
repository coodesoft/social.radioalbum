<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\LoginForm;
use common\models\User;
use common\util\Flags;
use common\util\Response;
use common\models\Role;

use common\services\AppService;

use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Profile;

use yii\web\Response as YiiResp;
use yii\bootstrap\ActiveForm;

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
                'only' => ['logout', 'signup', 'oauth-login', 'auth'],
                'rules' => [
                    [
                        'actions' => ['signup', 'oauth-login', 'auth'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'tos'],
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
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'raOauth\actions\RaAuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
            ],
        ];
    }

    public function oAuthSuccess($client) {
      $userAttributes = $client->getUserAttributes();

      if ($client->getName() == 'facebook')
        $email = $userAttributes['email'];

      if ($client->getName() == 'google')
        $email = $userAttributes['emails'][0]['value'];

      $user = User::find()->where(['username' => $email])->one();

      if ($user){
        $result = Yii::$app->user->login($user, 3600 * 24 * 30);

        if ($result){
          return Response::getInstance(['route' => 'ra/main'], Flags::AUTH_USER_LOGIN);
          //return $this->redirect(['ra/main']);
        }

      } else{
        $signup = new SignupForm();
        $signup->name = $userAttributes['first_name'];
        $signup->lastname = $userAttributes['last_name'];
        $signup->username = $userAttributes['email'];
        $signup->id = $userAttributes['id'];
        $signup->network = $client->getName();

        $roles = Role::find()->all();
        $arrRoles = [];
        foreach ($roles as $key => $role)
          if ($role->id != Role::ADMIN && $role->id != Role::REGULATOR)
              $arrRoles[$role->type] = \Yii::t('app', $role->type);

        return Response::getInstance( [
            'view'  => 'minimal-signup',
            'model' => $signup,
            'roles' => $arrRoles,
        ], Flags::AUTH_USER_SIGNUP );
      }

    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */

     public function actionLogin(){
       return $this->actionIndex();
     }

     public function actionIndex(){
         if (!Yii::$app->user->isGuest) {
             return $this->redirect(['/channel/channel/list']);
         }

         $model = new LoginForm();
         if ($model->load(Yii::$app->request->post())){

           $result = $model->login();
           if ($result->getResponse())
             return $this->redirect(['ra/main']);

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

     public function actionOauthLogin(){
       $oauth = Yii::$app->request->post('oauth');
       if ($oauth){
         $model = new SignupForm();
         if ($model->load(Yii::$app->request->post())) {
             $model->password = Yii::$app->security->generateRandomString();
             $oAuthSignup = $model->oAuthSignup();
             if ($oAuthSignup->getFlag() == Flags::ALL_OK) {

               $user = $oAuthSignup->getResponse();
               $loginForm = new LoginForm();

               $loginResult = $loginForm->oAuthLogin($user);
               if ($loginResult->getFlag() == Flags::ALL_OK)
                  return $this->redirect(['/channel/channel/list']);
               else
                  return $this->redirect(['/site/login']);
             } else{
               return $this->render('messagePage', ['title' => \Yii::t('app','errorGenerico1'),
                                                   'message' => Yii::t('app','unknownError')]);
             }
         } else{
           return $this->render('messagePage', ['title' => \Yii::t('app','errorGenerico1'),
                                               'message' => Yii::t('app','unknownError')]);
         }
       }
     }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout(){
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()  {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Displays tos page.
     *
     * @return mixed
     */
     public function actionTos(){
       return $this->render('tos');
     }

     /**
      * Displays privacy-policy page.
      *
      * @return mixed
      */
      public function actionPrivacyPolicy(){
        return $this->render('privacy-policy');
      }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup(){
        $model = new SignupForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
          Yii::$app->response->format = YiiResp::FORMAT_JSON;
          return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $signupResult = $model->signup();
            if ( !is_array($signupResult) ) {
                return $this->render('messagePage', ['title' => \Yii::t('app','excelente1'),
                                                    'message' => Yii::t('app','regCasiCompleto')]);

            } else {
              throw new \Exception(json_encode($signupResult), 1);

              return $this->render('messagePage', ['title' => \Yii::t('app','errorGenerico1'),
                                                  'message' => Yii::t('app','unknownError')]);


            }
        }
        $roles = Role::find()->all();
        $arrRoles = [];
        foreach ($roles as $key => $role)
          if ($role->id != Role::ADMIN && $role->id != Role::REGULATOR)
          $arrRoles[$role->type] = \Yii::t('app', $role->type);

        return $this->render('signup', [
            'model' => $model,
            'roles' => $arrRoles
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset(){
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $result = $model->sendEmail();
            switch ($result->getFlag()) {
              case Flags::MAIL_SEND_RESULT:
                if ($result->getResponse())
                  return $this->render('messagePage', ['title' => \Yii::t('app','excelente1'), 'message' => Yii::t('app','reqMailPassSend')]);
                else
                  return $this->render('messagePage', ['title' => \Yii::t('app','errorGenerico1'), 'message' => Yii::t('app','reqPassMailError')]);
                break;
              case Flags::USER_NOT_FOUND:
                return $this->render('messagePage', ['title' => \Yii::t('app','errorGenerico1'), 'message' => Yii::t('app','mailNotExist')]);
                break;
              case Flags::USER_DISABLED:
                return $this->render('messagePage', ['title' => \Yii::t('app','errorGenerico1'), 'message' => Yii::t('app','userDisabled')]);
                break;
              case Flags::INVALID_TOKEN:
                return $this->render('messagePage', ['title' => \Yii::t('app','errorGenerico1'), 'message' => Yii::t('app','tokenErrorGen')]);
                break;
            }
        } else
          return $this->render('requestPasswordResetToken', [
              'model' => $model,
          ]);

    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token){
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionActivate(){
      $params = Yii::$app->request->get();
      $user = User::findOne(['id' => $params['id'], 'status' => User::STATUS_INACTIVE]);

      if ($user != null){
        $code = $user->created_at . $user->username;
        if (Yii::$app->getSecurity()->validatePassword($code, $params['token'])) {
          $user->status = User::STATUS_ACTIVE;
          $result = $user->save();
        } else
          $result = false;
      } else
        $result = false;

      return $this->render('activation',[
        'status' => $result,
      ]);
    }

    public function actionActivation(){
      return $this->render('activation',[
        'status' => true,
      ]);

    }

  }
