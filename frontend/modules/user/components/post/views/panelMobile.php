<?php
use yii\helpers\Url;
use user\components\post\PostPanelAsset;
PostPanelAsset::register($this);
?>

  <div id="newPost" class="panel-hide">
    <div class="post-head title third-title"><?php echo Yii::t('app', 'post')?></div>
    <form action="<?php echo Url::to(['/user/post/post']) ?>" method="post">
      <div class="post-content">
          <textarea class="text_box" name="Post[content]" placeholder="<?php echo Yii::t('app', 'whatPost')?>" ></textarea>
      </div>
      <div class="post-album">
          <div>
            <span class="title"><?php echo Yii::t('app', 'album') ?>:</span>
            <input type="text" class="album-name">
            <div class="album-result"></div>
          </div>
      </div>

      <div class="post-actions text-right">
        <div class="aditional-actions text-left">
          <button id="showAlbumInput" type="button" class="attachEntities btn ra-btn">
              <i class="clickeable fas fa-dot-circle icon-attach"  data-fa-transform="grow-10"></i>
              <?php echo Yii::t('app', 'shareAlbum')?>
          </button>
        </div>
        <select class="btn ra-btn" name="Post[visibility]">
          <?php foreach ($array as $key => $visibility) { ?>
            <option value="<?php echo $visibility->id?>"><?php echo Yii::t('app', 'post-'.$visibility->type) ?></option>
          <?php } ?>
        </select>
        <input class="share-album" type="hidden" name="Post[album]">
        <button id="sendPost" type="submit" class="btn ra-btn"><?php echo Yii::t('app', 'newPost')?></button>
      </div>
    </form>
  </div>
</div>

<div id="postPanelBackground" class="panel-hide"></div>
