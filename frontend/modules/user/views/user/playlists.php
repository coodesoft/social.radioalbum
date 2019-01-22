<?php
use frontend\modules\playlist\components\playlist\PlayList;

?>

<?php echo PlayList::widget(['playlists' => $playlists,
                              'profile'=>$profile,
                              'enviroment' => 'extended']) ?>
