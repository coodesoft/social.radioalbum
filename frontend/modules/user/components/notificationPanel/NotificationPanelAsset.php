<?php
namespace user\components\notificationPanel;

use yii\web\AssetBundle;

class NotificationPanelAsset extends AssetBundle{


    public $sourcePath = '@user/components/notificationPanel';

    public $js = [
      'js/ra.observer.js',
      'js/widget.js',
    ];

    public $css = [
      'css/notification.css',
    ];

    public $depends = [
      'common\assets\ComponentAsset',
    ];
}
