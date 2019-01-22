<?php
use yii\widgets\LinkPager;
use common\widgets\songsList\SongsList;


?>
<?php

if (isset($partial) && $partial) {
  echo SongsList::widget(['songs' => $songs,
                          'partialRender' => true,
                          'cols' => [
                            'actions' => [
                                'action' => 1,
                                'items' => ['add'=>0, 'play' =>1, 'favs' => 0, 'remove' =>0],
                              ],
                          ],
                         ]);
} else { ?>
  <div class="ra-container">
    <?php  echo SongsList::widget(['songs' => $songs,
                                   'lazyLoad' => $lazyLoad,
                                   'cols' => [
                                     'actions' => [
                                         'action' => 1,
                                         'items' => ['add'=>0, 'play' =>1, 'favs' => 0, 'remove' =>0],
                                       ],
                                   ],
                                   ])?>
  </div>
<?php } ?>
