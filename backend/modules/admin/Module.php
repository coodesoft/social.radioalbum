<?php
namespace admin;

use Yii;

use admin\services\AlbumService;
use admin\services\ArtistService;
use admin\services\SongService;
use admin\services\crud\ChannelCrudService;
use admin\services\crud\AlbumCrudService;
use admin\services\crud\ArtistCrudService;
use admin\services\crud\SongCrudService;
use admin\services\crud\UserCrudService;

class Module extends \yii\base\Module {

	public function init(){
		parent::init();
		$this->set('albumService', new AlbumService);
		$this->set('artistService', new ArtistService);
		$this->set('songService', new SongService);

		$this->set('crudArtist', new ArtistCrudService);
		$this->set('crudAlbum', new AlbumCrudService);
		$this->set('crudChannel', new ChannelCrudService);
		$this->set('crudSong', new SongCrudService);
		$this->set('userCrud', new UserCrudService);

		$this->modules = [
		            'tagEditor' => [
		                'class' => 'admin\modules\tagEditor\Module',
		            ],
		        ];

		$this->params['tmp_dir'] = Yii::getAlias('@admin') . '/tmp';
	}

	public function run() {
	}

}
?>
