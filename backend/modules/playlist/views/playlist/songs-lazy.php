<?php
use common\widgets\songsList\SongsList;

echo SongsList::widget(['songs' => $songs,
                        'playlist_id' => $playlist_id,
                        'cols' => [
                          'actions' => [
                              'action' => 1,
                              'items' => ['add'=>0, 'play' =>1, 'remove' =>1],
                            ]
                        ],
                        'partialRender' => true
                      ]);

?>
