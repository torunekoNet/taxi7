<?php

/**
 * File: OperationRemoveAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 17:53
 * Description: 删除操作
 */
class OperationRemoveAction extends AuthRemoveAction
{

    protected function removeAuthItemByPk($id)
    {
        return $this->auth->removeOperationByPk($id);
    }
}