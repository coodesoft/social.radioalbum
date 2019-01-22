<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\util\Flags;
use common\util\Response;
use common\util\StrProcessor;
use common\services\AppService;
/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }


    private function saveLastAccess($model){
      $model->last_access = (string)time();
      if (!$model->save())
        Yii::error($model->errors);

    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login(){
        if ($this->validate()) {
            $userModel = $this->getUser();

            $result = Yii::$app->user->login($userModel, $this->rememberMe ? 3600 * 24 * 30 : 0);

            if ($result){
              if (AppService::isBackend() && Yii::$app->user->can('loginInAdminArea')){
                $this->saveLastAccess($userModel->access);
                return Response::getInstance(true, Flags::ALL_OK);
              } elseif (AppService::isFrontend() && Yii::$app->user->can('loginInPublicArea')){
                    $this->saveLastAccess($userModel->access);
                    return Response::getInstance(true, Flags::ALL_OK);
                  }else{
                    Yii::$app->user->logout();
                    return Response::getInstance(false, Flags::UNAUTHORIZED_USER);
                  }
            } else {
              Yii::$app->user->logout();
              return Response::getInstance(false, Flags::LOGIN_CREDENTIAL);
            }
        } else {
            Yii::$app->user->logout();
            return Response::getInstance(false, Flags::FORM_VALIDATION);
        }
    }

    public function oAuthLogin($userModel){

      $result = Yii::$app->user->login($userModel, $this->rememberMe ? 3600 * 24 * 30 : 0);

      if ($result){
        if (AppService::isBackend() && Yii::$app->user->can('loginInAdminArea')){
          $this->saveLastAccess($userModel->access);
          return Response::getInstance(true, Flags::ALL_OK);
        } elseif (AppService::isFrontend() && Yii::$app->user->can('loginInPublicArea')){
              $this->saveLastAccess($userModel->access);
              return Response::getInstance(true, Flags::ALL_OK);
            }else{
              Yii::$app->user->logout();
              return Response::getInstance(false, Flags::UNAUTHORIZED_USER);
            }
      } else {
        Yii::$app->user->logout();
        return Response::getInstance(false, Flags::LOGIN_CREDENTIAL);
      }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser(){
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
