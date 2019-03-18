<?php
use yii\helpers\Url;
use common\util\StrProcessor;
use yii\widgets\ActiveForm;


use admin\assets\EditAlbumAsset;
EditAlbumAsset::register($this);


?>


<div id="albumAdminEdit" class="panel">
  <div class="panel panel-default">
    <div class="panel-heading text-center"><?php echo \Yii::t('app', 'editAlbum')?></div>
    <div class="panel-body">
        <div class="container-fluid">

          <div class="row">

            <div class="album-view-detail col-xs-12 col-md-6">
              <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'data-content' => 'file']]) ?>
              <div class="view-element-wrapper col-md-12">
                <div class="col-md-4 col-sm-12">
                  <img id="albumArt" style="width: 100%" src="<?php echo Url::to(['/ra/thumbnail', 'entity' => 'album', 'id' => $album->art])?>" alt="album art preview">
                </div>
                <?php echo $form->field($model, 'image')->fileInput(['multiple' => true, 'accept' => 'image/*', 'class' => 'input-art form-control'])->label(false) ?>
              </div>
              <div class="view-element-wrapper col-md-12">
                <div class="title view-title-label"><?php echo \Yii::t('app', 'name') ?> </div>
                <?php echo $form->field($model, 'name')->textInput()->label(false) ?>
              </div>
              <div class="view-element-wrapper col-md-12">
        				<div class="title view-title-label"><?php echo \Yii::t('app', 'year') ?> </div>
                <?php echo $form->field($model, 'year')->textInput()->label(false) ?>
        			</div>
              <div class="view-element-wrapper col-md-12">
        				<div class="title view-title-label"><?php echo \Yii::t('app', 'canales') ?> </div>
                <?php echo $form->field($model, 'channels')->dropdownList($arrChannel, ['multiple' => 'multiple'])->label(false) ?>
        			</div>
        			<div class="view-element-wrapper col-md-12">
        				<div class="title view-title-label"><?php echo \Yii::t('app', 'description') ?> </div>
                <?php echo $form->field($model, 'description')->textArea()->label(false) ?>
        			</div>
              <div class="view-element-wrapper col-md-12">
        				<div class="title view-title-label"><?php echo \Yii::t('app', 'status') ?> </div>
        				<div class="view-element"><?php echo $album->status ? \Yii::t('app', 'enabled') : \Yii::t('app', 'disabled') ?></div>
                <?php echo $form->field($model, 'status')->radioList([
                    0 => \Yii::t('app', 'disabled'),
                    1 => \Yii::t('app', 'enabled'),
                  ])->label(false); ?>
        			</div>
              <div class="col-xs-12 text-center">
                <button type="submit" class="btn ra-btn"><?php echo \Yii::t('app', 'edit')?></button>
              </div>
              <?php echo $form->field($model, 'id')->hiddenInput()->label(false) ?>
              <?php ActiveForm::end() ?>
              <div class="col-md-12 messages text-center"></div>

            </div>

            <div class="col-xs-12 col-md-6">
              <div class="panel panel-default text-center">
                <div class="panel-heading text-center"><?php echo \Yii::t('app', 'tracksList')?></div>
                <div class="panel-body">
                  <a class="btn ra-btn" data-action="nav" href="<?php echo Url::to(['/admin/media/edit-songs', 'id' => $album->id])?>"><?php echo \Yii::t('app', 'editSongs')?></a>
                </div>
              </div>
            </div>

          </div>
        </div>
    </div>
  </div>
</div>
