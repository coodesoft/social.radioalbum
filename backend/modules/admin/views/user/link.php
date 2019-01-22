<?php
use yii\helpers\Url;
use yii\helpers\Html;

$searchAction = Url::to(['/admin/user/search-profile']);
$submitAction = Url::to(['/admin/user/link-profile']);
?>

<div class="row">
  <div class="col-md-12 messages text-center"></div>
</div>
<div class="row">
  <div class="container-fluid">
    <div id="linkProfileForm" class="col-md-6">
      <form  id="searchUserForm" action="<?php echo $searchAction?>" method="post">
        <div class="form-group">
          <label for="inputUsername"><?php echo \Yii::t('app', 'user') ?></label>
          <input type="text" name="" class="form-control" id="inputUsername" value="<?php echo $user->username ?>" disabled>
        </div>
        <div id="inputSearchWrapper" class="form-group">
          <label for="inputArtistSearch"></label>
          <input type="text" name="Query[subject]" class="form-control" id="inputArtistSearch" placeholder="Nombre del artista">
        </div>
        <div id="submitLinkWrapper" class="form-group text-center">
            <?= Html::submitButton( Yii::t('app', 'search'), ['class' =>  'btn ra-btn']) ?>
        </div>
      </form>
      <form id="linkUserForm" action="<?php echo $submitAction?>" method="post">
        <input type="hidden" name="Link[user_id]" value="<?php echo $user->id ?>">
        <input type="hidden" name="Link[model_id]" value="">
        <div id="submitLinkWrapper" class="form-group text-center">
            <?= Html::submitButton( Yii::t('app', 'asocciateWithProfile'), ['class' =>  'btn ra-btn']) ?>
        </div>
      </form>
    </div>
    <div id="searchResponse" class="col-md-6">
        <label><?php echo \Yii::t('app', 'assocProfile') ?></label>
        <div class="panel panel-default">
          <div class="panel-body artist-search">
            <?php
              $profile = ($user->getAssociatedModel());
              echo $name = ($profile) ? $profile->name : \Yii::t('app', 'noAssocProfile') ?>
          </div>
        </div>
    </div>
  </div>
</div>
