<?php

/**
 * File: RoleAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 11:56
 * Description: 角色管理
 */
class RoleAction extends AuthAction
{

    public function model()
    {
        return Role::model();
    }

    public function execute()
    {
        $this->render('index', array(
            'name' => '角色管理',
            'asyncUrl' => $this->createUrl('auth/role'),
            'createUrl' => $this->createUrl('auth/roleCreate'),
            'editUrl' => $this->createUrl('auth/roleEdit'),
            'removeUrl' => $this->createUrl('auth/roleRemove'),
        ));
    }
}