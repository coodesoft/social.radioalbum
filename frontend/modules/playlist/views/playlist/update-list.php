<?php
use frontend\modules\playlist\components\playlist\PlayList;

echo PlayList::widget([ 'enviroment' => 'update', 'element' => $playlist]);

?>
