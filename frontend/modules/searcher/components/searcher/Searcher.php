<?php
namespace searcher\components\searcher;
use Yii;
use yii\helpers\Url;

use common\util\MobileDetect;
use common\widgets\RaBaseWidget;
use common\models\Visibility;

class Searcher extends RaBaseWidget{

    public $searcher;

    public $url;

    public $filters;

    public $mobile;

    public function init(){
      parent::init();

      $filters = [
        [
          'type' => Yii::t('app', 'media'),
          'filters' => [
            'channel'  => Yii::t('app', 'canales'),
            'album'    => Yii::t('app', 'albumes'),
            'song'     => Yii::t('app', 'canciones'),
            'playlist' => Yii::t('app', 'playlist'),
            ],
        ],
        [
          'type' => Yii::t('app', 'users'),
          'filters' => [
            'listener' => Yii::t('app', 'listeners'),
            'artist'   => Yii::t('app', 'artistas')],
        ],
      ];

      if ($this->searcher === null){
        $this->filters = $filters;
        $this->url = Url::to(['/searcher/search/search']);
      } else{
        $this->filters = isset($this->searcher['filters']) ? $this->searcher['filters'] : $filters;
        $this->$url = isset($this->searcher['url']) ? $this->searcher['url'] : Url::to(['/ra/search']);
      }
    }

    public function run(){

      if ($this->mobile)
        return $this->render ('mobile');
      else
        return $this->render('view', ['filters' => $this->filters,
                                      'url' => $this->url]);

    }
}


?>
