<?php
use user\components\post\Post;
use yii\helpers\Url;


if($component == 'wall'){ ?>

  <div id="postsArea" class="ra-container">
    <div class="post-sections text-center">
      <a style="width: 200px" class="btn ra-btn <?php echo ($myPosts) ? 'active': '' ?>" data-action="nav" href="<?php echo Url::to(['/user/post/wall', 'w' => 'me'])?>"><?php echo \Yii::t('app', 'myPosts')?></a>
      <a style="width: 200px" class="btn ra-btn <?php echo (!$myPosts) ? 'active': '' ?>" data-action="nav" href="<?php echo Url::to(['/user/post/wall'])?>"><?php echo \Yii::t('app', 'allPosts')?></a>
    </div>
    <?php
      echo Post::widget(['profile' => $me, 'component' => $component, 'content' => $content, 'shareable' => $shareable, 'lazyLoad' => $lazyLoad]);
     ?>


  </div>

<?php } else {
  $me = isset($me) ? $me : null;
  if (isset($reply_to))
    echo Post::widget(['profile' => $me, 'component' => $component, 'content' => $content, 'shareable' => $shareable, 'reply_to' => $reply_to]);
  else{
      echo Post::widget(['profile' => $me, 'component' => $component, 'content' => $content, 'shareable' => $shareable]);
  }

}?>
