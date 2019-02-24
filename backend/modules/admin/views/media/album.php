<?php
use yii\helpers\Url;
use common\util\StrProcessor;

use admin\assets\AdminAsset;
AdminAsset::register($this);
?>

<div class="panel panel-default">
  <div class="panel-heading text-center"><?php  ?></div>
  <div id="userAdmin" class="panel-body">
      <div class="row">
      <div class="album-view-detail col-md-6 col-sm-12">
  			<div class="col-md-12">
  				<img width="300" src="<?php echo Url::to(['/ra/thumbnail', 'id' => $album->art, 'entity' => 'album']); ?>" alt="" />
  			</div>
  			<div class="view-element-wrapper col-md-12">
  				<div class="title view-title-label"><?php echo \Yii::t('app', 'name') ?> </div>
  				<div class="title view-element"><?php echo $album->name ?></div>
  			</div>
  			<div class="view-element-wrapper col-md-12">
  				<div class="title view-title-label"><?php echo \Yii::t('app', 'year') ?> </div>
  				<div class="<?php echo isset($album->year) ? 'view-element' : ''?>"><?php echo isset($album->year) ? $album->year : \Yii::t('app', 'noYear') ?></div>
  			</div>
  			<div class="view-element-wrapper col-md-12">
  				<div class="title view-title-label"><?php echo \Yii::t('app', 'status') ?> </div>
  				<div class="view-element"><?php echo $album->status ? \Yii::t('app', 'enabled') : \Yii::t('app', 'disabled') ?></div>
  			</div>
  			<div class="view-element-wrapper col-md-12">
  				<div class="title view-title-label"><?php echo \Yii::t('app', 'description') ?> </div>
  				<div ><?php echo strlen($album->description)>0 ? $album->description : \Yii::t('app', 'noDescription') ?></div>
  			</div>
      </div>
      <div class="col-md-6 col-sm-12 tracksList">
			<div class="col-sm-12 title text-center"><?php echo \Yii::t('app', 'tracksList')?></div>
			<table class="table table-striped">
				<?php foreach($album->songs as $key => $song) {?>
				<tr>
					<td><?php echo $key+1 .' - '. $song->name?></td>
					<td><?php echo StrProcessor::secondsToMinutes($song->time) ?></td>
				</tr>
				<?php } ?>
			</table>
        </div>
      </div>
  </div>
</div>
