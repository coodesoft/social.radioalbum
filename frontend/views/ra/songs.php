<?php
use yii\widgets\LinkPager;
use common\widgets\songsList\SongsList;
?>

<?php if (isset($partial) && $partial) {
  echo SongsList::widget(['songs' => $songs, 'profile_id' => $profile_id, 'partialRender' => true,]);
  } else {?>
<div class="ra-container">
  <div id="sectionHead">
    <div class="title text-center"><?php echo strtoupper(\Yii::t('app', 'canciones'))?></div>
    <div class="subtitle text-center"><?php echo \Yii::t('app', 'muchSongEnjoy')?></div>
  </div>
  <?php  echo SongsList::widget(['songs' => $songs, 'profile_id' => $profile_id,'lazyLoad' => $lazyLoad])?>
</div>
<?php } ?>
