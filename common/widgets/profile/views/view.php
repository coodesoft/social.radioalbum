<?php
use common\widgets\profile\ProfileAsset;
use common\widgets\gridView\GridView;
use frontend\models\Gender;
use frontend\modules\artist\models\Artist;

use yii\helpers\Url;
use yii\helpers\Html;
ProfileAsset::register($this);


$options = $user->profile->options;
$albums = array();

?>

<div id="profileArea" class="ra-container">

  <?php if ($mobile) { ?>
  <div id="profileAreaSelector" class="col-sm-12">
    <div class="profile-selector col-sm-6" data-target="#profileInfo"><?php echo \Yii::t('app', 'profile') ?> </div>
    <div class="profile-selector col-sm-6" data-target="#profileProduction"><?php echo \Yii::t('app', 'activity') ?> </div>
  </div>
  <?php } ?>

  <div id="profileInfo" class="col-lg-6 col-md-6 col-xs-12 target-selector <?php echo $mobile ? 'profile-info-mobile' : '' ?>">

    <div class="profile-header col-lg-12 col-md-12 col-sm-12">
      <div class="thumbnail col-lg-4 col-xs-5">
        <img src="<?php echo Url::to(['/ra/thumbnail', 'id' => $user->profile->photo, 'entity' => 'profile']);  ?>"  alt="thumb-<?php echo $user->name; ?>">
      </div>
      <div class="title-wrapper col-lg-8 col-xs-7 col-lg-offset-4 col-xs-offset-5">
        <div class="main-action">
          <a class="btn ra-btn" href="<?php echo $action['url'] ?>" data-action="<?php echo $action['type']?>">
            <i class="fas fa-<?php echo $action['icon']?>"></i>
            <span><?php echo $action['title'] ?></span>
          </a>
        </div>
        <div class="title">
            <div class="title-text">
              <?php echo $user->name ?>
            </div>
        </div>
        <div class="horizontal-separator"></div>
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="profile-body col-md-12">

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo \Yii::t('app', 'personalInfo') ?></h3>
        </div>
        <ul class="list-group">

          <?php if (isset($options->full_name) && ($options->full_name)){ ?>
          <li class="list-group-item">
                <div class="information">
                  <div class="title"><?php echo \Yii::t('app','fullName') ?></div>
                  <div class="paragraph"><?php echo $user->profile->name . " ". $user->profile->last_name ?></div>
                </div>
          </li>
          <?php }?>

          <?php if (isset($options->birth_date) && ($options->birth_date)){ ?>
          <li class="list-group-item">
              <div class="information">
                  <div class="title"><?php echo \Yii::t('app','birthDate') ?></div>
                  <div class="paragraph"><?php echo date('d/m/Y', $user->profile->birth_date) ?></div>
              </div>
          </li>
          <?php }?>

          <?php if (isset($options->birth_location) && ($options->birth_location)){ ?>
          <li class="list-group-item">
              <div class="information">
                  <div class="title"><?php echo \Yii::t('app','birthLocation')?></div>
                  <div class="paragraph"><?php echo $user->profile->birth_location ?></div>
              </div>
          </li>
          <?php }?>

          <?php if (isset($options->phone) && ($options->phone)){ ?>
          <li class="list-group-item">
              <div class="information">
                  <div class="title"><?php echo \Yii::t('app','phone')?></div>
                  <div class="paragraph"><?php echo $user->profile->phone ?></div>
              </div>
          </li>
          <?php }?>

          <?php if (isset($options->gender) && ($options->gender)){ ?>
          <li class="list-group-item">
              <div class="information">
                  <div class="title"><?php echo \Yii::t('app','gender')?></div>
                  <?php $gender = ($user->profile->gender_id == Gender::CUSTOM) ? $user->profile->gender_desc : (($user->profile->gender_id == Gender::MALE) ? \Yii::t('app', 'male') : \Yii::t('app', 'female')); ?>
                  <div class="paragraph"><?php echo $gender ?></div>
              </div>
          </li>
          <?php }?>

          <?php if (isset($options->presentation) && ($options->presentation)){ ?>
          <li class="list-group-item">
              <div class="information">
                  <div class="title"><?php echo \Yii::t('app','presentation')?></div>
                  <div class="paragraph text-justify"><?php echo $user->presentation ?></div>
              </div>
          </li>
          <?php }?>
        </ul>
      </div>

      <div class="clearfix"></div>
      <?php if (isset($options->social) && ($options->social)){ ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo \Yii::t('app', 'socialInfo') ?></h3>
          </div>
          <ul class="list-group">
            <li class="list-group-item">
              <div class="information social">
                <div class="title"><?php echo \Yii::t('app', 'socialNetworks') ?></div>
                <?php if (isset($user->profile->facebook) && $user->profile->facebook){ ?>
                <div class="paragraph">
                  <a class="facebook" href="https://www.facebook.com/<?php echo $user->profile->facebook ?>" target="_blank">
                    <i class="fab fa-facebook fa-2x"></i>
                  </a>
                </div>
                <div class="paragraph">
                  <a class="twitter" href="https://www.twitter.com/<?php echo $user->profile->twitter ?>" target="_blank">
                    <i class="fab fa-twitter fa-2x"></i>
                  </a>
                </div>
              <?php } ?>
              </div>
            </li>
            <li class="list-group-item">
              <div class="information">
                <div class="title"><?php echo \Yii::t('app', 'followedUsers') ?></div>
                <div class="paragraph">
                  <?php echo $relationships['followedUsers'] ?>
                </div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="information">
                <div class="title"><?php echo \Yii::t('app', 'followers') ?></div>
                <div class="paragraph"><?php echo $relationships['followers'] ?></div>
              </div>
            </li>
          </ul>
        </div>
      <?php }?>

      <?php if ($user->className() == Artist::className() && ($options->begin_date || $options->instrument)){  ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo \Yii::t('app', 'artisticInfo') ?></h3>
          </div>
          <div class="panel-body">
          </div>
          <ul class="list-group">
            <?php if (isset($options->begin_date) && ($options->begin_date) && isset($user->begin_date)){ ?>
              <li class="list-group-item information">
                <div class="title"><?php echo \Yii::t('app','beginDate') ?> </div>
                <div class="paragraph"><?php echo date('m/d/Y', $user->begin_date) ?></div>
              </li>
            <?php }?>
            <?php if (isset($options->instrument) && ($options->instrument)){ ?>
              <li class="list-group-item information">
                <div class="title"><?php echo \Yii::t('app','instrumentos') ?></div>
                <div class="paragraph"><?php echo $user->instrument ?></div>
              </li>
            <?php }?>
          </ul>
        </div>
      <?php } ?>

    </div>
  </div>

  <div id="profileProduction" class="col-lg-6 col-md-6 col-xs-12 target-selector <?php echo $mobile ? 'ra-hidden' : '' ?>">
    <div class="production-header">
      <ul>
        <?php foreach($sections as $i => $section) { ?>
          <?php $active = ($i=='posts') ? 'active' : ''; ?>
          <li class="tab-item <?php echo $active?>" data-source="<?php echo $section['uri']?>"><?php echo $section['label']?></li>
        <?php } ?>
      </ul>
    </div>
    <div class="profile-body">
        <div class="profile-content ra-block" id="<?php echo $sections['posts']['uri']?>">
          <?php echo $posts = isset($productions['posts']) ? $productions['posts'] : ''; ?>
        </div>

        <?php if (isset($sections['albums'])) {?>
            <div class="production-content ra-hidden" id="<?php echo $sections['albums']['uri']?>">
              <div class="col-sm-12">
                <?php echo $albums = isset($productions['albums']) ? $productions['albums'] : '';  ?>
              </div>
            </div>
        <?php }?>

    </div>
  </div>

  <div class="clearfix"></div>
</div>
