<?php
return [
    'language' => 'es-AR',
    'timeZone' => 'America/Argentina/Buenos_Aires',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            /*[ admin     => 1,
                regulator => 2,
                listener  => 3,
                musician  => 4,
              ]
            */
            'defaultRoles' => [ 'admin',
                                'regulator',
                                'listener',
                                'artist',
                                'postExplorer',
                                'playlistOwner',
                                'playlistReader'],
        ],
        'i18n' => [
        'translations' => [
            'app' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@common/util/i18n',
            ],
        ],
    ],
    ],
];
