<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

use common\util\mapper\Mapper;

use backend\modules\artist\models\Artist;
use backend\modules\listener\models\Listener;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_access
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 5;
    const STATUS_ACTIVE = 10;
    const DEFAULT_ADMIN = 1;

    public $verification_code;

    /**
     * @inheritdoc
     */
    public static function tableName(){
        return '{{%user}}';
    }

    public static function statusLabelArray(){
      return [
        '0' => \Yii::t('app', 'eliminado'),
        '5' => \Yii::t('app', 'inactive'),
        '10' => \Yii::t('app', 'active'),
      ];
    }

    public static function statusArray(){
      return [User::STATUS_DELETED, User::STATUS_INACTIVE, User::STATUS_ACTIVE];
    }

    /**
     * @inheritdoc
     */
    public function behaviors(){
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_INACTIVE]],
            [['role_id'], 'required'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'El nombre de usuario ingresado ya existe.'],
            [['username', 'password_reset_token', 'auth_key', 'created_at', 'updated_at'], 'string', 'max' => 45],
            ['password_hash', 'string', 'max' => 255],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],

        ];
    }


   public function attributeLabels(){
       return [
           'id' => 'ID',
           'username' => \Yii::t('app', 'user'),
           'password_hash' => \Yii::t('app', 'pass'),
           'password_reset_token' => 'Password Reset Token',
           'auth_key' => 'Auth Key',
           'status' => \Yii::t('app', 'status'),
           'created_at' => \Yii::t('app', 'created_at'),
           'updated_at' => \Yii::t('app', 'updated_at'),
           'access_id' =>  \Yii::t('app', 'lastAccess'),
           'role_id' => \Yii::t('app', 'role'),
       ];
   }

   public function beforeSave($insert){
     if (parent::beforeSave($insert)) {
       if ($this->isNewRecord) {
         $this->generateAuthKey();
       }
       return true;
     }
     return false;
   }

   public function getRole(){
       return $this->hasOne(Role::className(), ['id' => 'role_id']);
   }

   public function getArtists() {
      return $this->hasMany(Artist::className(), ['user_id' => 'id'])->inverseOf('user');
   }

   /**
     * @return \yii\db\ActiveQuery
     */
   public function getListeners(){
     return $this->hasMany(Listener::className(), ['user_id' => 'id'])->inverseOf('user');
   }

   public function getAccess(){
       return $this->hasOne(Access::className(), ['id' => 'access_id']);
   }

   /**
     * @inheritdoc
     */
    public static function findIdentity($id){
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null){
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username){
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token){
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token){
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId(){
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey(){
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey){
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password){
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password){
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    public function getPassword(){
        return '';
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey(){
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken(){
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken(){
        $this->password_reset_token = null;
    }

    public function getAssociatedModel(){
      $model = Mapper::mapModel($this->role->type);

      if (!$model)
        return null;

      $instance = $model::find()->where(['user_id' =>$this->id])->with(['profile', 'profile.options'])->one();
      return $instance;
    }

    public function isActive(){
      return ($this->status == User::STATUS_ACTIVE);
    }

    public function setActive($value = true){
      $this->status = ($value) ? User::STATUS_ACTIVE : User::STATUS_INACTIVE;
    }

    public static function getModel($id, $role){
      $model = Mapper::mapModel($role);

      if (!$model)
        return null;

      $instance = $model::find()->where(['user_id' =>$id])->with(['profile', 'profile.options'])->one();
      return $instance;
    }

    public static function getModelExtended($id, $role, $relations = null){
      $model = Mapper::mapModel($role);
      if (!$model)
        return null;

      if ($relations){
        if (!in_array('profile', $relations))
          $relations[] = 'profile';

        if (!in_array('profile.options', $relations))
          $relations[] = 'profile.options';
      } else{
        $relations = ['profile', 'profile.options'];
      }


      $instance = $model::find()->where(['user_id' =>$id])->with($relations)->one();
      return $instance;
    }

    public static function getModelWithRelations($id, $role, $relations){
      $model = Mapper::mapModel($role);

      if (!$model)
          return null;

      $instance = $model::find()->where(['user_id' =>$id])->with($relations)->one();
      return $instance;

    }




}