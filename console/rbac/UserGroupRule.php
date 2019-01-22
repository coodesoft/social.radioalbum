<?php
namespace console\rbac;

use Yii;
use yii\rbac\Rule;

class UserGroupRule extends Rule
{
    public $name = 'userGroup';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->role->id;
            if ($item->name === 'admin') {
                return $role == 1;
            } elseif ($item->name === 'regulator') {
                return $role == 1 || $role == 2;
            } elseif ($item->name === 'artist'){
                return $role == 4;
            } elseif ($item->name === 'listener'){
                return $role == 3 || $role == 4;
            }
        }
        return false;
    }
}

?>
