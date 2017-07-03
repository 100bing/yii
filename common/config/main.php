<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'=>'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
//        'class'=>'yii\redis\Cache',
        ],
        'authManager'=>[
            'class'=>\yii\rbac\DbManager::className(),
        ],
//        'redis'=>[
//            'class'=>'yii\redis\Connection',
//            'hostname'=>'127.0.0.1',
//            'post'=>6379,
//            'database'=>0,
//
//        ],


    ],
];
