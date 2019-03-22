<?php
namespace backend\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\User;


class RaBaseController extends Controller{

  public $layout = '@backend/views/layouts/main_logged';


  protected function getMenuItems(){
    $menu = array();
    $items = array();

    if (Yii::$app->user->can('loadAdminMainPanel')) {
      $items[] = ['url' => Url::to(["/admin/user/users"]), 'context' => "admin-users", 'name' => \Yii::t('app', 'users'), 'img' => 'user'];
      $menu = $items;
    }

    if (Yii::$app->user->can('loadRegulatorMainPanel')){
      $items[] = [ 'url' => Url::to(["/admin/media/view"]), 'context' => "admin-albums", 'name'    => \Yii::t('app', 'albumes'), 'img' => 'compact-disc' ];
      $items[] = ['url' => Url::to(["/admin/channel/list"]), 'context' => "admin-channels", 'name' => \Yii::t('app', 'canales'), 'img' => 'music'];
      $items[] = ['url' => Url::to(["/admin/artist/list"]), 'context' => "admin-artists", 'name' => \Yii::t('app', 'artistas'), 'img' => 'users'];
      $items[] = [ 'url' => Url::to(["/regulator/regulator/reports"]), 'context' => "regulate_content", 'name'  => \Yii::t('app', 'Regular contenido'), 'img' => 'cog'];
      $menu = $items;
    }

      return $menu;
  }

  protected function getItemsNav(){
    return [];
      return [
        ['label'=>'CANALES', 'url' => Url::to(["/ra/channels"]), 'linkOptions' =>['data-action'=>"nav", 'data-context' => 'nav-channels']],
        ['label'=>'ARTISTAS', 'url' => Url::to(["/ra/artists"]), 'linkOptions' =>['data-action'=>"nav", 'data-context' => 'nav-artists']],
        ['label'=>'ÁLBUMES', 'url' => Url::to(["/ra/albums"]), 'linkOptions' =>['data-action'=>"nav", 'data-contex|t' => 'nav-albums']],
        ['label'=>'CANCIONES', 'url' => Url::to(["/ra/songs"]), 'linkOptions' =>['data-action'=>"nav", 'data-context' => 'nav-songs']]
      ];
  }

  protected function getItemsSocialNav(){
    return [
      ['label'=>'MURO', 'url' => Url::to(["/ra/wall"]), 'linkOptions' =>['data-action'=>"nav", 'data-context' => 'nav-wall']],
      ['label'=>'MENSAJES', 'url' => Url::to(["/ra/messages"]), 'linkOptions' =>['data-action'=>"nav", 'data-context' => 'nav-messages']],
    ];
  }

  protected function renderSection($view, $params = []){
    if (Yii::$app->request->isAjax)
        return $this->renderAjax($view, $params);
    else{
      $this->view->params['items']  = $this->getMenuItems();
      $this->view->params['nav'] = $this->getItemsNav();
      $this->view->params['social'] = $this->getItemsSocialNav();
      return $this->render($view, $params);
    }
  }

  protected function getObjectArrayRepresentation($element, $route, $actions, $entity){
      $obj = array();
      $obj['id'] = $element->id;
      $obj['name'] = $element->name;
      $obj['art'] = Url::to(['/ra/thumbnail', 'id' => $element->art, 'entity' => $entity]);
      $obj['url'] = Url::to([$route, 'id' => $element->id]);
      $obj['actions'] = $actions;
      return $obj;
  }

  public function actionModal(){}

}
