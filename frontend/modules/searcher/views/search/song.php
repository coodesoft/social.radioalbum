<?php
use yii\helpers\Url;

use common\widgets\songsList\SongsList;
use common\models\User;

$url = Url::to(['/ra/songs', 'entity' => $entity, 'segment' => 1]);
$lazyLoad = ['route' => $url, 'visible' => !$stopSearch];
$profile = User::getModel(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;


echo SongsList::widget(['songs' => $content, 'profile_id' => $profile->id,'lazyLoad' => $lazyLoad]);

?>
