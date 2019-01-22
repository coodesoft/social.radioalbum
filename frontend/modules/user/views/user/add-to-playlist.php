<?php
use frontend\modules\playlist\components\playlist\PlayList;
use common\widgets\modalBox\ModalBox;

$content = PlayList::widget(['enviroment' => 'minimal',
                             'playlists' => $profile->playlists,
                             'element' => $id,
                             'profile' => $profile->id,
                             'type' => $type,
                             ]);

echo ModalBox::widget(['title' => \Yii::t('app','addToPlaylist'), 'content' => $content]);
 ?>
