<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$urlManager = require(__DIR__ .'/urlmanager.php');

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'assetManager' => [
            'linkAssets' => true,
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => $urlManager,
    ],
    'modules' => [
      'album' => [
        'class' => 'backend\modules\album\Module',
      ],
      'artist' => [
        'class' => 'backend\modules\artist\Module',
      ],
      'listener' => [
        'class' => 'backend\modules\listener\Module',
      ],
      'webplayer' => [
        'class' => 'backend\modules\musicPanel\Module',
      ],
      'playlist' => [
        'class' => 'backend\modules\playlist\Module',
      ],
      'admin' => [
        'class' => 'admin\Module',
      ],
      'regulator' => [
        'class' => 'regulator\Module',
      ]
    ],
    'params' => $params,
];
