<?php
use yii\helpers\Url;
use common\util\StrProcessor;
use common\models\Visibility;
use common\models\Gender;
use yii\widgets\ActiveForm;

use admin\assets\ArtistAsset;
ArtistAsset::register($this);
?>

<div class="panel panel-default">
  <div class="panel-heading text-center">
    <?php echo $title ?>
  </div>
  <div id="artistAdmin" class="panel-body">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'data-content' => 'file']]) ?>

    <div class="row">
        <div class="album-view-detail col-md-6 col-sm-12">
            <div class="panel panel-default ra-admin-panel">
              <div class="panel-heading">
                <?php echo \Yii::t('app', 'profileInfo')?>
              </div>

              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'photo') ?> </div>
                <div class="text-center">
                  <img id="artistArt" width="300" src="<?php echo Url::to(['/ra/thumbnail', 'id' => $profile->photo, 'entity' => 'profile']); ?>" alt="" />
                  <?php echo $form->field($model, 'art')->fileInput(['multiple' => true, 'accept' => 'image/*', 'class' => 'input-art form-control'])->label(false) ?>
                </div>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'name') ?> </div>
                <?php echo $form->field($profile, 'name')->textInput()->label(false) ?>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'lastName') ?> </div>
                <?php echo $form->field($profile, 'last_name')->textInput()->label(false) ?>
              </div>

              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'birthDate') ?> </div>
                <?php echo $form->field($profile, 'birth_date')->textInput()->label(false) ?>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'birthLocation') ?> </div>
                <?php echo $form->field($profile, 'birth_location')->textInput()->label(false) ?>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'mail') ?> </div>
                <?php echo $form->field($profile, 'mail')->textInput()->label(false) ?>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'phone') ?> </div>
                <?php echo $form->field($profile, 'phone')->textInput()->label(false) ?>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'facebook') ?> </div>
                <?php echo $form->field($profile, 'facebook')->textInput()->label(false) ?>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'twitter') ?> </div>
                <?php echo $form->field($profile, 'twitter')->textInput()->label(false) ?>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'visibility') ?> </div>
                <?php echo $form->field($profile, 'visibility')->dropdownList($visibilities)->label(false) ?>
               </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'gender') ?> </div>
                <?php echo $form->field($profile, 'gender_id')->dropdownList($genders)->label(false) ?>
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'gender_desc') ?> </div>
                <?php echo $form->field($profile, 'gender_desc')->textInput()->label(false) ?>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'profileListed') ?> </div>
                <?php echo $form->field($profile, 'listed')->dropdownList($arrListed)->label(false) ?>
              </div>

            </div>
        </div>
        <div class="col-md-6 col-sm-12">

          <div class="panel panel-default ra-admin-panel">
            <div class="panel-heading"><?php echo \Yii::t('app', 'artisticInfo')?></div>
            <div class="view-element-wrapper">
              <div class="title view-title-label"><?php echo \Yii::t('app', 'name') ?> </div>
              <?php echo $form->field($artist, 'name')->textInput()->label(false) ?>
            </div>
            <div class="view-element-wrapper">
              <div class="title view-title-label"><?php echo \Yii::t('app', 'presentation') ?> </div>
              <?php echo $form->field($artist, 'presentation')->textArea()->label(false) ?>
            </div>
            <div class="view-element-wrapper">
              <div class="title view-title-label"><?php echo \Yii::t('app', 'instrument') ?> </div>
              <?php echo $form->field($artist, 'instrument')->textInput()->label(false) ?>
            </div>
            <div class="view-element-wrapper">
              <div class="title view-title-label"><?php echo \Yii::t('app', 'year') ?> </div>
              <?php echo $form->field($artist, 'begin_date')->textInput()->label(false) ?>
            </div>
            <div class="view-element-wrapper">
              <div class="title view-title-label"><?php echo \Yii::t('app', 'albumes') ?> </div>
              <?php if ( count($artist->albums) ){ ?>
                <table class="table table-striped">
                    <tr>
                      <th>Nombre</th>
                      <th class="text-center"># Canciones</th>
                    </tr>
                    <?php foreach($artist->albums as $key => $album) {?>
                    <tr>
                      <td><a class="inv-link" data-action="nav" href="<?php echo Url::to(['/admin/media/album', 'id' => $album->id] )?>"> <?php echo $album->name ?></a></td>
                      <td class="text-center"><?php echo count($album->songs) ?></td>
                    </tr>
                    <?php } ?>
                </table>
              <?php } else{ ?>
                <div class="view-element-wrapper">
                  <div><?php echo \Yii::t('app', 'noAlbumDisp') ?></div>
                </div>
              <?php } ?>
            </div>
          </div>

        </div>
        <div class="col-xs-12 text-center">
          <button type="submit" class="btn ra-btn"><?php echo \Yii::t('app', 'edit')?></button>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12 messages text-center"></div>
    </div>
    <?php echo $form->field($artist, 'id')->hiddenInput()->label(false) ?>

    <?php ActiveForm::end() ?>

</div>
