<?php
namespace user\services\messages;

abstract class NotificationMessageType {

  abstract public static function getMessage($params);

}
