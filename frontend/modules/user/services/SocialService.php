<?php
namespace user\services;

use Yii;
use yii\helpers\Html;
use yii\db\Query;


use common\models\User;
use common\util\StrProcessor;

use frontend\models\Profile;

use user\models\Relationship;
use user\models\Notification;

class SocialService {

  const LOGGED_USER = 'me';

  public static function checkForFollower($follower, $followed){
    $relationship = Relationship::checkForSingleFollow($follower, $followed);

    if ($relationship){
      $status = ($relationship->one_follow_two_status != null) ? $relationship->one_follow_two_status : $relationship->two_follow_one_status;

      return SocialService::setFollowResponse($status, $follower, $followed);
    }

    return null;
  }

  public static function setFollowResponse($status, $follower, $followed){
    $response = [];
    $response['status'] = $status;
    $response['follower'] = $follower;
    $response['followed'] = $followed;
    return $response;
  }


  public function getFollowedUsers($myId){

    $relationshipOne = ['and', ['and', 'relationship.profile_one_id=p.id', 'relationship.profile_two_id='.$myId], 'relationship.two_follow_one_status='.Relationship::ACCEPTED];
    $relationshipTwo = ['and', ['and', 'relationship.profile_two_id=p.id', 'relationship.profile_one_id='.$myId], 'relationship.one_follow_two_status='.Relationship::ACCEPTED];

    $contacts = (new Query())
                ->select('p.id, p.name, p.last_name, p.photo, artist.name as artist_name, artist.id as artist_id, listener.id as listener_id, listener.name as listener_name')
                ->from('profile p')
                ->join('LEFT JOIN', 'artist', 'p.id = artist.profile_id')
                ->join('LEFT JOIN', 'listener', 'p.id = listener.profile_id')
                ->join('INNER JOIN', 'relationship', ['or', $relationshipOne, $relationshipTwo])
                ->all();

   return $contacts;
  }

  public function getFollowers($myId){
    $relationshipOne = ['and', ['and', 'relationship.profile_two_id=p.id', 'relationship.profile_one_id='.$myId], 'relationship.two_follow_one_status='.Relationship::ACCEPTED];
    $relationshipTwo = ['and', ['and', 'relationship.profile_one_id=p.id', 'relationship.profile_two_id='.$myId], 'relationship.one_follow_two_status='.Relationship::ACCEPTED];

    $contacts = (new Query())
    ->select('p.id, p.name, p.last_name, p.photo, artist.name as artist_name, artist.id as artist_id, listener.id as listener_id, listener.name as listener_name')
                ->from('profile p')
                ->join('LEFT JOIN', 'artist', 'p.id = artist.profile_id')
                ->join('LEFT JOIN', 'listener', 'p.id = listener.profile_id')
                ->join('INNER JOIN', 'relationship', ['or', $relationshipOne, $relationshipTwo])
                ->all();
    return $contacts;

  }


}
