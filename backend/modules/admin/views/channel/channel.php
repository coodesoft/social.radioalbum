<?php
use common\widgets\gridView\GridView;
use yii\helpers\Url;
use admin\assets\ChannelAsset;
ChannelAsset::register($this);
?>

<div class="panel panel-default">
  <div class="panel-heading text-center"><?php  ?></div>

  <div id="userAdmin" class="panel-body">
      <div class="row">
      <div class="album-view-detail col-md-6 col-sm-12">
  			<div class="col-md-12">
  				<img width="300" src="<?php echo Url::to(['/ra/thumbnail', 'id' => $channel->art, 'entity' => 'channel']); ?>" alt="" />
  			</div>
  			<div class="view-element-wrapper col-md-12">
  				<div class="title view-title-label"><?php echo \Yii::t('app', 'name') ?> </div>
  				<div class="title view-element"><?php echo $channel->name ?></div>
  			</div>
  			<div class="view-element-wrapper col-md-12">
  				<div class="title view-title-label"><?php echo \Yii::t('app', 'description') ?> </div>
  				<div ><?php echo strlen($channel->description)>0 ? $channel->description : \Yii::t('app', 'noDescription') ?></div>
  			</div>
      </div>
      <div class="col-md-6 col-sm-12 tracksList">
			<div class="col-sm-12 title text-center"><?php echo \Yii::t('app', 'albumes')?></div>
			<table class="table table-striped">
				<?php foreach($channel->albums as $key => $album) {?>
				<tr>
          <td><a class="inv-link" data-action="nav" href="<?php echo Url::to(['/admin/media/album', 'id' => $album->id] )?>">
             <?php echo $key+1 .' - '.$album->name ?>
           </a></td>
				</tr>
				<?php } ?>
			</table>
        </div>
      </div>
  </div>
</div>
