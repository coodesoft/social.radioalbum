<?php
namespace console\rbac;

use yii\rbac\Rule;
use Yii;
use common\models\User;
use common\models\Role;
use common\models\Visibility;

use user\models\Relationship;
use user\services\SocialService;
use frontend\modules\playlist\models\Playlist;
/**
 * Checks if authorID matches user passed via params
 */
class PlaylistOwnerRule extends Rule
{
    public $name = 'isPlaylistOwner';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params){

      if (Yii::$app->user->isGuest)
        return false;

      if (Yii::$app->user->identity->role->type == Role::ADMIN || Yii::$app->user->identity->role->type == Role::REGULATOR)
        return true;

      $profile = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
      $id = $params['playlist_id'];
      $playlist = Playlist::find()->where(['id' => $id])->one();

      return ($playlist->profile_id == $profile->id);

    }
}


?>
