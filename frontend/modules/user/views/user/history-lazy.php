
<?php
use common\widgets\songsList\SongsList;
?>
<?php  echo SongsList::widget(['songs' => $songs,
                               'profile_id' => $profile_id,
                               'cols' => [
                                 'date' => 1,
                                 'artist' => 0,
                                 'album' => 0,
                                 'actions' => [
                                     'action' => 1,
                                     'items' => ['add' => 1, 'play' => 1, 'favs' => 1, 'remove' => 0],
                                   ]
                               ],
                               'partialRender' => true
                              ])?>
