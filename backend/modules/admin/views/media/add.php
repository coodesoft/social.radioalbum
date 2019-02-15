<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Channel;
use admin\models\UploadAlbumForm;
use admin\assets\AlbumAsset;
AlbumAsset::register($this);

$arrChannel = array();
$channels = Channel::find()->all();
foreach($channels as $channel){
  $arrChannel[$channel->name] = $channel->name;
}

?>

<div id="albumAdmin" class="panel">
  <div class="panel panel-default">
    <div class="panel-heading text-center"><?php echo \Yii::t('app', 'uploadAlbumArea')?></div>
    <div class="panel-body">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-12 messages text-center"></div>
          </div>

          <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'data-content' => 'file']]) ?>
          <div class="row">
            <div class="col-lg-offset-1 col-lg-2 col-md-3 col-sm-4 col-xs-5 col-xs-offset-3">
              <div class="thumbnail"><img id="albumArt" style="width: 100%" src="<?php echo Url::to(['/img/art-back-1.png'])?>" alt="album art preview"></div>
            </div>
            <div class="col-md-7 col-sm-8 col-xs-12">
              <?php echo $form->field($model, 'image')->fileInput(['multiple' => true, 'accept' => 'image/*', 'class' => 'input-art form-control']) ?>
              <?php echo $form->field($model, 'name')->textInput() ?>
              <?php echo $form->field($model, 'channels')->dropdownList($arrChannel, ['multiple' => 'multiple']) ?>
              
              <div class="row">
              	<div class="col-xs-9">
	          		<?php echo $form->field($model, 'artist')->textInput() ?>
              	</div>
				<div class="col-xs-3">
             		<button type="button" class="btn ra-btn"><i class="fas fa-search"></i> Buscar</button>
				</div>
	          </div>
              <?php echo $form->field($model, 'songs[]')->fileInput(['multiple' => true, 'accept' => 'audio/mpeg', 'class' => 'form-control']) ?>
              <button type ="submit" class="btn ra-btn"><?php echo \Yii::t('app', 'uploadAlbum')?></button>
            </div>
          </div>
          <?php ActiveForm::end() ?>

        </div>
    </div>
  </div>
</div>
