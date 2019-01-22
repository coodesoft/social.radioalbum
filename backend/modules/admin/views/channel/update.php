<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use admin\assets\ChannelAsset;
ChannelAsset::register($this);


?>

<div id="channelAdmin" class="panel">
  <div class="panel panel-default">
    <div class="panel-heading text-center"><?php echo \Yii::t('app', 'editChannel')?></div>
    <div class="panel-body">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-12 messages text-center"></div>
          </div>

          <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'data-content' => 'file']]) ?>
          <div class="row">
            <div class="col-lg-offset-1 col-lg-2 col-md-3 col-sm-4 col-xs-5 col-xs-offset-3">
              <div class="thumbnail">
                <img id="channelArt" style="width: 100%" src="<?php echo $model->art ? Url::to(['/ra/thumbnail', 'id' => $model->art  , 'entity' => 'channel']) : Url::to(["/img/art-back-1.png"]); ?>" alt="album art preview">
              </div>
            </div>
            <div class="col-md-7 col-sm-8 col-xs-12">
              <?php echo $form->field($model, 'id_referencia')->hiddenInput()->label(false) ?>
              <?php echo $form->field($model, 'name')->hiddenInput()->label(false) ?>
              <?php echo $form->field($model, 'name')->textInput(['disabled' => true]) ?>
              <?php echo $form->field($model, 'art')->fileInput(['accept' => 'image/*', 'class' => 'form-control input-art']) ?>
              <?php echo $form->field($model, 'description')->textArea() ?>
              <button type ="submit" class="btn ra-btn"><?php echo \Yii::t('app', 'update')?></button>
            </div>
          </div>
          <?php ActiveForm::end() ?>

        </div>
    </div>
  </div>
</div>
