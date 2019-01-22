<?php

use yii\helpers\Url;

use user\components\notificationPanel\NotificationPanelAsset;
NotificationPanelAsset::register($this);

?>

<div id="notificationContainer" class="notification-hide">

    <div class="notifications-header col-sm-12">
      <div class="title third-title text-center"><?php echo \Yii::t('app', 'notifications') ?></div>
    </div>

    <div class="notifications-list col-sm-12">
      <ul class="notifications-body">
      </ul>
    </div>

    <div class="notifications-footer col-sm-12">

      <div class="paragraph text-right clickeable">
        <div class="mark-all-read">
          | <a href="<?php echo Url::to(['/user/social/mark-all-read']) ?>" data-action="social.mark-all-read"><?php echo \Yii::t('app', 'markAllAsRead') ?></a>
        </div>
        <div class="watchAll">
          <a href="<?php echo Url::to(['/user/social/notifications']) ?>" data-action="nav"><?php echo \Yii::t('app', 'watchAll') ?></a>
        </div>
      </div>
    </div>

</div>
