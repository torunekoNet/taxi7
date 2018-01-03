<?php
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => "Taxi7",
    'preload' => array('log'),

    'import' => array(
        'application.models.*',
        'application.models.form.*',
        'application.components.*',
        'application.components.filters.*',
    ),

    'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'123',
            // 'ipFilters'=>array(...IP 列表...),
            // 'newFileMode'=>0666,
            // 'newDirMode'=>0777,
        ),
    ),

    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
            'guestName' => '游客',
        ),

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '',
            'rules' => array(
                array('index/index', 'pattern' => ''),
                array('index/driver', 'pattern' => 'driver'),
                array('account/login', 'pattern' => 'login'),
                array('account/logout', 'pattern' => 'logout'),
                array('account/session', 'pattern' => 'session'),
                array('index/error', 'pattern' => 'error'),
            ),
        ),

        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=taxi7',
            'emulatePrepare' => true,
            'schemaCachingDuration' => 86400,
            'username' => "root",
            'password' => "toruneko",
            'charset' => 'utf8',
        ),

        'session' => array(
            'class' => 'CCacheHttpSession',
        ),

        'cache' => array(
            'class' => 'CRedisCache',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 2,
            'options' => STREAM_CLIENT_CONNECT,
        ),

        'redis' => array(
            'class' => 'CRedisCache',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 3,
            'options' => STREAM_CLIENT_CONNECT,
        ),

        'errorHandler' => array(
            'errorAction' => 'index/error',
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),
            ),
        ),
    ),

    'params' => array(
        'upload' => 'upload',
        'version' => 'V1.0',
    ),
);
