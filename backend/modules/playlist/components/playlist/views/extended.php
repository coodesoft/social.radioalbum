<?php

use yii\helpers\Url;
use frontend\modules\playlist\components\playlist\PlayListAsset;
use frontend\modules\playlist\models\Playlist;

PlayListAsset::register($this);

?>

<div class="playlist-container">
  <div class="playlists ra-dark ra-container">
    <div class="ra-title ra-dark-title">
        <span class="vertical-helper"></span>
        <div class="title-text">
          <span>Listas de Reproducción</span>
        </div>
        <div class="pl-action">
          <div class="action action-std-add new-playlist-btn"></div>
        </div>
    </div>
    <div class="playlists-body">
      <div class="ra-tab ra-block">
          <div class="playlists-list">
            <table class="ra-table ra-dark">
              <?php foreach($playlists as $playlist){ ?>
                <?php if ($playlist->name != Playlist::FAVORITES) {?>
                <tr id="<?php echo $playlist->id ?>">
                    <td class="ra-dark-row playlist-item"><a data-action="explore" href="<?php echo Url::to(['/playlist/playlist/view', 'id'=>$playlist->id])?>"><?php echo $playlist->name ?></a></td>
                    <td class="actions ra-dark-row">
                      <div class="action action-play"></div>
                      <div class="action action-edit"><a data-action="modal" href="<?php echo Url::to(['/playlist/playlist/modal', 'id'=>$playlist->id, 'action'=>'update'])?>"></a></div>
                      <div class="action action-remove"><a data-action="modal" href="<?php echo Url::to(['/playlist/playlist/modal', 'id'=>$playlist->id, 'action'=>'delete'])?>"></a></div>
                    </td>
                </tr>
              <?php } } ?>
            </table>
          </div>
      </div>
      <div class="ra-tab ra-hidden">
          <div class="playlists-create">
            <form action="<?php echo Url::to(['/playlist/create']); ?>">
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
                <button type="submit" class="ra-btn ra-std-btn">Crear Lista</button>
              </div>
            </form>
            <div class="alert alert-danger ra-hidden" role="alert"></div>
          </div>
      </div>
    </div>
  </div>

  <div class="playlists-content ra-container ra-dark">
    <div class="text-center"><h1>Listas de Reproducción</h1></div>
  </div>

</div>
