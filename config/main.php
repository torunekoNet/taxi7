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

    'modules' => array(
        'admin' => array(
            'class' => 'application.modules.admin.AdminModule'
        )
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
        //上下级权限检测
        'allowCheck' => array(
            'auth' => array(
                'assign' => array(
                    array('role', 'role', 'post'),
                    array('operation', 'operation', 'post'),
                ),
                'assignGroup' => array(
                    array('auth', 'group', 'get'),
                    array('user', 'user', 'get'),
                ),
                'assignRole' => array(
                    array('auth', 'role', 'get'),
                    array('user', 'user', 'get')
                ),
            ),
            'user' => array(
                'edit' => array(
                    array('id', 'user', 'get'),
                    array(array('UserForm', 'id'), 'user', 'post'),
                )
            ),
        ),
    ),
);
