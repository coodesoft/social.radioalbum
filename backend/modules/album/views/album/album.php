<?php
use yii\widgets\LinkPager;
use common\widgets\songsList\SongsList;

?>

<div class="ra-container" id="songs-list">
  <?php
    echo SongsList::widget(['songs' => $songs,
                            'cols' => [
                              'actions' => [
                                  'action' => 1,
                                  'items' => ['add'=>0, 'play' =>1, 'remove' =>0],
                                ],
                            ],
                            'lazyLoad' => ['visible' => false]
                          ]);
  ?>
</div>
