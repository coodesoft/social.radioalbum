<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$urlManager = require(__DIR__ .'/urlmanager.php');

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'assetManager' => [
          'linkAssets' => true,
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'urlManager' => $urlManager,
        'authClientCollection' => [
          'class' => 'yii\authclient\Collection',
          'clients' => [
            'facebook' => [
              'class' => 'yii\authclient\clients\Facebook',
              'authUrl' => 'https://www.facebook.com/dialog/oauth',
              'clientId' => '373143716522940',
              'clientSecret' => '6c20895b72fee8f81a164f9bc9666a3d',
              'attributeNames' => ['name', 'email', 'first_name', 'last_name'],
            ],
            'google' => [
                'class' => 'yii\authclient\clients\Google',
                'clientId' => '338118185535-ooid82asmr1fbactkg7fl9sqi6pbf0jj.apps.googleusercontent.com',
                'clientSecret' => 'yPuroCTa0NvIV0q5c5bHSPs_',
            ],
          ],
        ],
    ],
    'modules' => [
      'album' => [
        'class' => 'frontend\modules\album\Module',
      ],
      'artist' => [
        'class' => 'frontend\modules\artist\Module',
      ],
      'listener' => [
        'class' => 'frontend\modules\listener\Module',
      ],
      'musicPanel' => [
        'class' => 'frontend\modules\musicPanel\Module',
      ],
      'playlist' => [
        'class' => 'frontend\modules\playlist\Module',
      ],
      'channel' => [
        'class' => 'frontend\modules\channel\Module',
      ],
      'user' => [
        'class' => 'user\Module',
      ],
      'searcher' => [
        'class' => 'searcher\Module',
      ],
    ],
    'params' => $params,
];
