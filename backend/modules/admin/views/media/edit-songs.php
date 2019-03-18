<?php
use yii\helpers\Url;
use common\util\StrProcessor;
use yii\widgets\ActiveForm;

use admin\assets\EditAlbumAsset;
EditAlbumAsset::register($this);

?>
<div id="albumAdminEdit" class="panel">
  <div class="panel panel-default">
      <div class="panel-heading text-center"><?php echo \Yii::t('app', 'editAlbum')?>: <?php echo $albumTitle?></div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12 messages text-center"></div>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'data-content' => 'file']]) ?>
        <div class="row">
          <div class="col-xs-12">
            <?php echo $form->field($model, 'songs[]')->fileInput(['multiple' => true, 'accept' => 'audio/mpeg', 'class' => 'form-control']) ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 tracksList">
            <div class="col-sm-12 title text-center"><?php echo \Yii::t('app', 'tracksList')?></div>
      			<table class="table table-striped">
              <tr>
                <th class="text-center"><?php echo \Yii::t('app', 'song')?></th>
                <th class="text-center"><?php echo \Yii::t('app', 'delete')?></th>
              </tr>
      				<?php foreach($songs as $key => $song) {?>
      				<tr>
                <td><input class="col-xs-12" type="text" name="EditAlbumSongsForm[songsToEdit][<?php echo $song->id?>]" value="<?php echo $song->name?>"></td>
                <td class="text-center"><input type="checkbox" name="EditAlbumSongsForm[songsToDelete][<?php echo $song->id?>]"></td>
      				</tr>
      				<?php } ?>
      			</table>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <button type="submit" class="btn ra-btn"><?php echo \Yii::t('app', 'edit')?></button>
          </div>
        </div>
        <?php echo $form->field($model, 'id')->hiddenInput()->label(false) ?>
        <?php ActiveForm::end() ?>
      </div>
  </div>
</div>
