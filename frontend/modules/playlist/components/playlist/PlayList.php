<?php
namespace frontend\modules\playlist\components\playlist;

use Yii;
use common\widgets\RaBaseWidget;
use common\util\MobileDetect;

use common\widgets\errorMessage\ErrorMessage;

class PlayList extends RaBaseWidget{

    public $playlists;

    public $profile;

    public $enviroment;

    public $element;

    public $type;

    public $playlist_content = null;

    public $lazyLoad;

    public $partialRender = false;

    public $externalSource = null;

    public function init(){
      parent::init();
    }

    public function run(){
      $mobile = new MobileDetect;

      $isMobile = $mobile->isMobile() ? true : false;

      switch ($this->enviroment) {
        case 'extended':
          return $this->render('extended', ['playlists' => $this->playlists,
                                            'profile'=> $this->profile,
                                            'isMobile' => $isMobile,
                                             ]);
          break;
        case 'minimal':
          return $this->render('minimal', ['playlists' => $this->playlists,
                                           'song' =>$this->element,
                                           'profile'=>$this->profile,
                                           'type' => $this->type]);
          break;
        case 'update':
          return $this->render('update-list', ['playlist' => $this->element]);
          break;
        case 'description':

          $viewPermission = Yii::$app->user->can('playlistReader',['playlist_id' => $this->element->id]);
          $crudPermission = Yii::$app->user->can('crudPlaylist',['playlist_id' => $this->element->id]);

          if ($viewPermission)
            return $this->render('description', [ 'playlist' => $this->element,
                                                  'songs' => $this->playlist_content,
                                                  'lazyLoad' => $this->lazyLoad,
                                                  'externalSource' => $this->externalSource,
                                                  'crudPermission' => $crudPermission ]);
          else
            return ErrorMessage::widget(['message' => \Yii::t('app', 'unableAccessCollection')]);
          break;
        case 'list':
          if (!$this->partialRender)
            return $this->render('list', [ 'playlists' => $this->playlists,
                                           'lazyLoad' => $this->lazyLoad,
                                           'isMobile' => $isMobile ]);
          else
             return $this->render('list-partial', [ 'playlists' => $this->playlists,
                                                    'isMobile' => $isMobile ] );
          break;
        default:
          break;
      }
    }
}


?>
