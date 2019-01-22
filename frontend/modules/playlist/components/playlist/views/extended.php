<?php

use yii\helpers\Url;
use frontend\modules\playlist\components\playlist\PlayListAsset;
use frontend\modules\playlist\models\Playlist;

PlayListAsset::register($this);

?>

<div id="playlistArea" class="playlist-container full-height <?php echo $isMobile ? 'playlist-mobile ra-container' : '' ?>">

  <?php if ($isMobile){ ?>
    <button class="returnToPlaylist btn ra-btn ra-hidden">
      <i class="fas fa-arrow-alt-left"></i>
      <?php echo \Yii::t('app', 'goBack')?>
    </button>
  <?php } ?>

  <div class="playlists ra-dark <?php echo !$isMobile ? 'ra-container' : '' ?>">
    <div class="ra-title ra-dark-title">
        <span class="vertical-helper"></span>
        <div class="title-text">
          <span><?php echo \Yii::t('app', 'collections')?></span>
        </div>
        <div class="pl-action clickeable">
          <i class="fas fa-plus-circle fa-2x new-playlist-btn new-playlist"></i>
        </div>
    </div>
    <div class="playlists-body">

      <div class="ra-tab ra-block">
          <div class="playlists-list">
            <table class="ra-table ra-dark">
              <?php foreach($playlists as $playlist){ ?>
                <tr id="playlist_<?php echo $playlist->id ?>" class="<?php echo ($playlist->name == Playlist::FAVORITES)? 'pl-favorites' : 'pl-regular' ?>">
                    <td class="ra-dark-row playlist-item"><a data-action="explore" href="<?php echo Url::to(['/playlist/playlist/view', 'id'=>$playlist->id])?>"><?php echo $playlist->name ?></a></td>
                </tr>
              <?php  } ?>
            </table>
          </div>
      </div>

      <div class="ra-tab ra-hidden">
          <div class="playlists-create">
            <form action="<?php echo Url::to(['/playlist/playlist/create']); ?>">
              <div class="form-group">
                  <label for="nombrePlayList">Nombre</label>
                  <input type="text" name="PlayList[name]" class="form-control" id="nombrePlayList" placeholder="Rock" required>
              </div>
              <div class="form-group">
                <label for="nombrePlayList">Visibilidad</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="PlayList[visibility]" id="visibleRadio1" value="1" checked required>
                    Privada
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="PlayList[visibility]" id="visibleRadio2" value="2" required>
                    Protegida <i>(solo vísible para contactos)</i>
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
              <div class="text-center">
                <button type="button" class="cancel-new-playlist ra-btn ra-std-btn">Cancelar</button>
                <button type="submit" class="ra-btn ra-std-btn"><?php echo \Yii::t('app', 'createPlaylist')?></button>
              </div>
              <input type="hidden" name="PlayList[origin]" value="extended">
            </form>
            <div class="alert alert-danger ra-hidden" role="alert"></div>
          </div>
      </div>
    </div>
  </div>

  <div class="playlists-content ra-dark <?php echo $isMobile ? 'ra-hidden': 'ra-container' ?> ">
    <div id="noSongs" class="text-center"><h1><?php echo Yii::t('app', 'yourSongs') ?></h1></div>
  </div>

</div>
