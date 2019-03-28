<?php
use yii\helpers\Url;
use common\util\StrProcessor;
use common\models\Visibility;
use common\models\Gender;

use admin\assets\ArtistAsset;
ArtistAsset::register($this);
?>

<div class="panel panel-default">
  <div class="panel-heading text-center">
    <?php echo $title ?>
    <a data-action="nav" class="btn ra-btn" href="<?php echo Url::to(['/admin/artist/edit', 'id' => $artist->id])?>"><?php echo \Yii::t('app', 'edit')?></a>
  </div>
  <div id="userAdmin" class="panel-body">
    <div class="row">
        <div class="album-view-detail col-md-6 col-sm-12">
            <div class="panel panel-default ra-admin-panel">
              <div class="panel-heading">
                <?php echo \Yii::t('app', 'profileInfo')?>
              </div>

              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'photo') ?> </div>
                <div class="text-center">
                  <img width="300" src="<?php echo Url::to(['/ra/thumbnail', 'id' => $artist->profile->photo, 'entity' => 'profile']); ?>" alt="" />
                </div>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'name') ?> </div>
                <div class="<?php echo isset($artist->profile->name) ? 'view-element' : ''?>"><?php echo isset($artist->profile->name) ? $artist->profile->name : \Yii::t('app', 'noInformation') ?></div>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'lastName') ?> </div>
                <div class="<?php echo isset($artist->profile->last_name) ? 'view-element' : ''?>"><?php echo isset($artist->profile->last_name) ? $artist->profile->last_name : \Yii::t('app', 'noInformation') ?></div>
              </div>

              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'birthDate') ?> </div>
                <div class="<?php echo isset($artist->profile->birth_date) ? 'view-element' : ''?>"><?php echo isset($artist->profile->birth_date) ? $artist->profile->birth_date : \Yii::t('app', 'noInformation') ?></div>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'birthLocation') ?> </div>
                <div class="<?php echo isset($artist->profile->birth_location) ? 'view-element' : ''?>"><?php echo isset($artist->profile->birth_location) ? $artist->profile->birth_location : \Yii::t('app', 'noInformation') ?></div>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'mail') ?> </div>
                <div class="<?php echo isset($artist->profile->mail) ? 'view-element' : ''?>"><?php echo isset($artist->profile->mail) ? $artist->profile->mail : \Yii::t('app', 'noInformation') ?></div>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'phone') ?> </div>
                <div class="<?php echo isset($artist->profile->phone) ? 'view-element' : ''?>"><?php echo isset($artist->profile->phone) ? $artist->profile->phone : \Yii::t('app', 'noInformation') ?></div>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'facebook') ?> </div>
                <div class="<?php echo isset($artist->profile->facebook) ? 'view-element' : ''?>"><?php echo isset($artist->profile->facebook) ? $artist->profile->facebook : \Yii::t('app', 'noInformation') ?></div>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'twitter') ?> </div>
                <div class="<?php echo isset($artist->profile->twitter) ? 'view-element' : ''?>"><?php echo isset($artist->profile->twitter) ? $artist->profile->twitter : \Yii::t('app', 'noInformation') ?></div>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'visibility') ?> </div>
                <div class="<?php echo isset($artist->profile->visibility) ? 'view-element' : ''?>"><?php echo Visibility::getPrettyVisibilty($artist->profile->visibility) ?></div>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'gender') ?> </div>
                <div class="<?php echo isset($artist->profile->gender_id) ? 'view-element' : ''?>">
                  <?php
                    if ( isset($artist->profile->gender_id) )
                      $gender = ($artist->profile->gender_id == Gender::CUSTOM) ? ucfirst(strtolower($artist->profile->gender_desc)) : Gender::getPrettyGender($artist->profile->gender_id);
                    else
                      $gender = \Yii::t('app', 'noInformation');

                    echo $gender;
                  ?>
                </div>
              </div>
              <div class="view-element-wrapper">
                <div class="title view-title-label"> <?php echo \Yii::t('app', 'profileListed') ?> </div>
                <div class="<?php echo isset($artist->profile->listed) ? 'view-element' : ''?>"><?php echo isset($artist->profile->listed) ? ( $artist->profile->listed ? 'Si' : 'No') : \Yii::t('app', 'noInformation') ?></div>
              </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">

          <div class="panel panel-default ra-admin-panel">
            <div class="panel-heading"><?php echo \Yii::t('app', 'artisticInfo')?></div>
            <div class="view-element-wrapper">
              <div class="title view-title-label"><?php echo \Yii::t('app', 'name') ?> </div>
              <div class="view-element"><?php echo $artist->name ?></div>
            </div>
            <div class="view-element-wrapper">
              <div class="title view-title-label"><?php echo \Yii::t('app', 'presentation') ?> </div>
              <div class="<?php echo isset($artist->presentation) ? 'view-element' : ''?>"><?php echo isset($artist->presentation) ? $artist->presentation : \Yii::t('app', 'noInformation') ?></div>
            </div>
            <div class="view-element-wrapper">
              <div class="title view-title-label"><?php echo \Yii::t('app', 'instruments') ?> </div>
              <div class="<?php echo isset($artist->instrument) ? 'view-element' : ''?>"><?php echo isset($artist->instrument) ? $artist->instrument : \Yii::t('app', 'noInformation') ?></div>
            </div>
            <div class="view-element-wrapper">
              <div class="title view-title-label"><?php echo \Yii::t('app', 'year') ?> </div>
              <div class="<?php echo isset($artist->begin_date) ? 'view-element' : ''?>"><?php echo isset($artist->begin_date) ? $artist->begin_date : \Yii::t('app', 'noInformation') ?></div>
            </div>
            <div class="view-element-wrapper">
              <div class="title view-title-label"><?php echo \Yii::t('app', 'albumes') ?> </div>
              <table class="table table-striped">
                  <tr>
                    <th>Nombre</th>
                    <th class="text-center"># Canciones</th>
                  </tr>
                  <?php foreach($artist->albums as $key => $album) {?>
                  <tr>
                    <td><?php echo $album->name?></td>
                    <td class="text-center"><?php echo count($album->songs) ?></td>
                  </tr>
                  <?php } ?>
              </table>
            </div>
          </div>

        </div>
    </div>
</div>
