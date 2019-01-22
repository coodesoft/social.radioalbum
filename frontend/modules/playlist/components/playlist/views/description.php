<?php
use yii\helpers\Url;


use common\widgets\songsList\SongsList;
use frontend\modules\playlist\models\Playlist;
if (!isset($content))
  $content = $playlist->songs;
?>

<div id="playlistDescription" data-pl="playlist_<?php echo $playlist->id?>">
  <div class="header">
    <?php if (!$externalSource){ ?>
    <div class="header-item name">
      <span class="strong"><?php echo \Yii::t('app', 'name') ?>:</span>
      <span class="italic"><?php echo $playlist->name ?></span>
    </div>
    <div class="header-item visibility">
      <span class="strong"><?php echo \Yii::t('app', 'visibility') ?>:</span>
      <span class="italic"><?php echo \Yii::t('app', $playlist->visibility->type) ?></span>
    </div>
    <div class="header-item">
      <span class="strong"><?php echo \Yii::t('app', '#songs')?>:</span>
      <span id="cantSongs" class="italic"><?php echo count($songs) ?></span>
    </div>
  <?php } else { ?>
    <div class="header-item title main-title">
      <?php echo $playlist->name ?>
    </div>
  <?php } ?>

    <div class="playlists-action">
        <div class="action" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'playback')?>">
          <a data-action="playback-collection" href="<?php echo Url::to(['/webplayer/playlist', 'id'=>$playlist->id])?>">
            <span class="fa-layers fa-fw table-action">
              <i class="fal fa-circle" data-fa-transform="grow-18"></i>
              <i class="far fa-play" data-fa-transform="shrink-3"></i>
            </span>
          </a>
        </div>
        <?php if ($playlist->name != Playlist::FAVORITES && $crudPermission){?>
        <div class="action" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'edit')?>">
          <a data-action="modal" href="<?php echo Url::to(['/playlist/playlist/modal', 'id'=>$playlist->id, 'action'=>'update'])?>">
            <span class="fa-layers fa-fw table-action">
              <i class="fal fa-circle" data-fa-transform="grow-18"></i>
              <i class="far fa-pencil-alt" data-fa-transform="shrink-3"></i>
            </span>
          </a>
        </div>
        <?php  } ?>
        <?php if (!$externalSource){ ?>
        <div class="action" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'shareCollection')?>">
          <a data-action="modal" href="<?php echo Url::to(['/user/share/target', 'id' => $playlist->id, 'content'=>'collection'])?>">
            <span class="fa-layers fa-fw table-action" data-toggle="tooltip">
              <i class="fal fa-circle" data-fa-transform="grow-18"></i>
              <i class="fal fa-share" data-fa-transform="shrink-3"></i>
            </span>
          </a>
        </div>
        <?php  } ?>
        <?php if ($playlist->name != Playlist::FAVORITES && $crudPermission){?>
        <div class="action" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'delete')?>">
          <a data-action="modal" href="<?php echo Url::to(['/playlist/playlist/modal', 'id'=>$playlist->id, 'action'=>'delete'])?>">
            <span class="fa-layers fa-fw table-action" data-toggle="tooltip">
              <i class="fal fa-circle" data-fa-transform="grow-18"></i>
              <i class="fal fa-trash-alt" data-fa-transform="shrink-3"></i>
            </span>
          </a>
        </div>
        <?php  } ?>
    </div>

  </div>
  <div class="content">
  <?php
  if (!empty($songs)) {
    $remove = $crudPermission;
    echo SongsList::widget(['songs' => $songs,
                          'playlist_id' => $playlist->id,
                          'cols' => [
                            'actions' => [
                                'action' => 1,
                                'items' => ['add'=>!$externalSource, 'play'=>1, 'favs'=>0,'remove' =>$remove],
                              ],
                          ],
                          'lazyLoad' => $lazyLoad
                          ]);
  ?>
  </div>
  <?php } else{
  ?>
  <div id="noSongs" class="text-center" data-pl="playlist_"<?php echo $playlist->id?>><h1> <?php echo \Yii::t('app','playlistEmpty')?></h1></div>
  <?php } ?>

</div>
