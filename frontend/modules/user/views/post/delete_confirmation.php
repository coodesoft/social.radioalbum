<?php
use yii\helpers\Url;
?>

  <div id="removeSocialBlock">
    <?php if (isset($post)) {?>
    <form action="<?php echo Url::to(['/user/post/remove-post'])?>" >
      <input type="hidden" name="Post[id]" value="<?php echo $post->id?>">
      <div class="paragrapgh text-center"><?php echo \Yii::t('app', 'deletePostConfirm')?></div>
      <div class="text-center">
        <button type="submit" class="ra-btn btn"><?php echo \Yii::t('app', 'eliminar')?></button>
      </div>
    </form>
  <?php } elseif (isset($comment)) { ?>
    <form action="<?php echo Url::to(['/user/post/remove-comment'])?>" >
      <input type="hidden" name="Comment[id]" value="<?php echo $comment->id?>">
      <div class="paragrapgh text-center"><?php echo \Yii::t('app', 'deleteCommentConfirm')?></div>
      <div class="text-center">
        <button type="submit" class="ra-btn btn"><?php echo \Yii::t('app', 'eliminar')?></button>
      </div>
    </form>
  <?php }?>

  </div>
