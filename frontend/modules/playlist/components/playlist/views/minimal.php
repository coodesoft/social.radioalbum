<?php

use yii\helpers\Url;
use frontend\modules\playlist\components\playlist\MinPlayListAsset;
MinPlayListAsset::register($this);

$route = ($type == 'song') ? '/playlist/playlist/add-song' : '/playlist/playlist/add-album';

?>

<div id="playlistArea" class="playlist-minimal-container ra-dark">
<div class="playlists ">
    <div class="ra-title ra-dark-title"><?php echo \Yii::t('app', 'collections')?></div>
    <div class="playlists-body">
      <div class="ra-tab ra-block">
        <div class="playlists-list list-to-add">
          <table class="ra-table ra-dark">
            <?php foreach($playlists as $playlist){ ?>
              <tr id="playlist_<?php echo $playlist->id ?>">
                  <td class="ra-dark-row"><a data-action="modal" href="<?php echo Url::to([$route, 'id' => $playlist->id, 'entity'=> $song])?>"><?php echo $playlist->name ?></a></td>
              </tr>
            <?php } ?>
          </table>
        </div>
        <div class="new-playlist text-center">
          <button class="new-playlist-btn ra-btn ra-std-btn"><?php echo \Yii::t('app', 'newCollection')?></button>
        </div>
      </div>
      <div class="ra-tab ra-hidden list-form">
          <div class="playlists-create">
            <form action="<?php echo Url::to(['/playlist/playlist/create']); ?>">
              <div class="form-group">
                  <label for="nombrePlayList"><?php echo \Yii::t('app', 'name')?></label>
                  <input type="text" name="PlayList[name]" class="form-control" id="nombrePlayList" placeholder="Rock" required>
              </div>
              <div class="form-group">
                <label for="nombrePlayList"><?php echo \Yii::t('app', 'visibility')?></label>
                <div class="radio">
                  <label>
                    <input type="radio" name="PlayList[visibility]" id="visibleRadio1" value="1" checked required>
                    Privada
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="PlayList[visibility]" id="visibleRadio2" value="2" required>
                    <?php echo \Yii::t('app', 'protectedExtended')?>
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="PlayList[visibility]" id="visibleRadio2" value="3" required>
                    Pública
                  </label>
                </div>
              </div>
              <input type="hidden" name="PlayList[profile]" id="hiddenData" value="<?php echo $profile ?>">
              <input type="hidden" name="PlayList[minimal]" id="hiddenData" value="1">
              <input type="hidden" name="PlayList[song]" id="hiddenData" value="<?php echo $song ?>">
              <input type="hidden" name="PlayList[origin]" value="minimal">

              <div class="text-center">
                <button type="button" class="cancel-new-playlist ra-btn ra-std-btn"><?php echo \Yii::t('app', 'cancel')?></button>
                <button type="submit" class="ra-btn ra-std-btn"><?php echo \Yii::t('app', 'createCollection')?></button>
              </div>
            </form>
            <div class="alert alert-danger ra-hidden" role="alert"></div>
          </div>
      </div>
    </div>
  </div>
</div>
