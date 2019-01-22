<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $type
 *
 * @property User[] $users
 */
class Role extends \yii\db\ActiveRecord{

    const ADMIN = 1;
    const REGULATOR = 2;
    const LISTENER = 3;
    const ARTIST = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => \Yii::t('app', 'type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['role_id' => 'id']);
    }

    public static function roleIdsArray(){
      $roles = Role::find()->all();
      $array = [];
      foreach ($roles as $value)
        $array[] = $value->id;

      return $array;
    }

    public static function rolesArray(){
      $roles = Role::find()->all();
      $array = [];
      foreach ($roles as $value)
        $array[$value->id] = $value->type;

      return $array;
    }

}
