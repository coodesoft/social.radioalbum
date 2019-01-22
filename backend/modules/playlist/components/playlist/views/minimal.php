<?php

use yii\helpers\Url;
use frontend\modules\playlist\components\playlist\MinPlayListAsset;
MinPlayListAsset::register($this);

?>

<div class="playlist-minimal-container ra-dark">
<div class="playlists ">
    <div class="ra-title ra-dark-title">Listas de Reproducción</div>
    <div class="playlists-body">
      <div class="ra-tab ra-block">
        <div class="playlists-list list-to-add">
          <table class="ra-table ra-dark">
            <?php foreach($playlists as $playlist){ ?>
              <tr id="<?php echo $playlist->id ?>">
                  <td class="ra-dark-row"><a data-action="modal" href="<?php echo Url::to(['/playlist/playlist/add-song', 'id' => $playlist->id, 'song'=> $song])?>"><?php echo $playlist->name ?></a></td>
              </tr>
            <?php } ?>
          </table>
        </div>
        <div class="new-playlist text-center">
          <button class="new-playlist-btn ra-btn ra-std-btn">Nueva Playlist</button>
        </div>
      </div>
      <div class="ra-tab ra-hidden list-form">
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
              <input type="hidden" name="PlayList[minimal]" id="hiddenData" value="1">
              <input type="hidden" name="PlayList[song]" id="hiddenData" value="<?php echo $song ?>">

              <div class="text-center">
                <button type="button" class="cancel-new-playlist ra-btn ra-std-btn">Cancelar</button>
                <button type="submit" class="ra-btn ra-std-btn">Crear Lista</button>
              </div>
            </form>
            <div class="alert alert-danger ra-hidden" role="alert"></div>
          </div>
      </div>
    </div>
  </div>
</div>
