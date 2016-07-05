<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'auth' => [
            'class' => 'backend\modules\auth\Module',
        ],
    ],
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.min.css' : 'css/bootstrap.css',
                    ],
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.min.js' : 'js/bootstrap.js',
                    ]
                ],
//                'yii\bootstrap\BootstrapPluginAsset' => [
//                    'js' => [
//                        YII_ENV_DEV ? 'js/bootstrap.min.js' : 'js/bootstrap.js',
//                    ]
//                ]
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\Account',
            'enableAutoLogin' => true,
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable r= routes
            'enablePrettyUrl' => true,
            'showScriptName' => false, // Disable index.php
            'enablePrettyUrl' => true, // Disable r= routes
            'rules' => [
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\w+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ]
        ],
        'authManager' => [
            'class' => 'backend\components\MongodbManager',
            'defaultRoles' => ['guest']
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
        'setting' => [
            'class' => 'backend\components\Settings',
        ],
        'convert' => [
            'class' => 'backend\components\Convert',
        ],
        'info' => [
            'class' => 'backend\components\Info',
        ],
    ],
    'params' => $params,
];
