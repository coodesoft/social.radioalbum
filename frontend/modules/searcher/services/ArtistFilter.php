<?php
namespace searcher\services;

use Yii;
use yii\helpers\Url;
use yii\db\Expression;

use common\models\User;
use common\util\ArrayProcessor;
use frontend\modules\artist\models\Artist;

class ArtistFilter extends AbstractFilter{

  public function createQuery($toSearch = null){
    if ($toSearch){
      $toSearch = strtolower($toSearch);
      $listedCondition = ['listed' => '1'];
      $this->query = Artist::find()->with('profile')->where(['like', 'name', $toSearch])->orderBy('name');
    } else
      $this->query = Artist::find()->with('profile')->orderBy(new Expression('rand()'));
  }

  public function prepareModel($params = null){
    $actions = [];
    $artists = [];
    $me = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;

//   $actions['adicional'][] = ['icon' => 'plus', 'url' => Url::to(), 'type' => 'modal', 'tooltip' => \Yii::t('app', 'addToPlaylist')];
//   $actions['adicional'][] = ['icon' => 'star', 'url' => Url::to(), 'type' => 'modal', 'tooltip' => \Yii::t('app', 'addToFavs')];
//   $actions['main']        = ['icon' => 'play', 'url' => Url::to(), 'type' => 'playback', 'tooltip' => \Yii::t('app', 'playback')];

    foreach($params as $artist)
    if ($me->id != $artist->profile->id)
      $artists[] = ArrayProcessor::userToArrayRepresentation($artist, '/artist/artist/view', $actions);

    return $artists;
  }
}
