<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\BaseJson;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\util\Requester;
use common\util\Flags;
use common\util\Response;
use common\modules\album\models\Album;

use frontend\models\Channel;
use frontend\models\Song;
use frontend\models\Profile;
use frontend\models\ProfileOpts;
use backend\models\Soloist;
use backend\models\Band;
use common\models\User;
use common\models\Operation;
/**
 * Site controller
 */
class CatalogController extends RaBaseController{

  public $layout = 'main_logged';

  private $catalog_manager_user = 'backuser';

  private $catalog_manager_password = 'osvaldo';

  private $server_url = "/radioalbum/mediaserver/server/xml.server.php?";

  private $token;

  private $session_expire = null;

  private $opActions = ['media' => 'migrate_catalog',
                        'artists' => 'migrate_artists'
                      ];

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['multimedia-migration',
                                  'populate-multimedia',
                                  'update-multimedia',
                                  'artists-migration',
                                  'populate-artists', 'lala'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
          ],
      ],
    ];
  }

  private function getMediaServerUrl(){
    return "http://".$_SERVER['SERVER_NAME']. $this->server_url;
  }

  private function getConnectionParams(){
    $time = time();
    $key = hash('sha256',$this->catalog_manager_password);
    $passphrase = hash('sha256', $time . $key);

    return [
      'timestamp' => $time,
      'action'    => 'handshake',
      'auth'      => $passphrase,
      'version'   => '380001',
      'user'      => $this->catalog_manager_user,
    ];
  }

  private function getMediaServerConnectionToken(){
    $actual_time = new \DateTime();
    if (($this->session_expire == null) || ($this->session_expire<$actual_time->getTimeStamp())){
      $params = $this->getConnectionParams();
      $connection = Requester::get($this->getMediaServerUrl(), $params);
      $session = simplexml_load_string($connection, null, LIBXML_NOCDATA);
      $this->session_expire = strtotime($session->session_expire);
      $this->token = $session->auth;
    }
    return $this->token;
  }

  private function getMediaServerData($action, $params = null, $option = true){
    $token = $this->getMediaServerConnectionToken();

    if ($params == null)
      $params = ['auth' => $token, 'action' => $action];
    else{
      $params['auth'] = $token;
      $params['action'] = $action;
    }

    $session = Requester::get($this->getMediaServerUrl(), $params, $option);

    if ($option)
        return simplexml_load_string($session, null, LIBXML_NOCDATA);
    else
        return $session;
  }

}
