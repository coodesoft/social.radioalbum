<?php
namespace raOauth\actions;
use yii\authclient\AuthAction;

use common\util\Response;
use common\util\Flags;

class RaAuthAction extends AuthAction{

  /**
   * This method is invoked in case of successful authentication via auth client.
   * @param ClientInterface $client auth client instance.
   * @throws InvalidConfigException on invalid success callback.
   * @return Response response instance.
   */
  protected function authSuccess($client) {
      if (!is_callable($this->successCallback)) {
          throw new InvalidConfigException('"' . get_class($this) . '::successCallback" should be a valid callback.');
      }
      $response = call_user_func($this->successCallback, $client);

      $flag = $response->getFlag();
      $content = $response->getResponse();

      if ($flag == Flags::AUTH_USER_LOGIN){
        return $this->controller->redirect([$content['route']]);
      }

      if ($flag == Flags::AUTH_USER_SIGNUP){
        return $this->controller->render($content['view'], [
          'model' => $content['model'],
          'roles' => $content['roles'],
        ]);
      }

      /*
      if ($response instanceof Response) {
          return $response;
      }
      return $this->redirectSuccess();
      */

  }
}
