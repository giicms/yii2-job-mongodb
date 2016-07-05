<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);
return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'gallery' => [
            'class' => 'frontend\modules\gallery\Gallery',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\GoogleOAuth',
                    'clientId' => '976194090754-i55cukqj0r7ucmm6ff013m98vhl864dt.apps.googleusercontent.com',
                    'clientSecret' => '1S9ZgePNk2SrzPvEiAZw7REm',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '410404702483049',
                    'clientSecret' => 'cf665c535023eb9481f1d9ad7f745d3f',
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable r= routes
            'enablePrettyUrl' => true,
            'showScriptName' => false, // Disable index.php
            'enablePrettyUrl' => true, // Disable r= routes
            'rules' => [
                'dang-nhap' => 'site/login',
                'danh-muc-nganh-nghe' => 'category/index',
                'danh-muc-nganh-nghe/<slug>' => 'category/view',
                'tro-thanh-boss' => 'page/pageboss',
                'page/<slug>' => 'page/index',
                'tro-thanh-nhan-vien' => 'page/pageworkers',
                'quy-che-bao-mat' => 'page/privacy',
                'dieu-khoan-su-dung' => 'page/termsofuse',
                'tin-nhan' => 'messages/index',
                'tin-nhan/<slug>' => 'messages/user',
                // job
                'danh-sach-cong-viec' => 'job/index',
                'danh-sach-cong-viec/tim-kiem' => 'job/search',
                'danh-sach-cong-viec/tim-viec' => 'job/fillter',
                'cong-viec/<slug>-<id:\w+>' => 'job/detail',
                'cong-viec/<slug>/<id:\w+>' => 'job/detail',
                'dang-viec/<slug>-<id:\w+>' => 'job/create',
                'dang-viec' => 'job/create',
                // membership
                'tao-tai-khoan-nhan-vien' => 'membership/register',
                'ho-so-ca-nhan/ky-nang' => 'membership/skills',
                'ho-so-ca-nhan/gioi-thieu-ban-than' => 'membership/about',
                'ho-so-ca-nhan/kinh-nghiem-va-hoc-van' => 'membership/experience',
                'danh-sach-nhan-vien' => 'membership/index',
                'danh-sach-nhan-vien/tim-kiem-nhan-vien' => 'membership/search',
                'danh-sach-nhan-vien/tim-kiem' => 'membership/fillter',
                'boss/cong-viec-cua-toi' => 'manageboss/index',
                'viec-da-luu' => 'jobmanage/savejob',
                'thong-tin-ca-nhan' => 'membership/profile',
                'bang-luong' => 'paymenthistory/salarytable',
                'cong-viec-cua-toi' => 'membermanage/index',
                'luu-viec' => 'membermanage/savejob',
                'kiem-tra-nang-luc' => 'test/index',
                // user
                'danh-gia-thanh-vien' => 'user/review',
                'cai-dat-mat-khau' => 'user/resetpassword',
                'quen-mat-khau' => 'user/fogotpassword',
                'thay-doi-mat-khau' => 'user/changepassword',
                'tai-khoan-cua-toi' => 'user/info',
                'danh-gia' => 'user/review',
                'user/<slug>' => 'user/index',
                // boss 
                'tao-tai-khoan-boss' => 'boss/register',
                'lich-su-thanh-toan' => 'paymenthistory/paymenthistory',
                'danh-sach-khach-hang' => 'membermanage/boss',
                'cong-viec-da-dang' => 'bossmanage/jobmanage',
                'danh-sach-luu-nhan-vien' => 'bossmanage/member',
                'danh-sach-book-nhan-vien' => 'bossmanage/bookuser',
                // help
                'tro-giup/<slug>' => 'page/index',
                'giao-nhan-viec' => 'page/about',
                'huong-dan-su-dung/<slug>-<id:\w+>' => 'help/manualcat',
                'huong-dan-su-dung/<id:\w+>' => 'help/manualdetail',
                'huong-dan-su-dung' => 'help/manual',
                'cau-hoi-thuong-gap/<slug>-<id:\w+>' => 'help/questioncat',
                'cau-hoi-thuong-gap/<id:\w+>' => 'help/questiondetail',
                'cau-hoi-thuong-gap' => 'help/question',
                'ho-tro' => 'help/index',
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ]
        ],
        'convert' => [
            'class' => 'frontend\components\Convert',
        ],
        'info' => [
            'class' => 'frontend\components\Info',
        ],
        'setting' => [
            'class' => 'frontend\components\Settings',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
