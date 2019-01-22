<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

use common\util\mapper\Mapper;
/**
 * User model
 *
 * @property integer $id
 * @property string $last_access

 */
class Access extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName(){
        return '{{%access}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            ['last_access', 'string', 'max' => 45],
        ];
    }


   public function attributeLabels(){
       return [
           'id' => 'ID',
           'last_access' => 'Last Access',
       ];
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getUsers()
   {
       return $this->hasMany(User::className(), ['role_id' => 'id']);
   }

}
