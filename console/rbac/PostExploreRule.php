<?php
namespace console\rbac;

use Yii;
use yii\rbac\Rule;
use common\models\User;
use common\models\Role;
use common\models\Visibility;

use user\models\Relationship;
use user\models\Post;
use user\services\SocialService;

/**
 * Checks if authorID matches user passed via params
 */
class PostExploreRule extends Rule
{
    public $name = 'canSeePost';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params) {

      if (Yii::$app->user->isGuest)
        return false;

      if (Yii::$app->user->identity->role->type == Role::ADMIN || Yii::$app->user->identity->role->type == Role::REGULATOR)
        return true;

      $profile = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;

      $postId = $params['post_id'];
      $post = Post::find()->where(['id' => $postId])->one();


      if ($post->profile_id == $profile->id){
        return 1;
      }

      if ($post->visibility_id == Visibility::VPUBLIC){
        return true;
      } elseif ($post->visibility_id == Visibility::VPRIVATE){
        return false;
      } else{
        $relationshipStatus = SocialService::checkForFollower($profile->id, $post->profile_id);
        return ($relationshipStatus['status'] == Relationship::ACCEPTED);
      }
    }
}


?>
