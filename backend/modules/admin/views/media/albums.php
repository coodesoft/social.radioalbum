<?php
use yii\helpers\Url;
use admin\assets\CatalogAsset;
CatalogAsset::register($this);
?>

<table id="catalogAdmin" class="table table-bordered table-striped" >
	<col style="width:10%">
    <col style="width:45%">
    <col style="width:20%">
    <col style="width:15%">
	<col style="width:10%">

  <thead>
    <tr>
      <th><?php echo \Yii::t('app', 'id')?></th>
      <th><?php echo \Yii::t('app', 'name')?></th>
			<th><?php echo '# '. \Yii::t('app', 'canciones')?></th>
      <th><?php echo \Yii::t('app', 'status')?></th>
      <th><?php echo \Yii::t('app', 'albumArt')?></th>
      <th><?php echo \Yii::t('app', 'actions')?></th>
    </tr>
  </thead>
  <tbody data-lazy-component="user-list">
  <?php foreach($albums as $album) { ?>
    <tr>
      <td><?php echo $album->id ?></td>
      <td><a class="inv-link" data-action="nav" href="<?php echo Url::to(['/admin/media/album', 'id' => $album->id] )?>"> <?php echo $album->name ?></a></td>
			<td><?php echo count($album->songs)?></td>
			<td><?php echo $album->status ? 'Activo' : 'Inactivo' ?></td>
      <td><?php echo isset($album->art) ? 'Si' : 'No' ?></td>
      <td class="actions">
          <a data-crud="edit" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'edit')?>" data-action="nav" href="<?php echo Url::to(['/admin/media/edit', 'id' => $album->id])?>">
            <span class="fa-layers fa-fw">
              <i class="fal fa-circle" data-fa-transform="grow-15"></i>
              <i class="far fa-pencil-alt" data-fa-transform="shrink-3"></i>
            </span>
          </a>
		  	<?php if ($album->status == 1) { ?>
          <a data-crud="disable" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'disable')?>" data-action="disable-album" href="<?php echo Url::to(['/admin/media/disable', 'id' => $album->id])?>">
            <span class="fa-layers fa-fw">
              <i class="fal fa-circle" data-fa-transform="grow-15"></i>
			  <i class="far fa-eye-slash" data-fa-transform="shrink-3"></i>
            </span>
          </a>
		  	<?php } else { ?>
          <a data-crud="enable" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'enable')?>" data-action="enable-album" href="<?php echo Url::to(['/admin/media/enable', 'id' => $album->id])?>">
            <span class="fa-layers fa-fw">
              <i class="fal fa-circle" data-fa-transform="grow-15"></i>
			  <i class="far fa-eye" data-fa-transform="shrink-3"></i>
            </span>
          </a>
		  	<?php } ?>
          <a data-crud="remove" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'eliminar')?>" data-action="delete-album" data-title="<?php echo $album->name ?>" href="<?php echo Url::to(['/admin/media/remove', 'id' => $album->id])?>">
            <span class="fa-layers fa-fw">
              <i class="fal fa-circle" data-fa-transform="grow-15"></i>
              <i class="far fa-trash-alt" data-fa-transform="shrink-3"></i>
            </span>
        </a>
      </td>
    </tr>
  <?php }?>
  </tbody>
</table>

<p class="text-center">
<?php if ($lazyLoad['visible']){ ?>
  <a data-action="lazy-load" href="<?php echo $lazyLoad['route'] ?>" class="btn ra-dark-btn" data-lazy-target="user-list">Cargar mas</a>
  <img class="ra-hidden ra-loader-xs" src="<?php echo Url::to(["/img/loader.gif"]) ?>" alt="radioalbum loader">
<?php } ?>
</p>
