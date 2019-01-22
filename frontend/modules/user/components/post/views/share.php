<?php
use user\components\post\SharePostAsset;
use yii\helpers\Url;
SharePostAsset::register($this);
?>

<div id="sharePost">
  <form class="" action="<?php echo Url::to(['/user/share/post'])?>" method="post">
    <div class="post-content">
        <textarea class="share_text_box" name="Post[content]" placeholder="<?php echo \Yii::t('app', 'typeMessage')?>" ></textarea>
    </div>
    <input type="hidden" name="Post[attached_type]" value="<?php echo $type?>">
    <input type="hidden" name="Post[attached_id]" value="<?php echo $id?>">

    <div class="horizontal-separator"></div>

    <div id="attachContent">
        <?php echo $content ?>
    </div>

    <div class="horizontal-separator"></div>

    <div class="post-actions text-right">
      <select class="btn ra-btn" name="Post[visibility]">
        <?php foreach ($visArray as $key => $visibility) { ?>
          <option value="<?php echo $visibility->id?>"><?php echo Yii::t('app', 'post-'.$visibility->type) ?></option>
        <?php } ?>
      </select>
      <input class="share-album" type="hidden" name="Post[album]">
      <button id="sendPost" type="submit" class="btn ra-btn"><?php echo Yii::t('app', 'newPost')?></button>
    </div>

  </form>
 </div>
