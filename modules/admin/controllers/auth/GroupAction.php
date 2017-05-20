<?php

/**
 * File: GroupAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 11:56
 * Description: 用户组管理
 */
class GroupAction extends AuthAction
{

    public function model()
    {
        return Group::model();
    }

    public function execute()
    {
        $this->render('index', array(
            'name' => '用户组管理',
            'asyncUrl' => $this->createUrl('auth/group'),
            'createUrl' => $this->createUrl('auth/groupCreate'),
            'editUrl' => $this->createUrl('auth/groupEdit'),
            'removeUrl' => $this->createUrl('auth/groupRemove'),
        ));
    }
}