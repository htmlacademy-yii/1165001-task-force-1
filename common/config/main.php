<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '' => 'site/',
                '/' => '/',

                'users/page/<page:\d+>' => 'users/index',
                'users/' => 'users/index',

                'tasks/page/<page:\d+>' => 'tasks/index',
                'tasks/' => 'tasks/index',
            ],
        ],
    ],
];
