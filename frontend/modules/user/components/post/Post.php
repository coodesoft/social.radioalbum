<?php
namespace user\components\post;

use Yii;
use common\widgets\RaBaseWidget;
use common\models\Visibility;

use common\models\User;

class Post extends RaBaseWidget{

    public $content;

    public $component;

    public $shareable;

    public $reply_to;

    public $profile;

    public $visible;

    public $lazyLoad;

    public $embedded;

    public $sharedType;

    public $sharedEntity;

    public $sharedId;

    public function init(){
      parent::init();
    }

    public function run(){
      $me = User::getModelExtended(Yii::$app->user->id, Yii::$app->user->identity->role->type)->profile;
      switch ($this->component) {
        case 'panel':
          $visArr = Visibility::find()->all();
          return $this->render('panel', ['actions' => $this->content, 'array' => $visArr]);
          break;
        case 'wall':
          return $this->render('wall', ['posts' => $this->content,
                                        'profile' => $this->profile,
                                        'shareable' => $this->shareable,
                                        'lazyLoad' => $this->lazyLoad,
                                        'embedded' => $this->embedded,
                                        'owner_id' => $me->id,
                                       ]);
          break;
        case 'wall_partial':
          return $this->render('wall_partial', ['posts' => $this->content,
                                                'profile' =>  $this->profile,
                                                'shareable' => $this->shareable,
                                                'embedded' => $this->embedded,
                                                'owner_id' => $me->id,
                                              ]);
          break;
        case 'post':
          return $this->render('box_post', ['type' => 'post',
                                            'box' => $this->content,
                                            'profile' =>  $this->profile,
                                            'shareable' => $this->shareable,
                                            'embedded' => $this->embedded,
                                            'owner_id' => $me->id,
                                          ]);
          break;
        case 'comment':
          return $this->render('box_post', ['type' => 'comment',
                                            'box' => $this->content,
                                            'profile' =>  $this->profile,
                                            'shareable' => $this->shareable,
                                            'reply_to' => $this->reply_to,
                                            'visible' => $this->visible,
                                            'embedded' => $this->embedded,
                                            'owner_id' => $me->id,
                                          ]);
          break;
        case 'share':
          $visArr = Visibility::find()->all();
          return $this->render('share', [ 'content' => $this->content,
                                            'visArray' => $visArr,
                                            'type' => $this->sharedType,
                                            'id' => $this->sharedId,
                                          ]);
          break;
        default:
            $pos = strpos($this->component, 'preview');
            if ($pos !== false){
              $component = explode('-', $this->component);
              $view = 'previews/' . $component[0];

              return $this->render($view, ['entity' => $this->sharedEntity, 'me' => $me->id]);
            }
          break;
      }

    }
}


?>
