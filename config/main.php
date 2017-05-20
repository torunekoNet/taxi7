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
            'connectionString' => 'mysql:host=sqld.duapp.com;port=4050;dbname=mKbzOjIRwJhRQvbsyHDe',
            'emulatePrepare' => true,
            'schemaCachingDuration' => 86400,
            'username' => "77d93fa2c471405191d15571c02e508f",
            'password' => "9e7170398e164dfbb1bfeb5378269697",
            'charset' => 'utf8',
        ),

        'cache' => array(
            'class' => 'BaeMemCache',
            'host' => 'redis.duapp.com',
            'port' => '80',
            'username' => '77d93fa2c471405191d15571c02e508f',
            'password' => '9e7170398e164dfbb1bfeb5378269697',
            'dbname' => 'DATjkLvSSAgDtATmsWbw'
        ),

        'redis' => array(
            'class' => 'BaeRedisCache',
            'host' => 'redis.duapp.com',
            'port' => '80',
            'username' => '77d93fa2c471405191d15571c02e508f',
            'password' => '9e7170398e164dfbb1bfeb5378269697',
            'dbname' => 'DATjkLvSSAgDtATmsWbw'
        ),

        'errorHandler' => array(
            'errorAction' => 'index/error',
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'BaeLogRoute',
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
