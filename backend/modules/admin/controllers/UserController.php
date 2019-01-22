<?php
namespace admin\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

use backend\controllers\RaBaseController;
use admin\models\CreateUserForm;
use admin\models\UserSearch;
use backend\modules\artist\models\Artist;
use common\models\User;
use common\models\Role;
use common\util\ArrayProcessor;
use common\util\Response;
use common\util\Flags;
use common\services\DataService;

class UserController extends RaBaseController{

  const SHOW_FORM = 0;
  const SHOW_RESPONSE = 1;


  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['users', 'read', 'edit', 'remove', 'create', 'modal',
                                  'link-profile', 'search-profile', 'reset-password',
                                  'user-search', 'instant-user-search'],
                    'allow' => true,
                    'roles' => ['admin', 'regulator'],
                ],
          ],
      ],
    ];
  }

  protected function searchUsers($limit = null){
    $search = new UserSearch();
    $service = new DataService();

    $search->load(Yii::$app->request->get());
    if ($limit)
      $query = $search->find()->limit($limit);
    else
      $query = $search->find();

    $service->setQuery($query);
    $segment = Yii::$app->request->get('segment');
    if ($segment){
      return $this->getDataSegment('/admin/user/user-search', 'list-lazy', $service, $segment);
    } else{
      $rows = $service->getData();
      $visible = ($service->isLastPage()) ? false : true;
      $params = Yii::$app->request->getQueryParams();
      $params['segment'] = 1;
      $lazyRoute = Url::to(array_merge(['/admin/user/user-search'], $params));
      return $this->renderPartial('user-search-result', ['users' => $rows, 'lazyLoad' => ['route' => $lazyRoute, 'visible' => $visible]]);
    }
  }

  protected function getDataSegment($route, $view, $service, $segment){
    $rows = $service->getData($segment);
    $segment = $segment + 1;
    $params = Yii::$app->request->getQueryParams();
    $params['segment'] = $segment;
    $infinite['route'] = Url::to(array_merge([$route], $params));

    $infinite['status'] =  $service->isLastPage();
    $infinite['content'] = $this->renderPartial($view, ['elements'=> $rows]);
    return Response::getInstance($infinite, Flags::ALL_OK)->jsonEncode();
  }

  public function actionUsers(){
    $service = new DataService();
    $search = new UserSearch();

    $query = User::find();
    $query = $search->find();
    $service->setQuery($query);
    $segment = Yii::$app->request->get('segment');
    if ($segment){
      return $this->getDataSegment('/admin/user/users', 'list-lazy', $service, $segment);
    } else{
      $rows = $service->getData();
      $visible = ($service->isLastPage()) ? false : true;
      $lazyRoute = Url::to(['/admin/user/users', 'segment' => 1]);
      $body = $this->renderPartial('users-list', ['users' => $rows, 'lazyLoad' => ['route' => $lazyRoute, 'visible' => $visible]]);
      return $this->renderSection('users', ['body' => $body, 'title' => \Yii::t('app', 'areaAdminUsers')]);
    }
  }


  public function actionUserSearch(){
    return $this->searchUsers();
  }

  public function actionInstantUserSearch(){
    return $this->searchUsers(100);
  }

  public function actionRead(){
    $id = Yii::$app->request->get('id');
    $model = User::findOne($id);
    $body = $this->renderPartial('read', ['model' => $model]);
    return $this->renderSection('users', ['body' => $body, 'title' => \Yii::t('app', 'viewDetail')]);
  }

  public function actionEdit(){
    $request = Yii::$app->request;
    if (!$request->isPost){
      $id = $request->get('id');
      $model = User::findOne($id);
      $body = $this->renderPartial('update', ['model' => $model]);
      return $this->renderSection('users', ['body' => $body, 'title' => \Yii::t('app', 'editUser')]);
    } elseif ($request->isPost) {
      $form = $request->post('User');
      $service = $this->module->get('userCrud');
      $errors = $service->update($form['id'], $form);

      if (strlen($errors) == 0){
        $message = ['text' => Yii::t('app', 'userUpdateSuccess'), 'type' => 'success'];
        $flag = Flags::UPDATE_SUCCESS;
      } else{
        $message = ['text' => Yii::t('app', 'userUpdateError')." ".$errors, 'type' => 'danger'];
        $flag = Flags::UPDATE_ERROR;
      }
      return Response::getInstance($message, $flag)->jsonEncode();
    }
  }

  public function actionRemove(){
    if (Yii::$app->request->isPost){
      $userPost = Yii::$app->request->post('User');
      $id = $userPost['id'];
      if (isset($id)){
        if ($id != User::DEFAULT_ADMIN){
          $service = $this->module->get('userCrud');
          $errors = $service->remove($id);
          if (strlen($errors) == 0){
            $message = ['text' => Yii::t('app', 'userRemoveSuccess'), 'type' => 'success'];
            $flag = Flags::DELETE_SUCCESS;
          } else{
            $message = ['text' => Yii::t('app', 'userRemoveError')." ".$errors, 'type' => 'danger'];
            $flag = Flags::DELETE_ERROR;
          }
        } else{
          $message = ['text' => Yii::t('app', 'adminNoRemove'), 'type' => 'danger'];
          $flag = Flags::DELETE_ERROR;
        }
      } else{
        $message = ['text' => Yii::t('app', 'noIdGiven'), 'type' => 'danger'];
        $flag = Flags::DELETE_ERROR;
      }

      return Response::getInstance($message, $flag)->jsonEncode();
    }
  }

  public function actionCreate(){
    if (Yii::$app->request->isPost){
      $user = array();
      $userForm = Yii::$app->request->post('User');
      $service = $this->module->get('userCrud');

      $stored = User::findOne(['username' => $userForm['username']]);
      if (!$stored){
        $error = $service->add($userForm);
        if (strlen($error) == 0){
          $message = ['text' => Yii::t('app', 'userCreateSuccess'), 'type' => 'success'];
          $flag = Flags::SAVE_SUCCESS;
        } else{
          $message = ['text' => Yii::t('app', 'userCreateError')." ".$error, 'type' => 'danger'];
          $flag = Flags::SAVE_ERROR;
        }
      } else{
        $message = ['text' => Yii::t('app', 'userExistError'), 'type' => 'danger'];
        $flag = Flags::ALREADY_EXIST;
      }
      return Response::getInstance($message, $flag)->jsonEncode();
    } else{
      $roles = Role::find()->all();
      $body = $this->renderAjax('addUser', ['roles' => $roles]);
      return $this->renderSection('users', ['body' => $body, 'title' => \Yii::t('app', 'addUser')]);
    }
  }

  public function actionLinkProfile(){
    if (!Yii::$app->request->isPost){
      $id = Yii::$app->request->get('id');
      $user = User::findOne($id);
      $body = $this->renderAjax('link', ['user' => $user]);
      return $this->renderSection('users', ['body' => $body, 'title' => \Yii::t('app', 'asocciateWithProfile')]);
    }else {
      $link =  Yii::$app->request->post('Link');
      $user = User::findOne($link['user_id']);
      $model = Artist::findOne($link['model_id']);
      try {
        $oldModel = $user->getAssociatedModel();
        if (isset($oldModel))
          $oldModel->unlink('user', $user);
        $model->link('user', $user);
        $message = ['text' => Yii::t('app', 'profileLinkSuccess'), 'type' => 'success'];
        return Response::getInstance($message, Flags::ALL_OK)->jsonEncode();
      } catch (\yii\base\InvalidCallException	 $e) {
        $message = ['text' => $e->getMessage(), 'type' => 'danger'];
        return Response::getInstance($e->getMessage(), Flags::LINK_ERROR)->jsonEncode();
      }

    }
  }

  public function actionSearchProfile(){
    $query = Yii::$app->request->post('Query');
    $searchObj = HtmlPurifier::process($query['subject']);
    $artists = Artist::find()
                     ->where(['like', 'name', $searchObj])
                     ->andWhere(['user_id'=> null])
                     ->all();

    return $this->renderPartial('profile-search-results', ['artists' => $artists]);
  }

  public function actionModal(){
    $id = Yii::$app->request->get('id');
    $action = Yii::$app->request->get('action');
    $user = User::findOne($id);
    $content;
    $title;
    $modal;
    switch ($action) {
      case 'remove':
        if ($user->id != User::DEFAULT_ADMIN)
          $content = $this->renderPartial('delete', ['user' => $user]);
        else
          $content = Yii::t('app', 'adminNoRemove');
          $title = Yii::t('app', 'removeUser');
        break;
      default:
        $content = Yii::t('app', 'notFunctionDef');
        $title = Yii::t('app', 'ops');
        break;
    }
    return $this->renderSection('modal', ['title' => $title, 'content' =>$content]);
  }

}
