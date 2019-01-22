<?php
use frontend\modules\playlist\components\playlist\PlayListAsset;
use frontend\modules\playlist\components\playlist\PlayList;
use frontend\modules\playlist\assets\PlaylistAsset as PlModuleAsset;
// asset del componente. Hay que agregarlo por que el enviroment = description //
// no incluye assets.
PlayListAsset::register($this);

// asset del módulo.
PlModuleAsset::register($this);

if (isset($env)) {?>
  <div id="playlistViewDescription" class="ra-container" style="padding: 0px 10px;">
    <?php echo PlayList::widget([ 'enviroment' => 'description',
                                    'lazyLoad' => $lazyLoad,
                                    'playlist_content' => $songs,
                                    'element' => $playlist,
                                    'externalSource' => $externalSource ]); ?>
  </div>

<?php } else {
  echo PlayList::widget([ 'enviroment' => 'description',
                                  'lazyLoad' => $lazyLoad,
                                  'playlist_content' => $songs,
                                  'element' => $playlist ]);
}
