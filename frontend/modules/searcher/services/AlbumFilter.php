<?php
namespace searcher\services;

use Yii;
use yii\helpers\Url;
use yii\db\Expression;


use common\util\ArrayProcessor;
use frontend\modules\album\models\Album;
use frontend\modules\channel\models\Channel;

class AlbumFilter extends AbstractFilter{

  public $relatedChannelId = null;

  public function setQuery($query){
    $this->query = $query;
  }

  public function createQuery($toSearch = null){
    if ($this->query == null){

      if ($this->relatedChannelId){
        $channel = Channel::findOne($this->relatedChannelId);
        $this->query = $channel->getAlbums()->where(['status' => '1']);
      } elseif ($toSearch){
          $toSearch = strtolower($toSearch);

          $likeCondition = ['like', 'name', $toSearch];
          $statusCondition = ['status' => '1'];
          $this->query = Album::find()->where(['and', $likeCondition, $statusCondition])->orderBy('name');
        } else
          $this->query = Album::find()->where(['status' => '1'])->orderBy(new Expression('rand()'));
    }

  }

  public function prepareModel($params = null){
    $albums = [];

    foreach($params as $album){
      $actions = [];

      $actions['pop'] = [];
      $actions['pop'][] = ['text' => Yii::t('app', 'report'), 'url' => Url::to(['/report/load', 'id' =>  $album->id, 'entity' => 'media'])];


//      $actions['adicional'][] = ['icon' => 'star', 'url' => Url::to(), 'type' => 'modal', 'tooltip' => \Yii::t('app', 'addToFavs')];
      $actions['adicional'][] = ['icon' => 'play', 'url' => Url::to(['/webplayer/album', 'id' =>  $album->id]), 'type' => 'playback-collection', 'tooltip' => \Yii::t('app', 'playback')];
      $actions['adicional'][] = ['icon' => 'plus', 'url' => Url::to(['/user/user/create-playlist', 'id'=>$album->id]), 'type' => 'modal', 'tooltip' => \Yii::t('app', 'addAlbumToPlaylists')];
      $actions['adicional'][] = ['icon' => 'share', 'url' => Url::to(['/user/share/target', 'content' => 'album', 'id' => $album->id]), 'type' => 'modal', 'tooltip' => \Yii::t('app', 'share')];
      $albums[] = ArrayProcessor::objectToArrayRepresentation($album, 'album', $actions);
    }

    return $albums;
  }
}
