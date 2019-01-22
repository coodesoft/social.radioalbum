<?php
use yii\helpers\Url;
?>

<div id="previewAlbum">
    <div class="thumb">
        <img src="<?php echo Url::to(['/ra/thumbnail', 'entity' => 'collection']);?>" alt="thumb-<?php echo $entity['name']; ?>">
    </div>
    <div class="album-content">
        <div class="album-info">
          <div class="album-artist">
            <?php echo $entity['profile']['name'] ?>
          </div>
          <div class="album-name">
            <?php echo $entity['name']?></div>
        </div>
    </div>
</div>
