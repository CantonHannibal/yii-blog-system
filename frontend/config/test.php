<?php
return [

    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=country',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',


    'id' => 'app-frontend-tests',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
