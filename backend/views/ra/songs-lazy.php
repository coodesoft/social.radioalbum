<?php
use common\widgets\songsList\SongsList;

echo SongsList::widget(['songs' => $songs,
                        'partialRender' => true,
                        'cols' => [
                          'actions' => [
                              'action' => 1,
                              'items' => ['add'=>0, 'play' =>1, 'remove' =>0],
                            ],
                        ],
                       ]);
  ?>
