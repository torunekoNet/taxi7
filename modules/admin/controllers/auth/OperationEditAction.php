<?php

/**
 * File: OperationEditAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 17:56
 * Description: 编辑操作
 */
class OperationEditAction extends AuthEditAction
{

    protected function getAuthItemByPk($id)
    {
        return $this->auth->getOperationByPk($id);
    }

    protected function model()
    {
        return Operation::model();
    }

    protected function createFormModel()
    {
        return new OperationForm();
    }

    protected function getView()
    {
        return 'operation';
    }

    protected function getAssigns($id)
    {
        return array();
    }
}