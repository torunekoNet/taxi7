<?php

/**
 * File: RoleCreateAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 23:13
 * Description:
 */
class RoleCreateAction extends AuthCreateAction
{

    protected function getAuthItemByPk($id)
    {
        return $this->auth->getRoleByPk($id);
    }
}