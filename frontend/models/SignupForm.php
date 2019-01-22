<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Access;
use common\models\Gender;
use common\models\Role;

use common\util\mapper\Mapper;
use common\util\Response;
use common\util\Flags;

use frontend\models\Profile;
use frontend\models\ProfileOpts;
use frontend\modules\listener\models\Listener;
use frontend\modules\playlist\models\Playlist;
use yii\helpers\Url;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $lastname;
    public $username;
    public $password;
    public $role;

    public $id;
    public $network;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'El nombre no puede quedar vacío.'],
            ['name', 'string', 'min'=>2, 'tooShort' => 'El nombre de debe tener al menos 2 caracteres.'],

            ['lastname', 'string', 'min'=>2, 'max'=>255, 'tooShort' => 'El apellido de debe tener al menos 2 caracteres.', 'tooLong' => 'El apellido no puede superar los 255 caracteres'],

            ['role', 'required', 'message' => 'El rol del usuario no puede quedar vacio.'],
            ['role', 'in', 'range' => ['listener', 'artist']],

            ['username', 'trim'],
            ['username', 'required', 'message' => 'El correo no puede quedar vacío.'],
            ['username', 'email', 'message' => 'El correo tiene un formato incorrecto.'],
            ['username', 'string', 'max' => 255, 'tooLong' => 'El correo no puede superar los 255 caracteres.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'El correo ingresado ya existe.'],

            ['password', 'required', 'message' => 'La contraseña no puede quedar vacía'],
            ['password', 'string', 'min' => 6, 'message' => 'La contraseña debe tener al menos 6 caracteres.'],

            [['id', 'network'], 'required'],
        ];
    }

    public function internalSignup($status, $sendMail = true){

      $user = new User();
      $user->username = $this->username;
      $user->setPassword($this->password);
      $user->created_at = time();
      $user->updated_at = $user->created_at;
      $user->status = $status;

      $opts = new ProfileOpts();
      $opts->save();
      $profile = new Profile();
      $profile->name = $this->name;
      $profile->last_name = $this->lastname;
      $profile->mail = $this->username;


      $role = Role::findOne([ 'type' => $this->role ]);
      $classnameModel = Mapper::mapModel($role->type);

      $model = new $classnameModel();

      $model->name = $profile->name . " " .   $profile->last_name ;

      $access = new Access();
      $access->last_access = "0";
      $access->save();

      $favorites = new Playlist();
      $favorites->name = Playlist::FAVORITES;
      $favorites->visibility_id = 1; //privada

      $transaction = Listener::getDb()->beginTransaction();
      try{
        $user->access_id = $access->id;
        $user->link('role', $role);

        $profile->options_id = $opts->id;
        $profile->save();

        $favorites->link('profile', $profile);

        $model->profile_id = $profile->id;
        $model->link('user', $user);

        $transaction->commit();
        if ($sendMail)
          $this->sendVerificationMail($user, $profile, $this->password);

        return Response::getInstance($user, Flags::ALL_OK);

      } catch(\Exception $e){
        $transaction->rollBack();
        return Response::getInstance([ 'error' => $e->getMessage()], Flags::AUTH_SIGNUP_ERROR);
      } catch (\Throwable $e){
        $transaction->rollBack();
        return Response::getInstance([ 'error' => $e->getMessage()], Flags::AUTH_SIGNUP_ERROR);
      }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup(){
      $this->id = 1;
      $this->network = 'radioalbum';

      if ( !$this->validate() )
          return ['error' => json_encode($this->errors)];

        return $this->internalSignup(User::STATUS_INACTIVE);
    }

    public function oAuthSignup(){
      return $this->internalSignup(User::STATUS_ACTIVE, false);
    }

    private function sendVerificationMail($user, $profile, $password){
      $token = $user->created_at . $user->username;
      $hash = Yii::$app->security->generatePasswordHash($token);
      $url = Url::to(['site/activate', 'id'=> $user->id, 'token' => $hash], true);
      $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
      $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $cabeceras .= 'From: Radioalbum <info@radioalbum.com.ar>' . "\r\n";

      $body = '<p>Bienvenido a RadioAlbum!! Tu proceso de registro ya está casi
                     completo. Solo resta que actives tu cuenta haciendo click en el
                     siguiente enlace: </p>'. $url;
      $body .= '<p> <span style="font-weight: bold">Usuario: </span> ' . $user->username . '</p>';
      $body .= '<p> <span style="font-weight: bold">Contraseña: </span> ' . $password . '</p>';

      mail($profile->mail, 'Activación de cuenta RadioAlbum', $body, $cabeceras);
    }
}
