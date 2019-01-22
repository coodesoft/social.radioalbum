<?php
namespace searcher\controllers;

use Yii;
use yii\filters\AccessControl;
use frontend\controllers\RaBaseController;
use searcher\services\Searcher;

class SearchController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['search', 'view'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
          ],
      ],
    ];
  }

  /* PENSAR UNA JERARQUIA DE CLASES PARA EXTENDER SIN MAYOR PROBLEMAS LA CANTIDAD
   * DE FILTROS
   */
  public function actionSearch(){
    $filters = [];
    $filterArr = ['channel', 'album', 'song', 'listener', 'artist', 'playlist'];

    $search = Yii::$app->request->get('entity');

    if ( !(isset($search) && is_string($search)) )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);


    foreach ($filterArr as $key => $fElement) {
      $filter = Yii::$app->request->get($fElement);
      if ($filter)
          $filters[] = $fElement;
    }


    if ($search && count($filters)>0){
      $toSearch = $search;
      $results = [];
      foreach ($filters as $key => $filter) {
        $element = $filter;
        $classname = 'searcher\services\\'.ucfirst($element).'Filter';
        $filterInstance = new $classname();
        $filterInstance->createQuery($toSearch);

        $searcher = new Searcher();
        $result = $searcher->search($filterInstance);
        $result = $filterInstance->prepareModel($result);
        $stopSearch = $searcher->stopSearch();

        $item['label'] = Yii::t('app', $element);
        $item['content'] = $this->renderAjax($element, ['content' => $result, 'stopSearch' => $stopSearch, 'entity' => $search]);
        $results[] = $item;
      }

      return $this->renderSection('search', ['items' => $results, 'search' => $search]);
    }
  }

  function actionView(){
    return $this->renderSection('view');
  }
}
