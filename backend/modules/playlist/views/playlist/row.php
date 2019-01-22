<?php
use yii\helpers\Url;

if ($minimal){
  $url = Url::to(['playlist/playlist/add-song', 'id' => $playlist->id, 'song'=> $song]);
} else
  $url = Url::to(['playlist/playlist/view', 'id'=>$playlist->id])

?>

<tr id="<?php echo $playlist->id ?>">
  <td class="ra-dark-row"><a data-action="modal" href="<?php echo $url ?>"><?php echo $playlist->name ?></a></td>
  <?php if (!$minimal) {?>
  <td class="actions ra-dark-row">
    <div class="action action-play"></div>
      <div class="action action-update"><a data-action="modal" href="<?php echo Url::to(['playlist/playlist/modal', 'id'=>$playlist->id, 'action'=>'update'])?>"></a></div>
      <div class="action action-remove"><a data-action="modal" href="<?php echo Url::to(['playlist/playlist/modal', 'id'=>$playlist->id, 'action'=>'delete'])?>"></a></div>
  </td>
<?php } ?>
</tr>
