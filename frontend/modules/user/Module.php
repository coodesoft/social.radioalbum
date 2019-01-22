<?php
namespace user;

use user\services\SocialService;
use user\services\NotificationService;

class Module extends \yii\base\Module {

	public function init(){
		parent::init();
		$this->set('socialService', new SocialService);
		$this->set('notificationService', new NotificationService);
	}

	public function run() {

  }

}
?>
