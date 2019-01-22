<?php
namespace admin\services\crud;

use common\models\User;
use common\models\Role;
use common\models\Access;
use frontend\modules\artist\models\Artist;
use frontend\modules\listener\models\Listener;
use common\util\ArrayProcessor;
use frontend\models\History;

class UserCrudService extends CrudService{

  protected function beforeAdd($obj = null){
    $role = Role::findOne($obj['role']);

    $user = new User();
    $user->username = $obj['username'];
    $user->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($obj['password']);
    $user->status = User::STATUS_ACTIVE;
    $user->created_at = (string)time();
    $user->updated_at = $user->created_at;
    $user->role_id = $role->id;
    $user->access_id = NULL;
    return $user;
  }

  protected function afterAdd($model, $obj, $errors){
    $access = new Access();
    $access->last_access = "0";
    try {
      if ($access->save())
        $model->link('access', $access);
      else
        $errors = ArrayProcessor::toString($access->errors);
    } catch (\yii\base\InvalidCallException $e) {
      throw new \Exception($e->getMessage(), 1);

    }
    return $errors;
  }

  protected function beforeRemove($obj = null){
    $user = User::findOne($obj);
    $access = Access::findOne($user->access->id);
      try {
        $model = $user->getAssociatedModel();
        //Si tiene un modelo asociado(Oyente o Artista)
        if ($model){
          $profile = $model->profile;

          foreach($profile->playlists as $playlist)
            $playlist->unlinkAll('songs', true);
          $profile->unlinkAll('playlists', true);


          History::deleteAll(['profile_id' => $profile->id]);
          $model->delete();
          $profile->unlink('options', $profile->options, true);
        }
        $user->unlink('access', $access);
        $access->delete();
      } catch (yii\base\InvalidCallException $e) {
        throw new \Exception( $e->getMessage(), 1);
      }
    return $user;
  }

  protected function afterRemove($obj = null){

  }

  protected function beforeUpdate($obj = null){
    $user = User::findOne($obj['id']);
    $user->username = $obj['username'];
    $user->status = $obj['status'];

    if (!empty($obj['password']))
      $user->setPassword($obj['password']);

    if ($user->role->id == Role::ADMIN && $obj['role_id'] == Role::REGULATOR)
      $user->role_id = $obj['role_id'];

    if ($user->role->id == Role::REGULATOR && $obj['role_id'] == Role::ADMIN)
      $user->role_id = $obj['role_id'];

    if ($user->role->id == Role::LISTENER && $obj['role_id'] == Role::ARTIST){
      $model = $user->getAssociatedModel();
      $newModel = $this->populate(new Artist, $model);
      if (!$newModel->save())
        throw new \Exception("Error al crear registro en tabla Artist: ". ArrayProcessor::toString($newModel->errors), 1);

      $model->delete();
      $user->role_id = $obj['role_id'];
    }

    if ($user->role->id == Role::ARTIST && $obj['role_id'] == Role::LISTENER){
      $model = $user->getAssociatedModel();
      $newModel = $this->populate(new Listener(), $model);
      if (!$newModel->save())
        throw new \Exception("Error al crear registro en tabla Listener: ". ArrayProcessor::toString($newModel->errors), 1);

      $model->unlinkAll('albums', true);
      $model->delete();
      $user->role_id = $obj['role_id'];
    }
    return $user;
  }

  protected function afterUpdate($params = null){

  }

  private function populate($newModel, $model){
    $newModel->id = 0;
    $newModel->name = $model->name;
    $newModel->presentation = $model->presentation;
    $newModel->profile_id = $model->profile_id;
    $newModel->user_id = $model->user_id;
    return $newModel;
  }
}
