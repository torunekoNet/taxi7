<?php

/**
 * File: RoleEditAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 23:13
 * Description:
 */
class RoleEditAction extends AuthEditAction
{

    protected function getAuthItemByPk($id)
    {
        return $this->auth->getRoleByPk($id);
    }

    protected function model()
    {
        return Role::model();
    }

    protected function createFormModel()
    {
        return new RoleForm();
    }

    protected function getView()
    {
        return 'role';
    }
}