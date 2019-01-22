<?php
use common\widgets\profile\Profile;
use common\widgets\gridView\GridView;
use user\components\post\Post;
use searcher\services\AlbumFilter;

use yii\helpers\Url;

$albums = [];
if (isset($model->albums)){
  $filter = new AlbumFilter();
  $albums = $filter->prepareModel($model->albums);
}

if(count($albums)>0)
      $production['albums'] = GridView::widget(['enviroment' => 'minimal', 'elements' => $albums, 'lazyLoad' => ['visible' => false]]);
  else
      $production['albums'] = \Yii::t('app','noAlbumDisp');

if (count($posts)>0){
    $lazyLoad = ['route' => '/user/post/wall', 'visible' => $postsRemain];
    $production['posts'] = Post::widget(['profile' => $model->profile, 'component' => 'wall', 'content' => $posts, 'shareable' => true, 'lazyLoad' => $lazyLoad, 'embedded' => true]);
  }else
    $production['posts'] = \Yii::t('app','noHayPubliReciente');

$relArr = [];
if (count($relationships)>0 && isset($relationships['followers']))
  $relArr['followers'] = GridView::widget(['enviroment' => 'minimal', 'elements' => $relationships['followers']]);
else
  $relArr['followers'] = \Yii::t('app','noFollowers');

if (count($relationships)>0 && isset($relationships['followedUsers']))
  $relArr['followedUsers'] = GridView::widget(['enviroment' => 'minimal', 'elements' => $relationships['followedUsers']]);
else
  $relArr['followedUsers'] = \Yii::t('app','noFollowedUsers');




 echo Profile::widget(['user' => $model,
                       'relationships' => $relArr,
                       'productions' => $production,
                       'action' => $profile_action
                     ]);


?>
