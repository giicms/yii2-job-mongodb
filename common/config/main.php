<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');
require(dirname(dirname(__DIR__)) . '/common/config/functions.php');
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'components' => [
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://127.0.0.1:27017/giaonhanviec',
           // 'dsn' => 'mongodb://giaonhanviec:admin!@#123654@localhost:27017/giaonhanviec',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp-relay.gmail.com',
                'username' => 'giaonhanviec@gmail.com',
                'password' => 'gnv@123456',
                'port' => '587',
                'encryption' => 'ssl',
            ],
        ],
    ],
];
