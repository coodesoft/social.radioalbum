<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=ra_social',
            'username' => 'ra_social',
            'password' => 'ra_social',
            'charset' => 'utf8',
        ],
    ],
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],

];
