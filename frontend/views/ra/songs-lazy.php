<?php
use common\widgets\songsList\SongsList;

echo SongsList::widget(['songs' => $songs,
                        'profile_id' => $profile_id,
                        'partialRender' => true,
                       ]);
  ?>
