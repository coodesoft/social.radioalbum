<?php
namespace console\rbac;

use Yii;
use yii\rbac\Rule;

use common\models\User;
use common\models\Role;
use common\models\Visibility;

use user\models\Relationship;
use user\services\SocialService;
use frontend\modules\playlist\models\Playlist;
/**
 * Checks if authorID matches user passed via params
 */
class PlaylistReadRule extends Rule
{
    public $name = 'canReadPlaylist';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params){
      $id = $params['playlist_id'];
      $playlist = Playlist::find()->where(['id' => $id])->one();

      if (Yii::$app->user->isGuest){
        return ($playlist->visibility_id == Visibility::VPUBLIC);
      }



      if (Yii::$app->user->identity->role->type == Role::ADMIN || Yii::$app->user->identity->role->type == Role::REGULATOR)
        return true;

      $profile = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;

      if ($playlist->profile_id == $profile->id){
        return 1;
      }

      if ($playlist->visibility_id == Visibility::VPUBLIC){
        return true;
      } elseif ($playlist->visibility_id == Visibility::VPRIVATE){
        return false;
      } else{
        $relationshipStatus = SocialService::checkForFollower($profile->id, $playlist->profile_id);
        return ($relationshipStatus['status'] == Relationship::ACCEPTED);
      }
    }
}


?>
