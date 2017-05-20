<?php

/**
 * File: OperationAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 14:28
 * Description: 操作管理
 */
class OperationAction extends AuthAction
{

    public function model()
    {
        return Operation::model();
    }

    public function execute()
    {
        $this->render('index', array(
            'name' => '操作管理',
            'asyncUrl' => $this->createUrl('auth/operation'),
            'createUrl' => $this->createUrl('auth/operationCreate'),
            'editUrl' => $this->createUrl('auth/operationEdit'),
            'removeUrl' => $this->createUrl('auth/operationRemove'),
        ));
    }
}