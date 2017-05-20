<?php

/**
 * File: GroupEditAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 23:13
 * Description:
 */
class GroupEditAction extends AuthEditAction
{

    protected function getAuthItemByPk($id)
    {
        return $this->auth->getGroupByPk($id);
    }

    protected function model()
    {
        return Group::model();
    }

    protected function createFormModel()
    {
        return new GroupForm();
    }

    protected function getView()
    {
        return 'group';
    }
}