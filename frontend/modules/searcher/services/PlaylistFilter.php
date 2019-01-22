<?php
namespace searcher\services;

use Yii;
use yii\helpers\Url;
use common\models\User;
use common\util\ArrayProcessor;
use frontend\modules\playlist\models\Playlist;
use user\models\Relationship;

class PlaylistFilter extends AbstractFilter{

  public function createQuery($toSearch = null){
    $me = User::getModelExtended(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;

    $followedArr = [];
    $relationships = Relationship::findFollowedUsersRelationship($me->id)->all();
    foreach ($relationships as $key => $relationship) {
        $followedArr [] = ($me->id == $relationship->profile_one_id) ? $relationship->profile_two_id : $relationship->profile_one_id;
    }

    if ($toSearch){
      $this->query = Playlist::findExtended($followedArr, $me->id,$toSearch);
    } else
      $this->query = Playlist::findExtended($followedArr, $me->id);
  }

  public function prepareModel($params = null){
    return $params;
  }
}
