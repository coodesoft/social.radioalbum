<?php
use common\widgets\profile\Profile;
use common\widgets\gridView\GridView;
use user\components\post\Post;

use yii\helpers\Url;

$albums = [];
if (isset($artist->albums)){
  foreach($artist->albums as $album){
    $obj = array();
    $obj['id'] = $album->id;
    $obj['name'] = $album->name;
    $obj['art'] = Url::to(['/ra/thumbnail', 'id' => $album->art, 'entity' => 'album']);
    $obj['url'] = Url::to(['/album/album/view', 'id'=>$album->id]);

    $actions['pop'][] =  ['text' => Yii::t('app', 'report'), 'url' => Url::to(['/report/load', 'id' => $album->id, 'entity' => 'media']) ];
    $obj['actions'] = $actions;
    $albums[] = $obj;
  }
}


if(count($albums)>0)
      $production['albums'] = GridView::widget(['elements' => $albums, 'lazyLoad' => ['visible' => false]]);
  else
      $production['albums'] = \Yii::t('app','noAlbumDisp');

if (count($posts)>0){
      $lazyLoad = ['route' => '/user/post/wall', 'visible' => $postsRemain];
      $production['posts'] = Post::widget(['profile' => $artist->profile, 'component' => 'wall', 'content' => $posts, 'shareable' => true, 'lazyLoad' => $lazyLoad, 'embedded' => true]);
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


 echo Profile::widget(['user' => $artist, 'relationships' => $relArr, 'productions' => $production, 'action' => $profile_action]);


?>
