<?php
use user\components\notificationPanel\NotificationPanel;
use yii\helpers\Url;
use common\util\StrProcessor;
use user\assets\SocialAsset;
SocialAsset::register($this);

?>
<div class="ra-container">
  <div id="notificationWallTitle">
    <div class="title secondary-title text-center"><?php echo \Yii::t('app', 'yourNotifications')?></div>
  </div>
  <div id="notificationWall" class="<?php echo $notifications ? 'notifications-full' : ''?> ">
    <?php if ($notifications != null) { ?>
    <ul>
        <?php foreach ($notifications as $key => $notification): ?>
          <?php $status = ($notification['status'] == 0) ? 'unreaded' : 'readed' ?>
          <?php $clickeable = (strlen($notification['clickeable'])>0) ? $notification['clickeable'] : ''?>
          <li class="<?php echo $status ." ". $clickeable ?>">
              <div class="sender-thumb">
                <img src="<?php echo Url::to(['/ra/thumbnail', 'id' => $notification['sender_photo'], 'entity' => 'profile']) ?>"  alt="thumb-<?php echo $notification['sender_name']; ?>">
              </div>
              <div class="notifi-message">
                  <div class="paragraph">
                      <div><?php echo $notification['message']?></div>
                      <div class="notifi-time text-left">
                        <i class="far fa-clock"></i>
                          <?php echo StrProcessor::prettyDate(time(), $notification['created_at']) ?>
                      </div>
                  </div>
                  <div class="notifi-action">
                    <a class="<?php echo ($notification['status'] == 0) ?  'hidden' : '' ?>" href="<?php echo Url::to(['/user/social/mark-as-unread', 'id' => $notification['id']])?>" data-action='notification.mark-as-unread'>
                      <i class="far fa-eye-slash"></i>
                    </a>
                    <a class="<?php echo ($notification['status'] == 1) ?  'hidden' : '' ?>" href="<?php echo Url::to(['/user/social/mark-as-read', 'id' => $notification['id']])?>" data-action='notification.mark-as-read'>
                      <i class="far fa-eye"></i>
                    </a>
                </div>
              </div>
              <div class="clearfix"></div>
          </li>
        <?php endforeach; ?>
    </ul>
  <?php } else { ?>
    <div id="noNotificationsBox"><?php echo \Yii::t('app', 'noNotifications')?></div>
  <?php } ?>
  </div>
</div>
