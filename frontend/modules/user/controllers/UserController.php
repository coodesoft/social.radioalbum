<?php
namespace user\controllers;
use Yii;

use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

use common\util\Flags;
use common\util\Response;
use common\util\ArrayProcessor;
use common\util\StrProcessor;
use common\models\User;
use common\models\Visibility;
use common\interfaces\IUser;
use common\widgets\modalBox\ModalBox;
use common\services\DataService;

use frontend\controllers\RaBaseController;
use frontend\models\Profile;
use frontend\models\Gender;
use frontend\modules\playlist\models\Playlist;
use admin\models\UploadAlbumForm;
use frontend\modules\album\models\Album;


use frontend\services\HistoryService;

use frontend\modules\artist\models\Artist;
use frontend\modules\listener\models\Listener;
use user\models\EditProfileForm;
use user\services\SocialService;

use searcher\services\Searcher;
use searcher\services\AlbumFilter;
use searcher\services\PostFilter;

class UserController extends RaBaseController implements IUser{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                  'actions' => ['playlists',
                                'history',
                                'profile',
                                'modal',
                                'edit',
                                'albums',
                                'create-playlist',
                                'import-playlist',
                                'edit-personal',
                                'edit-social',
                                'edit-artist',
                                'edit-visibility'],
                  'allow' => true,
                  'roles' => ['@'],
                ],
          ],
      ],
    ];
  }


  public function actionHistory(){
    $user = User::findOne(Yii::$app->user->id);
    $profile = $user->getAssociatedModel()->profile;

    $segment = Yii::$app->request->get('segment');
    $service = new HistoryService();
    $service->setQuery($profile->id);

    if (!$segment){
      $rows = $service->getData();
      $visible = ($service->isLastPage()) ? false : true;

      $lazyRoute = Url::to(['/user/history', 'segment' => 1]);
      return $this->renderSection('history', ['songs' => $rows,
                                               'profile_id'=> $profile->id,
                                               'lazyLoad' => [
                                                 'route' => $lazyRoute,
                                                 'visible' => $visible,
                                               ]
                                             ]);
    } else {
      $rows = $service->getData($segment);
      $segment = $segment + 1;

      $infinite['status'] =  $service->isLastPage();
      $infinite['route'] = Url::to(['/user/history', 'segment' => $segment]);
      $infinite['content']= $this->renderSection('history-lazy', ['songs' => $rows, 'profile_id'=> $profile->id]);


      return Response::getInstance($infinite, Flags::ALL_OK)->jsonEncode();
    }

  }


  public function actionPlaylists(){
    $user = User::findOne(Yii::$app->user->id);
    $profile = $user->getAssociatedModel()->profile;
    $playlists='';
      if ($profile)
        $playlists = $profile->playlists;

      return $this->renderSection('playlists', ['playlists' => $playlists, 'profile' => $profile->id]);
  }

  public function actionCreatePlaylist(){
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type);
    $id = Yii::$app->request->get('id');

    if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $album = Album::findOne($id);
    $playlist = new Playlist();
    $playlist->name = (string) 'Album - ' . $album->name;
    $playlist->profile_id = $me->profile->id;
    $playlist->visibility_id = Visibility::VPRIVATE;

    if (!$playlist->save())
      return ModalBox::widget([ 'title' => Yii::t('app', 'errorGenerico1'),
                                'content' => Yii::t('app', 'errorCreatePlaylist'),
                                'type' => 'danger']);


    foreach ($album->songs as $song)
      $playlist->link('songs', $song);

    return ModalBox::widget([ 'title' => Yii::t('app', 'success'),
                              'content' => Yii::t('app', 'youAddNewPlaylist, {name}', ['name' => $playlist->name]),
                              'type' => 'success']);

  }

  public function actionImportPlaylist(){
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type);
    $id = Yii::$app->request->get('id');

    if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    $storedPlaylist = Playlist::findOne($id);
    $playlist = new Playlist();
    $playlist->name = $storedPlaylist->name;
    $playlist->profile_id = $me->profile->id;
    $playlist->visibility_id = Visibility::VPRIVATE;

    if (!$playlist->save())
      return ModalBox::widget([ 'title' => Yii::t('app', 'errorGenerico1'),
                                'content' => Yii::t('app', 'errorCreatePlaylist'),
                                'type' => 'danger']);


    foreach ($storedPlaylist->songs as $song)
      $playlist->link('songs', $song);

    return ModalBox::widget([ 'title' => Yii::t('app', 'success'),
                              'content' => Yii::t('app', 'youAddNewPlaylist, {name}', ['name' => $playlist->name]),
                              'type' => 'success']);
  }

  public function actionModal(){
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type);
    $action = Yii::$app->request->get('action');
    $id = Yii::$app->request->get('id');
    $modal ="";

    if ( !(Yii::$app->request->isAjax && isset($id) && is_numeric($id) && isset($action) && is_string($id)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    switch ($action) {
      case 'add-song-to-playlist':
          return $this->renderAjax('add-to-playlist', ['id'=> $id, 'profile' => $me->profile, 'type' => 'song']);
        break;
      default:
        break;
    }
    return $modal;
  }

  public function actionProfile(){

    $actions['adicional'][] = ['icon' => 'plus', 'url' => Url::to(), 'type' => 'modal', 'tooltip' => \Yii::t('app', 'addToPlaylist')];
    $actions['adicional'][] = ['icon' => 'star', 'url' => Url::to(), 'type' => 'modal', 'tooltip' => \Yii::t('app', 'addToFavs')];
    $actions['adicional'][] = ['icon' => 'share', 'url' => Url::to(), 'type' => 'nav', 'tooltip' => \Yii::t('app', 'share')];;
    $actions['main']        = ['icon' => 'play', 'url' => Url::to(), 'type' => 'playback-collection', 'tooltip' => \Yii::t('app', 'playback')];
    $actions['pop'][]      =  ['text' => Yii::t('app', 'report')];

    $model = User::getModelExtended(Yii::$app->user->id, Yii::$app->user->identity->role->type);
    $filter = new PostFilter();
    $filter->createQuery(['who' => 'me']);

    $service = new Searcher();
    $posts = $service->search($filter);
    $posts = $filter->prepareModel($posts);

    $followers = SocialService::getFollowers($model->profile->id);
    $followedUsers = SocialService::getFollowedUsers($model->profile->id);

    $relationships = [];

    $idArr = [];
    foreach ($followers as $key => $profile){
      $relationships['followers'][] = ArrayProcessor::profileToArrayRepresentation($profile);
    }

    foreach ($followedUsers as $key => $profile)
      $relationships['followedUsers'][] = ArrayProcessor::profileToArrayRepresentation($profile);


    return $this->renderSection('profile', ['model' => $model,
                                            'actions' => $actions,
                                            'posts' => $posts,
                                            'relationships' => $relationships,
                                            'postsRemain' => !$service->stopSearch(),
                                            'profile_action' => [
                                              'icon' => 'edit',
                                              'title' => Yii::t('app', 'edit'),
                                              'type' => 'nav',
                                              'url' => Url::to(['/user/user/edit'])
                                            ]
                                          ]);

  }


  public function actionAlbums(){
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type);
    $entity = Yii::$app->request->get('entity');
    $segment = Yii::$app->request->get('segment');

    $service = new Searcher();
    $filter = new AlbumFilter();

    $query = $me->getAlbums();
    $filter->setQuery($query);

    $params['entity'] = $entity;
    $params['segment'] = $segment;

    return $this->listElements($filter, '/user/user/albums', $params, 'albums');

  }

  public function actionConfiguration(){}

  public function actionEdit(){

    if (Yii::$app->request->isGet){

        $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type);
        $profile = $me->profile;
        $model = new EditProfileForm();

        $model->birth_day   = isset($profile->birth_date) ? StrProcessor::formatDate('j', $profile->birth_date) : 1;
        $model->birth_month = isset($profile->birth_date) ? StrProcessor::formatDate('n', $profile->birth_date) : 1;
        $model->birth_year  = isset($profile->birth_date) ? StrProcessor::formatDate('Y', $profile->birth_date) : 1920;


        $model->begin_day   = isset($me->begin_date) ? StrProcessor::formatDate('j', $me->begin_date) : 1;
        $model->begin_month = isset($me->begin_date) ? StrProcessor::formatDate('n', $me->begin_date) : 1;
        $model->begin_year  = isset($me->begin_date) ? StrProcessor::formatDate('Y', $me->begin_date) : 1920;

        $editPersonal = $this->renderPartial('edit-profile/edit-personal.php', ['profile' => $profile, 'model' => $model]);
        $editArtist = $this->renderPartial('edit-profile/edit-artist.php', ['profile' => $profile, 'model' => $model]);
        $editSocial = $this->renderPartial('edit-profile/edit-social.php', ['user' => $me, 'user' => $me]);
        $visibilitySocial = $this->renderPartial('edit-profile/edit-visibility.php', ['model' => $profile->options, 'isArtist' => ($me->className() == Artist::className())]);

        $items['items'][] = ['label'=> \Yii::t('app', 'personal'), 'content' => $editPersonal, 'active' => true];
        if ($me->className() == Artist::className())
          $items['items'][] =['label'=> \Yii::t('app', 'artistic'), 'content' => $editArtist];

        $items['items'][] =['label'=> \Yii::t('app', 'social'), 'content' => $editSocial];
        $items['items'][] =['label'=> \Yii::t('app', 'advancedVisibility'), 'content' => $visibilitySocial];
        return $this->renderSection('edit', ['items' => $items]);
    }
  }

  public function actionEditPersonal(){
    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    if (Yii::$app->request->isPost){
      $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type);
      $profile = $me->profile;
      $model = new EditProfileForm();

      $profileForm = Yii::$app->request->post('Profile');
      $modelForm = Yii::$app->request->post('EditProfileForm');

      if (isset($profileForm) && isset($modelForm)){

        $profile->name = $profileForm['name'];
        $profile->last_name = $profileForm['last_name'];
        $profile->birth_location = $profileForm['birth_location'];
        $profile->phone = $profileForm['phone'];
        $profile->birth_date = (string)strtotime($modelForm['birth_day']."-".$modelForm['birth_month']."-".$modelForm['birth_year']);
        $profile->gender_id = $profileForm['gender_id'];
        $profile->gender_desc = ($profileForm['gender_id'] == Gender::CUSTOM) ? $profileForm['gender_desc'] : null;

        $model->photo = UploadedFile::getInstance($model, 'photo');
        if (!$model->upload($profile->photo))
          return Response::getInstance(false, Flags::UPLOAD_ERROR)->jsonEncode();

        $profile->photo = ($model->photo_uri) ? $model->photo_uri : $profile->photo;
        if (!$profile->save())
          return Response::getInstance(ArrayProcessor::toString($profile->errors), FLags::UPDATE_ERROR)->jsonEncode();


        return Response::getInstance(true, Flags::UPDATE_SUCCESS)->jsonEncode();
      } else
        return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    }
  }

  public function actionEditSocial(){
    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    if (Yii::$app->request->isPost){
      $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type);
      $profile = $me->profile;

      $param = (StrProcessor::functionalClassName($me->className()) == 'listener') ? 'Listener' : 'Artist';
      $modelForm = Yii::$app->request->post($param);
      $profileForm = Yii::$app->request->post('Profile');
      if (isset($profileForm) && isset($modelForm)){
        $profile->facebook = $profileForm['facebook'];
        $profile->twitter = $profileForm['twitter'];
        $profile->visibility = $profileForm['visibility'];

        $me->presentation = $modelForm['presentation'];
        $me->name = $modelForm['name'];
        if ($profile->save() && $me->save())
          return Response::getInstance(true, Flags::UPDATE_SUCCESS)->jsonEncode();

        return Response::getInstance(ArrayProcessor::toString([$profile->errors, $me->errors]), Flags::UPDATE_ERROR)->jsonEncode();
      }
    }
    return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);
  }

  public function actionEditVisibility(){
    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    if (Yii::$app->request->isPost){
      $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type);
      $options = $me->profile->options;

      $visForm = Yii::$app->request->post('ProfileOpts');
      if (isset($visForm)){
        $options->begin_date = isset($visForm['begin_date']) ? $visForm['begin_date'] : $options->begin_date;
        $options->instrument = isset($visForm['instrument']) ? $visForm['instrument'] : $options->instrument;
        $options->presentation = $visForm['presentation'];
        $options->full_name = $visForm['full_name'];
        $options->birth_date = $visForm['birth_date'];
        $options->birth_location = $visForm['birth_location'];
        $options->phone = $visForm['phone'];
        $options->social = $visForm['social'];
        $options->gender = $visForm['gender'];

        if ($options->save())
          return Response::getInstance(true, Flags::UPDATE_SUCCESS)->jsonEncode();

        return Response::getInstance(false, Flags::UPDATE_ERROR)->jsonEncode();
      }
    }
    return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

  }

  public function actionEditArtist(){
    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    if (Yii::$app->request->isPost){
      $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type);
      $profile = $me->profile;

      $modelForm = Yii::$app->request->post('EditProfileForm');

      if ($modelForm){
        $me->begin_date = (string)strtotime($modelForm['begin_day']."-".$modelForm['begin_month']."-".$modelForm['begin_year']);

        if ($me->save())
          return Response::getInstance(true, Flags::UPDATE_SUCCESS)->jsonEncode();

        return Response::getInstance(ArrayProcessor::toStrin($me->errors), Flags::UPDATE_ERROR)->jsonEncode();
      }

    }
    return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

  }

}
?>
