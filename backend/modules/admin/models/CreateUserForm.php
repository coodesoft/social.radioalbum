<?php
namespace admin\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Role;

class CreateUserForm extends Model{

  public $username;
  public $password;
  public $role;

  /**
   * @inheritdoc
   */
  public function rules(){
    return [
      ['username', 'required', 'message' => 'El usuario no puede quedar vacío'],
      ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'El usuario ingresado ya existe'],
      ['password', 'required', 'message' => 'La contraseña no puede quedar vacía'],
    //  ['password', 'string', 'min' => 6, 'message' => 'La contraseña debe tener al menos 6 caracteres.'],
   //   ['role', 'integer'],
    ];
  }


}
