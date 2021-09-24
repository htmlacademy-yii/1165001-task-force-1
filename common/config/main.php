<?php
return [
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',

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
            'suffix' => '/',
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                'normalizeTrailingSlash' => true,
                'collapseSlashes' => true,
            ],
            'rules' => [
                '//' => '/',
                '' => 'site/index',
                '' => 'site/',

                'users/page/<page:\d+>' => 'users/index',
                'users/<id:\d+>' => 'users/detail',
                'users/' => 'users/index',

                'tasks/page/<page:\d+>' => 'tasks/index',
                'tasks/<id:\d+>' => 'tasks/detail',
                'tasks/' => 'tasks/index',
            ],
        ],
    ],
];
