<?php
use yii\helpers\Url;
use admin\assets\AdminAsset;
AdminAsset::register($this);
?>

<div class="panel panel-default">
  <div class="panel-heading text-center"><?php  ?></div>
  <div id="userAdmin" class="panel-body">
      <div class="row">
        <div class="col-md-6 col-sm-12">
			<div class="col-md-12">
				<img width="300" src="<?php echo Url::to(['/ra/thumbnail', 'id' => $album->art, 'entity' => 'album']); ?>" alt="" />
			</div>
			<div class="col-md-12">
				<div class="panel-body title secondary-title"><?php echo $album->name ?></div>
			</div>
			<div class="col-md-12">
				<div class="panel-body"><?php echo strlen($album->description)>0 ? $album->description : \Yii::t('app', 'noDescription') ?></div>
			</div>
			<div class="col-md-12">
				<div class="panel-body"><?php echo isset($album->year)>0 ? $album->year : \Yii::t('app', 'noYear') ?></div>
			</div>
			<div class="col-md-12"></div>
        </div>
        <div class="col-md-6 col-sm-12">
        </div>
      </div>
  </div>
</div>
