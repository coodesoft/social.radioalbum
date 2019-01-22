<?php
use yii\helpers\Url;

$url = Url::to(['/playlist/playlist/delete']);
$msg = \Yii::t('app','confirEliminarLRep');
?>

<form action="<?php echo $url ?>">
  <div class="text-center">
    <?php echo $msg?>
    <input type="hidden" name="Playlist[id]" value="<?= $id ?>"/>
    <div style="margin-top: 30px;">
      <button type="submit" class="ra-btn ra-big-btn"><?= \Yii::t('app','eliminar')?></button>
    </div>
  </div>
</form>
