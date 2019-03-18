<?php
use yii\helpers\Url;
use admin\assets\ChannelAsset;
ChannelAsset::register($this);
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
      <th><?php echo \Yii::t('app', 'channelArt')?></th>
			<th><?php echo '#'. \Yii::t('app', 'albumes')?></th>
      <th><?php echo \Yii::t('app', 'actions')?></th>
    </tr>
  </thead>
  <tbody data-lazy-component="user-list">
  <?php foreach($channels as $channel) { ?>
    <tr>
      <td><?php echo $channel->id ?></td>
      <td><a class="inv-link" data-action="nav" href="<?php echo Url::to(['/admin/channel/view', 'id' => $channel->id] )?>"> <?php echo $channel->name ?></a></td>
      <td><?php echo isset($channel->art) ? 'Si' : 'No' ?></td>
			<td><?php echo count($channel->albums) ?></td>
      <td class="actions">
          <a data-crud="edit" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'edit')?>" data-action="nav" href="<?php echo Url::to(['/admin/channel/edit', 'id' => $channel->id])?>">
            <span class="fa-layers fa-fw">
              <i class="fal fa-circle" data-fa-transform="grow-15"></i>
              <i class="far fa-pencil-alt" data-fa-transform="shrink-3"></i>
            </span>
          </a>
          <a data-crud="remove" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'eliminar')?>" data-action="delete-channel" data-title="<?php echo $channel->name ?>" href="<?php echo Url::to(['/admin/channel/remove', 'id' => $channel->id])?>">
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
