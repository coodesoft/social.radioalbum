<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Channel;

use admin\modules\tagEditor\assets\TagEditorAsset;
TagEditorAsset::register($this);

$arrChannel = array();
$channels = Channel::find()->all();
foreach($channels as $channel){
  $arrChannel[$channel->name] = $channel->name;
}
?>
  <div class="panel panel-default">
    <div class="panel-heading text-center"><?php echo \Yii::t('app', 'tagEditorArea')?></div>
    <div class="panel-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 messages text-center"></div>
          </div>

          <?php $form = ActiveForm::begin(['action' => ['/admin/tagEditor/nav/edit']]) ?>
          <div class="row">
            <div class="col-lg-offset-2 col-lg-8 col-xs-12">
              <?php echo $form->field($model, 'name')->textInput() ?>
              <?php echo $form->field($model, 'channel')->dropdownList($arrChannel) ?>
              <?php echo $form->field($model, 'artist')->textInput() ?>
              <?php echo $form->field($model, 'album')->textInput() ?>
              <input id="songPath" type="hidden" name="SongFile[path]" value="">
              <div class="text-center">
                <button type="button" class="btn ra-btn" id="returnToLastLocation"><?php echo \Yii::t('app', 'cancel')?></button>
                <button type ="submit" class="btn ra-btn"><?php echo \Yii::t('app', 'editTags')?></button>
              </div>
            </div>
          </div>
          <?php ActiveForm::end() ?>

        </div>
    </div>
  </div>
