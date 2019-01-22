<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;

use common\models\User;
use common\util\StrProcessor;
use common\util\Response;
use common\util\Flags;
use common\util\ImageProcessor;
use common\util\MobileDetect;
use common\widgets\mobileNav\MobileNav;

use frontend\modules\musicPanel\components\mobilePlaybackVisor\MobilePlaybackVisor;
use searcher\services\Searcher;

use user\services\NotificationService;



class RaBaseController extends Controller{

  public $layout = '@frontend/views/layouts/main_logged';


  protected function getMenuItems(){
    $user = User::findOne(Yii::$app->user->id);
    $endpoint = $user->role->type;
    $menu = array();

    $items = array();

    $model = $user->getAssociatedModel();
    $items[] = ['url'=>Url::to(["/user/user/profile"]), 'context'=>"profile_area", 'name'=> $model->name,  'img'=>'user', 'thumb' =>  $model->profile->photo];
    $items[] = ['url'=>Url::to(["/user/user/playlists"]), 'context'=>"playlists_area", 'name'=> Yii::t('app', 'collections'),'img'=>'bars'];
    $items[] = ['url'=>Url::to(["/user/user/history"]), 'context'=>"history_area", 'name'=> Yii::t('app', 'history'), 'img'=>'history'];
    //  $items[] = ['url'=>Url::to(["/user/configuration"]), 'context'=>"configuration_area", 'name'=> Yii::t('app', 'config'), 'img'=>'cog'];

    if (Yii::$app->user->can('loadListenerMainPanel'))
      $menu = $items;

    if (Yii::$app->user->can('loadArtistMainPanel')){
      $items[] = ['url'=>Url::to(["/user/user/albums"]), 'context'=>"albums_area", 'name'=>'Álbumes', 'img'=>'dot-circle'];
      $menu =  $items;
    }

    return $menu;
  }

  protected function getItemsNav(){
      return [
        ['label'=>'CANALES', 'url' => Url::to(["/channel/channel/list"]), 'linkOptions' =>['data-action'=>"nav"]],
        ['label'=>'ARTISTAS', 'url' => Url::to(["/artist/artist/list"]), 'linkOptions' =>['data-action'=>"nav"]],
        ['label'=>'ÁLBUMES', 'url' => Url::to(["/album/album/list"]), 'linkOptions' =>['data-action'=>"nav"]],
        ['label'=>'COLECCIONES', 'url' => Url::to(["/playlist/playlist/list"]), 'linkOptions' =>['data-action'=>"nav"]]
      ];
  }

  protected function getItemsSocialNav(){
    $profile = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
    $notifWrapper = NotificationService::notificationIndicator($profile);
    return [
        ['label'=> MobileNav::widget(['type' => 'post']), 'url' => '#', 'linkOptions' =>['data-action'=>"nav"]],
        ['label'=> MobileNav::widget(['type' => 'news']), 'url' => Url::to(["/user/post/wall"]), 'linkOptions' =>['data-action'=>"nav"]],
        ['label'=> $notifWrapper, 'url' => Url::to(['/user/social/check']), 'linkOptions' =>['data-action'=>'social.check-notification']],
      ];
  }

  protected function getPostActionItems(){
    return [
      ['id' => 'newPostBtn', 'icon' => 'pencil-alt', 'tooltip' => Yii::t('app', 'newPost')],
    ];
  }

  protected function renderSection($view, $params = []){
    if (Yii::$app->request->isAjax)
        return $this->renderAjax($view, $params);
    else{
      $this->view->params['items']  = $this->getMenuItems();
      $this->view->params['nav'] = $this->getItemsNav();
      $this->view->params['social'] = $this->getItemsSocialNav();
      $this->view->params['postActions'] = $this->getPostActionItems();


      $detect = new MobileDetect();
      $this->view->params['footer'] = $detect->isMobile() ? MobilePlaybackVisor::widget() : '';

      return $this->render($view, $params);
    }
  }

  protected function renderPreview($view, $viewParams){
    $this->layout = '@frontend/views/layouts/main_preview';

    $detect = new MobileDetect();
    $this->view->params['footer'] = $detect->isMobile() ? MobilePlaybackVisor::widget() : '';
    $this->view->params['nav'] = [
      ['label'=>'REGISTRO', 'url' => Url::to(["/site/login"]), 'linkOptions' =>['target'=>'_blank']],
      ['label'=>'LOGIN', 'url' => Url::to(["/site/signup"]), 'linkOptions' =>['target'=>'_blank']],
    ];
    $viewParams['externalSource'] = true;
    return $this->render($view, $viewParams);
  }

  protected function getObjectArrayRepresentation($element, $endpoint, $actions){
      $obj = array();
      $obj['id'] = $element->id;
      $obj['name'] = $element->name;
      $obj['art'] = Url::to(['/ra/thumbnail', 'id' => $element->art, 'entity' => $endpoint]);
      $obj['url'] = Url::to(['/'.$endpoint.'/'.$endpoint.'/view', 'id'=>$element->id]);

      $obj['actions'] = $actions;
      return $obj;
  }

  protected function fillParamsArr($arr, $params){
    foreach ($params as $key => $value)
      $arr[$key] = $value;
    return $arr;
  }

  protected function listElements($filter, $route, $routeParams, $view, $params = null){
      $service = new Searcher();
      if (!$routeParams['segment']){
        $rows = $service->search($filter);
        $elements = $filter->prepareModel($rows);

        $visible = !$service->stopSearch();

        $internalRouteParam[] = $route;

        $internalRouteParam = $this->fillParamsArr($internalRouteParam, $routeParams);
        $internalRouteParam['segment'] = 1;

        $lazyRoute = Url::to($internalRouteParam);

        $params['elements'] = $elements;
        $params['lazyLoad'] = ['route' => $lazyRoute, 'visible' => $visible];


        return $this->renderSection($view, $params);
      }else {
        $rows = $service->search($filter, $routeParams['segment']);
        $elements = $filter->prepareModel($rows);

        $routeParams['segment'] = $routeParams['segment'] + 1;
        $infinite['status'] =  $service->stopSearch();

        $internalRouteParam[] = $route;
        $internalRouteParam = $this->fillParamsArr($internalRouteParam, $routeParams);

        $infinite['route'] = Url::to($internalRouteParam);

        $params['elements'] = $elements;
        $params['partial']  = true;
        $infinite['content'] = $this->renderSection($view, $params);

        return Response::getInstance($infinite, Flags::ALL_OK)->jsonEncode();
      }
  }

  public function actionModal(){}


}
