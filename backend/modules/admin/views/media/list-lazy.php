  <?php
use yii\helpers\Url;
?>
  
   
  <?php foreach($albums as $album) { ?>
    <tr>
      <td><?php echo $album->id ?></td>
      <td><a class="inv-link" href="<?php echo Url::to(['/admin/media/album', 'id' => $album->id] )?>"> <?php echo $album->name ?></a></td>
      <td><?php echo $album->status ? 'Activo' : 'Inactivo' ?></td>
      <td><?php echo isset($album->art) ? 'Si' : 'No' ?></td>
      <td class="actions">
          <a data-crud="edit" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'edit')?>" data-action="edit-album" href="<?php echo Url::to(['/admin/media/edit', 'id' => $album->id])?>">
            <span class="fa-layers fa-fw">
              <i class="fal fa-circle" data-fa-transform="grow-15"></i>
              <i class="far fa-pencil-alt" data-fa-transform="shrink-3"></i>
            </span>
          </a>
		  <?php if ($album->status == 1) { ?>
          <a data-crud="enable" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'enable')?>" data-action="disable-album" href="<?php echo Url::to(['/admin/media/disable', 'id' => $album->id])?>">
            <span class="fa-layers fa-fw">
              <i class="fal fa-circle" data-fa-transform="grow-15"></i>
			  <i class="far fa-eye" data-fa-transform="shrink-3"></i>
            </span>
          </a>
		  <?php } else { ?>
          <a data-crud="enable" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'disable')?>" data-action="enable-album" href="<?php echo Url::to(['/admin/media/enable', 'id' => $album->id])?>">
            <span class="fa-layers fa-fw">
              <i class="fal fa-circle" data-fa-transform="grow-15"></i>
			  <i class="far fa-eye-slash" data-fa-transform="shrink-3"></i>
            </span>
          </a>
		  <?php } ?>
          <a data-crud="remove" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'eliminar')?>" data-action="delete-album" href="<?php echo Url::to(['/admin/media/modal', 'id' => $album->id, 'action' => 'remove'])?>">
            <span class="fa-layers fa-fw">
              <i class="fal fa-circle" data-fa-transform="grow-15"></i>
              <i class="far fa-trash-alt" data-fa-transform="shrink-3"></i>
            </span>
        </a>		  
      </td>
    </tr>
  <?php }?>