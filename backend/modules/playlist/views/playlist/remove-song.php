<?php
use yii\helpers\Url;

$url = Url::to(['/playlist/playlist/remove-song']);
$msg = \Yii::t('app','confirDelSong',['song' => $song_name];
?>

<form action="<?= $url ?>">
  <div class="text-center">
    <?= $msg?>
    <input type="hidden" name="Playlist[id]" value="<?= $id ?>"/>
    <input type="hidden" name="Playlist[song]" value="<?= $song_id ?>"/>
    <div style="margin-top: 30px;">
      <button type="submit" class="ra-btn ra-big-btn"><?=\Yii::t('app','eliminar')?></button>
    </div>
  </div>
</form>
