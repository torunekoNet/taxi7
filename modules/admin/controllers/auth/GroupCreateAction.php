<?php

/**
 * File: GroupCreateAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 23:12
 * Description:
 */
class GroupCreateAction extends AuthCreateAction
{

    protected function getAuthItemByPk($id)
    {
        return $this->auth->getGroupByPk($id);
    }
}