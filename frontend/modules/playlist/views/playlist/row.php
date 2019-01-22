<?php
use yii\helpers\Url;
use frontend\modules\playlist\models\Playlist;

if ($minimal){
  $url = Url::to(['/playlist/playlist/add-song', 'id' => $playlist->id, 'entity'=> $song]);
} else
  $url = Url::to(['/playlist/playlist/view', 'id'=>$playlist->id])

?>

<tr id="playlist_<?php echo $playlist->id ?>" class="<?php echo ($playlist->name == Playlist::FAVORITES)? 'pl-favorites' : 'pl-regular' ?>">
  <td class="ra-dark-row"><a data-action="<?php echo $minimal ? 'modal': 'explore' ?>" href="<?php echo $url ?>"><?php echo $playlist->name ?></a></td>
</tr>
