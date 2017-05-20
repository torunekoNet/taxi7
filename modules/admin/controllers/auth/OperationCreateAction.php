<?php

/**
 * File: OperationCreateAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 17:52
 * Description: 创建操作
 */
class OperationCreateAction extends AuthCreateAction
{

    protected function getAuthItemByPk($id)
    {
        return $this->auth->getOperationByPk($id);
    }
}