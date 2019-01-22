<?php
namespace admin\modules\tagEditor;


use admin\modules\tagEditor\services\TagEditorService;
use admin\modules\tagEditor\util\DirNavigator;

class Module extends \yii\base\Module {

	public function init(){
		parent::init();


		$this->set('dirNavigator', new DirNavigator);
		$this->set('tagEditor', new TagEditorService);
	}

	public function run() {
	}

}
?>
