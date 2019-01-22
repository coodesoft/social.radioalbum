<?php
use user\components\notificationPanel\NotificationPanel;

echo NotificationPanel::widget(['content' => $notifications, 'lazy' => true]);
?>
