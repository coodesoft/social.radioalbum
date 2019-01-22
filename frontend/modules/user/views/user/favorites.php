<?php
use common\widgets\songsList\SongsList;

use user\assets\UserAsset;
UserAsset::register($this);
?>
<div id="playlistDescription" class="ra-container ra-dark">
  <div class="header">
    <div class="header-item name">
      <span class="bold"><?php echo \Yii::t('app', 'name') ?>:</span>
      <span class="italic"><?php echo $favorites->name ?></span>
    </div>
    <div class="header-item visibility">
      <span class="bold"><?php echo \Yii::t('app', 'visibility') ?>:</span>
      <span class="italic"><?php echo \Yii::t('app', $favorites->visibility->type) ?></span>
    </div>
    <div class="header-item">
      <span class="bold"><?php echo \Yii::t('app', '#songs')?>:</span>
      <span id="cantSongs" class="italic"><?php echo count($songs) ?></span>
    </div>
  </div>
<?php
    if (count($songs)>0)
      echo SongsList::widget(['songs' => $songs,
                            'playlist_id' => $favorites->id,
                            'cols' => [
                              'actions' => [
                                  'action' => 1,
                                  'items' => ['add'=>0, 'play' =>1, 'remove' =>1],
                                ]
                            ],
                            'lazyLoad' => $lazyLoad,
                          ]);
    else { ?>
      <div id="noFavSongs">
        <span class="bigMessage ra-dark"><?php echo Yii::t('app', 'noFavSongs'); ?></span>
      </div>
    <?php } ?>
</div>
