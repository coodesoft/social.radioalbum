<?php
use common\widgets\songsList\SongsListAsset;
use yii\helpers\Url;
use common\util\StrProcessor;
SongsListAsset::register($this);

$pl ="";
if (isset($playlist_id))
  $pl = 'data-playlist="'.$playlist_id.'"';
?>
<?php if (!empty($songs)){ ?>
<div id="songsList" class="song-list-mobile">
  <table id="songListTable" class="ra-table <?php echo $theme?>" <?php echo $pl ?> data-lazy-component="songs-list">

  <!-- Esto define el ancho de las columnas -->
  <?php if (!$cols['date']){ ?>
    <col style="width:100%">
  <?php } else{ ?>
    <col style="width:50%">
    <col style="width:50%">
  <?php }?>
    <thead>
      <tr class="header">

        <?php if ($cols['name']){ ?>
           <th><?php //echo  \Yii::t('app','name') ?></th>
        <?php }?>

        <?php if ($cols['date']){ ?>
          <th><?php echo  \Yii::t('app','fechaReprod') ?></th>
        <?php }?>
      </tr>
    </thead>
    <tbody>
    <?php foreach($songs as $song){ ?>
      <tr class="ra-table-item">

      <?php if ($cols['name']){ ?>
        <td class="info ra-dark-row" id="song_<?php echo  $song['id'] ?>">
          <div class="song-name"><?php echo $name = isset($song['name']) ? $song['name'] : '' ?></div>

          <?php if ($cols['artist']){ ?>
          <div class="song-info song-artist">
            <div class="song-info-label"><?php echo  \Yii::t('app', 'artist')?>: </div>
            <div class="song-info-data">
              <?php
                if (!empty($song->album->artists)){
                    foreach($song->album->artists as $artist)
                        echo $artist->name;
                }
               ?>
            </div>
          </div>
          <?php } ?>

          <?php if ($cols['album']){ ?>
          <div class="song-info song-album">
            <div class="song-info-label"><?php echo \Yii::t('app', 'song')?>: </div>
            <div class="song-info-data"><?php echo  $song->album->name ?></div>
          </div>
          <?php } ?>

          <div class="song-info song-time">
            <div class="song-info-label"><?php echo \Yii::t('app', 'length')?>:</div>
            <div class="song-info-data"><?php echo $time = isset($song['time']) ? StrProcessor::secondsToMinutes($song['time']) : 'NN:NN' ?></div>
          </div>

          <div class="song-info song-actions ">
            <?php if ($cols['actions']['items']['play']){ ?>
                <div class="action action-play" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'playback')?>">
                  <a href="<?php echo  Url::to(['/webplayer/linked-song', 'id'=> $song['id'], 'playlist' =>  $playlist_id]) ?>" data-action="playback">
                    <i class="fal fa-play-circle fa-2x table-action"></i>
                  </a>
                </div>
            <?php }?>
            <?php if ($cols['actions']['items']['add']){ ?>
              <div class="action action-add" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'addToPlaylist')?>">
                <a data-action="modal" href="<?php echo  Url::to(['/user/user/modal', 'id'=>$song['id'], 'action'=>'add-song-to-playlist'])?>">
                  <i class="fal fa-plus-circle fa-2x table-action"></i>
                </a>
              </div>
            <?php }?>
            <?php if ($cols['actions']['items']['favs']){ ?>
              <div class="action action-star" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'addToFavs')?>">
                <a data-action="modal" href="<?php echo  Url::to(['/playlist/playlist/add-to-favs', 'id'=>$song['id']])?>">
                  <span class="fa-layers fa-fw fa-2x table-action" data-toggle="tooltip">
                    <i class="fal fa-circle"></i>
                    <i class="fal fa-star" data-fa-transform="shrink-7"></i>
                  </span>
                </a>
              </div>
            <?php }?>
            <?php if ($cols['actions']['items']['remove']){ ?>
              <div class="action action-remove" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'removeFromPlaylist')?>">
                <a data-action="modal" href="<?php echo  Url::to(['/playlist/playlist/modal', 'playlist_id' => $playlist_id, 'id'=>$song['id'], 'name'=>$song['name'], 'action'=>'remove-from-playlist'])?>">
                  <span class="fa-layers fa-fw fa-2x table-action" data-toggle="tooltip">
                    <i class="fal fa-circle"></i>
                    <i class="fal fa-trash-alt" data-fa-transform="shrink-8"></i>
                  </span>
                </a>
              </div>
            <?php }?>
          </div>
        </td>
      <?php }?>

      <?php if ($cols['date']){ ?>
        <td class="info ra-dark-row"><?php echo $date = isset($song['date']) ? StrProcessor::formatDate('m/d/Y', $song['date']) : '' ?></td>
      <?php }?>

    </tr>
    <?php } ?>
    </tbody>

  </table>
</div>
  <p class="text-center">
  <?php if ($lazyLoad['visible']){ ?>
    <a data-action="lazy-load" href="<?php echo $lazyLoad['route'] ?>" class="btn ra-dark-btn" data-lazy-target="songs-list">Cargar mas</a>
    <img class="ra-hidden ra-loader-xs" src="<?php echo Url::to(["/img/loader.gif"]) ?>" alt="radioalbum loader">
  <?php } ?>
  </p>

<?php } ?>
