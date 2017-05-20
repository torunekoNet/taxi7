<?php

/**
 * File: GroupRemoveAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 23:13
 * Description:
 */
class GroupRemoveAction extends AuthRemoveAction
{

    protected function removeAuthItemByPk($id)
    {
        return $this->auth->removeGroupByPk($id);
    }
}