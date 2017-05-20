<?php

/**
 * File: AuthController.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 12:57
 * Description: 权限管理
 */
class AuthController extends Controller
{

    public $auth;

    public function init()
    {
        parent::init();

        $this->auth = $this->app->getAuthManager();
    }

    public function getActions()
    {
        return array(
            'operation', 'operationCreate', 'operationRemove', 'operationEdit', 'assign',
            'role', 'roleCreate', 'roleRemove', 'roleEdit', 'assignRole',
            'group', 'groupCreate', 'groupRemove', 'groupEdit', 'assignGroup',
        );
    }
}