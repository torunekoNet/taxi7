<?php

/**
 * File: RoleRemoveAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 23:14
 * Description:
 */
class RoleRemoveAction extends AuthRemoveAction
{

    protected function removeAuthItemByPk($id)
    {
        return $this->auth->removeRoleByPk($id);
    }
}