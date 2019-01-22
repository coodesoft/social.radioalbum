<?php
use yii\helpers\Url;
use frontend\modules\playlist\components\playlist\MinPlayListAsset;
MinPlayListAsset::register($this);
?>
<div id="playlistArea" class="playlist-minimal-container ra-dark">
  <div class="list-form">
    <div class="playlists-create">
      <form action="<?php echo Url::to(['playlist/playlist/update']); ?>">
        <div class="form-group">
            <label for="nombrePlayList">Nombre</label>
            <input type="text" name="PlayList[name]" class="form-control" id="nombrePlayList" value="<?php echo $playlist->name?>" required>
        </div>
        <div class="form-group">
          <label for="nombrePlayList">Visibilidad</label>
          <div class="radio">
            <label>
              <?php if ($playlist->visibility->id == 1) { ?>
                <input type="radio" name="PlayList[visibility]" id="visibleRadio1" value="1" checked required>
              <?php } else { ?>
                <input type="radio" name="PlayList[visibility]" id="visibleRadio1" value="1" required>
              <?php } ?>
              Privada
            </label>
          </div>
          <div class="radio">
            <label>
              <?php if ($playlist->visibility->id == 2) { ?>
                <input type="radio" name="PlayList[visibility]" id="visibleRadio1" value="2" checked required>
              <?php } else { ?>
                <input type="radio" name="PlayList[visibility]" id="visibleRadio1" value="2" required>
              <?php } ?>
              Protegida <i>(solo vísible para contactos)</i>
            </label>
          </div>
          <div class="radio">
            <label>
              <?php if ($playlist->visibility->id == 3) { ?>
                <input type="radio" name="PlayList[visibility]" id="visibleRadio1" value="3" checked required>
              <?php } else { ?>
                <input type="radio" name="PlayList[visibility]" id="visibleRadio1" value="3" required>
              <?php } ?>
              Pública
            </label>
          </div>
        </div>
        <input type="hidden" name="PlayList[id]" id="hiddenData" value="<?php echo $playlist->id ?>">

        <div class="text-center">
          <button type="submit" class="ra-btn ra-std-btn">Actualizar Lista</button>
        </div>
      </form>
      <div class="alert alert-danger ra-hidden" role="alert"></div>
    </div>
  </div>
</div>
