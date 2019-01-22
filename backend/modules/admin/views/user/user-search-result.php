<?php
use yii\helpers\Url;
use common\models\Role;
use common\models\User;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

?>

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
            <div class="action-min action-read">
              <a data-crud="read" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'viewDetail')?>" data-action="nav" href="<?php echo Url::to(['/admin/user/read', 'id' => $user->id])?>"></a>
            </div>
            <div class="action-min action-edit">
              <a data-crud="edit" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'editar')?>" data-action="nav" href="<?php echo Url::to(['/admin/user/edit', 'id' => $user->id])?>"></a>
            </div>
          <?php if ($user->role->id == Role::ARTIST){?>
            <div class="action-min action-link">
              <a data-crud="link-profile" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'asocciateWithProfile')?>" data-action="nav" href="<?php echo Url::to(['/admin/user/link-profile', 'id' => $user->id])?>"></a>
            </div>
          <?php } ?>
          <?php if ($user->id != 1){ ?>
            <div class="action-min action-remove">
              <a data-crud="remove" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'eliminar')?>" data-action="modal" href="<?php echo Url::to(['/admin/user/modal', 'id' => $user->id, 'action' => 'remove'])?>"></a>
            </div>
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
