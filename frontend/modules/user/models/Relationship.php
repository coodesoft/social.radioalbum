<?php

namespace user\models;

use Yii;

use common\models\User;
use frontend\models\Profile;

/**
 * This is the model class for table "relationship".
 *
 * @property integer $profile_one_id
 * @property integer $profile_two_id
 * @property integer $status
 * @property integer $action_profile_id
 *
 */
class Relationship extends \yii\db\ActiveRecord
{

  const PENDING  = 0;
  const ACCEPTED = 1;
  const DECLINED = 2;
  const BLOCKED  = 3;



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relationship';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_one_id', 'profile_two_id'], 'required'],
            [['profile_one_id', 'profile_two_id', 'one_follow_two_status', 'two_follow_one_status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'profile_one_id' => 'Profile One ID',
            'profile_two_id' => 'Profile Two ID',
            'one_follow_two_status' => 'One Follow Two Status',
            'two_follow_one_status' => 'Two Follow One Status',
        ];
    }

    public static function findRelationship($myId, $otherId){

      if ($myId == $otherId)
        return null;

      $profile_one_id = ($otherId > $myId) ? $myId : $otherId;
      $profile_two_id = ($otherId < $myId) ? $myId : $otherId;

      return  Relationship::find()->where(['profile_one_id' => $profile_one_id])
                                      ->andWhere(['profile_two_id' => $profile_two_id])
                                      ->one();
    }

    public static function checkForSingleFollow($follower, $followed){
      if ($follower == $followed)
        return null;

      $profile_one_id = ($followed > $follower) ? $follower : $followed;
      $profile_two_id = ($followed < $follower) ? $follower : $followed;

      $status = ($profile_one_id == $follower) ? 'one_follow_two_status' : 'two_follow_one_status';

      return  Relationship::find()->where(['profile_one_id' => $profile_one_id])
                                  ->andWhere(['profile_two_id' => $profile_two_id])
                                  ->andWhere(['not', [$status => null]])
                                  ->one();
    }

    public static function checkForDoubleFollow($idOne, $idTwo){
      if ($idOne == $idTwo)
        return null;

      $profile_one_id = ($idTwo > $idOne) ? $idOne : $idTwo;
      $profile_two_id = ($idTwo < $idOne) ? $idOne : $idTwo;

      return  Relationship::find()->where(['profile_one_id' => $profile_one_id])
                                  ->andWhere(['profile_two_id' => $profile_two_id])
                                  ->andWhere(['not', ['one_follow_two_status' => null]])
                                  ->andWhere(['not', ['two_follow_one_status' => null]])
                                  ->one();
    }

    public static function findFollowedUsersRelationship($myId){
        $profile_one_condition = ['and', ['profile_one_id' => $myId, 'one_follow_two_status' => Relationship::ACCEPTED]];
        $profile_two_condition = ['and', ['profile_two_id' => $myId, 'two_follow_one_status' => Relationship::ACCEPTED]];
        return Relationship::find()->where(['or', $profile_one_condition, $profile_two_condition]);
    }

    public static function findFollowedUsersId($myId){
      $relationships = Relationship::findFollowedUsersRelationship($myId)->all();
      $idArr = [];
      foreach ($relationships as $key => $relationship)
        if ($relationship->profile_one_id == $myId)
          $idArr[] = $relationship->profile_two_id;
        else
          $idArr[] = $relationship->profile_one_id;

      return $idArr;

    }

}
