<?php
namespace admin\models;

use common\models\User;
use common\models\Access;
use common\models\Role;
use yii\base\Model;

class UserSearch extends Model{


  public $username;

  public $role;

  public $status;

  public $lastAccess;

  private $_user;


  public function rules(){
      return [
          [['username', 'lastAccess'], 'string'],

          ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_DELETED, User::STATUS_INACTIVE]],
          [['role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role' => 'id']],

      ];
  }


  public function attributeLabels(){
     return [
         'username' => \Yii::t('app', 'user'),
         'status' => \Yii::t('app', 'status'),
         'lastAccess' =>  \Yii::t('app', 'lastAccess'),
         'role' => \Yii::t('app', 'role'),
     ];
  }
/*
  public function load(){
    if (isset($_POST['UserSearch'])) {
      $model->attributes = $_POST['UserSearch'];
      return true;
    }
    return false;
  }
*/
  public function find(){
    $user = User::find()->with(['role', 'access']);

    if (isset($this->role) && $this->role != '')
        $user = $user->where(['role_id' => (int) $this->role]);

    if (isset($this->status) && $this->status != '')
      $user = $user->andWhere(['status' => (int) $this->status]);

    if (isset($this->lastAccess) && $this->lastAccess != ''){
      $d = \DateTime::createFromFormat('d-m-Y', $this->lastAccess, new \DateTimeZone('America/Argentina/Buenos_Aires'));
      $this->lastAccess =  $d->getTimestamp();

      $user = $user->innerJoinWith([
        'access' => function ($query) {
          $query->onCondition(['>', 'access.last_access', $this->lastAccess]);

        },
      ]);
    }

    if (isset($this->username) && $this->username != '')
      $user = $user->andWhere(['like', 'username', $this->username]);

    return $user;
  }

}
