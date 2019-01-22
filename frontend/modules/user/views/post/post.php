<?php
use user\components\post\Post;
use yii\helpers\Url;

$post =  Post::widget(['profile' => $me, 'component' => 'wall', 'content' => $content, 'shareable' => $shareable]);
 ?>
<div id="singlePostView" class="ra-container">
  <?php echo $post; ?> 
</div>
