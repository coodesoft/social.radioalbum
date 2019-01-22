<?php
namespace searcher\services;

use Yii;
use yii\helpers\Url;

use common\models\User;
use common\util\ArrayProcessor;

use user\models\Post;
use user\models\Comment;
use user\models\Relationship;

use user\services\SocialService;

class PostFilter extends AbstractFilter{

  public function createQuery($toSearch = null){
    $me = User::getModelExtended(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;

    if (isset($toSearch['who']) && $toSearch['who'] === SocialService::LOGGED_USER)
      $this->query = Post::findMyPosts($me->id);
    elseif (isset($toSearch['who'])) {
      $this->query = Post::findMyPosts($toSearch['who']);
//      $this->query = Post::findExtended([$toSearch['who']], $me->id);
    } else{
        $followedArr = [];
        $relationships = Relationship::findFollowedUsersRelationship($me->id)->all();
        foreach ($relationships as $key => $relationship) {
            $followedArr [] = ($me->id == $relationship->profile_one_id) ? $relationship->profile_two_id : $relationship->profile_one_id;
        }
        $this->query = Post::findExtended($followedArr, $me->id);
    }
  }

  public function prepareModel($params = null){
    return Comment::fillPosts($params);
  }
}
