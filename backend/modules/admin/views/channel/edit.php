<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Channel;
use admin\models\UploadAlbumForm;

use admin\assets\ChannelAsset;
ChannelAsset::register($this);


?>

<div id="channelAdmin" class="panel">
  <div class="panel panel-default">
    <div class="panel-heading text-center"><?php echo \Yii::t('app', 'editChannelArea')?></div>
    <div class="panel-body">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-12 messages text-center"></div>
          </div>

          <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'data-content' => 'file']]) ?>
          <div class="row">
            <div class="col-xs-12">
              <div class="thumbnail col-sm-4">
                <img id="channelArt" style="width: 100%" src="<?php echo Url::to(['/ra/thumbnail', 'entity' => 'channel', 'id' => $model->art_name])?>" alt="channel art preview">
              </div>
            <div class="col-md-7 col-sm-8 col-xs-12">
              <?php echo $form->field($model, 'id')->hiddenInput()->label(false)?>
              <?php echo $form->field($model, 'delete_art')->checkbox()?>
              <?php echo $form->field($model, 'art')->fileInput(['multiple' => true, 'accept' => 'image/*', 'class' => 'input-art form-control']) ?>
              <?php echo $form->field($model, 'name')->textInput() ?>
              <?php echo $form->field($model, 'description')->textArea() ?>
              <button type ="submit" class="btn ra-btn"><?php echo \Yii::t('app', 'editChannel')?></button>
            </div>
          </div>
          <?php ActiveForm::end() ?>

        </div>
    </div>
  </div>
</div>
