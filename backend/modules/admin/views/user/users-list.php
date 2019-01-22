<?php
use yii\helpers\Url;
use common\models\Role;
use common\models\User;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

?>

<div class="row">
  <div class="col-md-12 messages text-center"></div>
</div>
<div class="row">
  <div class="col-md-12">
      <a type="button" class="btn ra-btn" href="<?php echo Url::to(['/admin/user/create'])?>" data-action="nav" data-crud="add"><?php echo \Yii::t('app','addUser') ?></a>
      <button id="showSearchBox" class="btn ra-btn"><?php echo \Yii::t('app', 'search') ?></button>
  </div>
</div>

<div class="row">
  <div class="col-md-12 text-center">
    <div class="row">
      <div id="userSearchFormContainer" class="col-md-offset-2 col-md-8 ra-hidden">
        <form action="<?php echo Url::to(['/admin/user/user-search'])?>">
          <table class="table table-bordered table-striped">
            <tr>
              <th><?php echo \Yii::t('app', 'user')?></th>
              <th><?php echo \Yii::t('app', 'role')?></th>
              <th><?php echo \Yii::t('app', 'status')?></th>
              <th><?php echo \Yii::t('app', 'lastAccess')?></th>
            </tr>
            <tr>
              <td>
                <div class="form-group">
                  <input type="text" id="usernameFilter" class="form-control" name="UserSearch[username]" placeholder="<?php echo \Yii::t('app', 'pressEnterToSearch')?>">
                </div>
              </td>
              <td>
                <select class="form-control" name="UserSearch[role]" id="roleFilter">
                  <option value=""><?php echo \Yii::t('app', 'role')?></option>
                  <?php foreach(Role::rolesArray() as $key => $role) {?>
                    <option value="<?php echo $key?>"> <?php echo $role?></option>
                  <?php } ?>
                </select>
              </td>
              <td>
                <select class="form-control" name="UserSearch[status]" id="statusFilter">
                  <option value=""><?php echo \Yii::t('app', 'status')?></option>
                  <?php foreach(User::statusLabelArray() as $key => $status) {?>
                    <option value="<?php echo $key?>"> <?php echo $status?></option>
                  <?php } ?>
                </select>
              </td>
              <td>
                <div class="form-group">
                  <input type="text" id="lastAccessFilter" class="form-control" name="UserSearch[lastAccess]">
                </div>
              </td>
            </tr>
          </table>
        </form>
        <a id="searchUsersLink" href="" data-action="explore" hidden></a>
        <a id="instantSearchUsersLink" href="<?php echo Url::to(['/admin/user/instant-user-search'])?>" data-action="explore" hidden></a>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-md-12 userAdminContent">
    <table id="userList" class="table table-bordered table-striped" >
      <thead>
        <tr>
          <th><?php echo \Yii::t('app', 'id')?></th>
          <th><?php echo \Yii::t('app', 'user')?></th>
          <th><?php echo \Yii::t('app', 'role')?></th>
          <th><?php echo \Yii::t('app', 'status')?></th>
          <th><?php echo \Yii::t('app', 'lastAccess')?></th>
          <th><?php echo \Yii::t('app', 'actions')?></th>
        </tr>
      </thead>
      <tbody data-lazy-component="user-list">
      <?php foreach($users as $user) { ?>
        <tr>
          <td><?php echo $user->id ?></td>
          <td><?php echo $user->username ?></td>
          <td><?php echo $user->role->type ?></td>
          <td><?php echo $user->status ?></td>
          <td><?php echo $date = ($user->access->last_access > 0) ? \Yii::$app->formatter->asDateTime($user->access->last_access, 'long') : \Yii::t('app', 'noAccessRecorded')?></td>
          <td class="actions">
              <a data-crud="read" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'viewDetail')?>" data-action="nav" href="<?php echo Url::to(['/admin/user/read', 'id' => $user->id])?>">
                <span class="fa-layers fa-fw">
                  <i class="fal fa-circle" data-fa-transform="grow-15"></i>
                  <i class="fal fa-address-card" data-fa-transform="shrink-3"></i>
                </span>
              </a>
              <a data-crud="edit" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'edit')?>" data-action="nav" href="<?php echo Url::to(['/admin/user/edit', 'id' => $user->id])?>">
                <span class="fa-layers fa-fw">
                  <i class="fal fa-circle" data-fa-transform="grow-15"></i>
                  <i class="far fa-pencil-alt" data-fa-transform="shrink-3"></i>
                </span>
              </a>
          <?php if ($user->role->id == Role::ARTIST){?>
              <a data-crud="link-profile" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'asocciateWithProfile')?>" data-action="nav" href="<?php echo Url::to(['/admin/user/link-profile', 'id' => $user->id])?>">
                <span class="fa-layers fa-fw">
                  <i class="fal fa-circle" data-fa-transform="grow-15"></i>
                  <i class="far fa-link" data-fa-transform="shrink-3"></i>
                </span>
              </a>
          <?php } ?>
          <?php if ($user->id != 1){ ?>
              <a data-crud="remove" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'eliminar')?>" data-action="modal" href="<?php echo Url::to(['/admin/user/modal', 'id' => $user->id, 'action' => 'remove'])?>">
                <span class="fa-layers fa-fw">
                  <i class="fal fa-circle" data-fa-transform="grow-15"></i>
                  <i class="far fa-trash-alt" data-fa-transform="shrink-3"></i>
                </span>
              </a>
          <?php } ?>
          </td>
        </tr>
      <?php }?>
      </tbody>
    </table>
    <p class="text-center">
    <?php if ($lazyLoad['visible']){ ?>
      <a data-action="lazy-load" href="<?php echo $lazyLoad['route'] ?>" class="btn ra-dark-btn" data-lazy-target="user-list">Cargar mas</a>
      <img class="ra-hidden ra-loader-xs" src="<?php echo Url::to(["/img/loader.gif"]) ?>" alt="radioalbum loader">
    <?php } ?>
    </p>
  </div>
</div>
