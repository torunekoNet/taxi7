<?php

/**
 * File: AssignAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 11:15
 * Description:
 */
class AssignAction extends RedAction
{

    public function run()
    {
        $operationType = $this->request->getPost('operationType', 'execute');
        if (method_exists($this, $operationType)) {
            call_user_func(array($this, $operationType));
        } else {
            $this->execute();
        }
    }

    public function view()
    {
        $roleId = $this->request->getPost('role', 0);
        $role = $this->auth->getRoleByPk($roleId);
        if ($role == false) {
            $this->response(404, '参数错误');
        } else {
            $operations = Operation::model()->findAll(array(
                'condition' => '`level`=2',
            ));
            $opera = array();
            foreach ($operations as $operation) {
                $auth = $this->auth->getOperationByPk($operation->getAttribute('id'));
                $opera[] = array(
                    'data' => $auth,
                    'child' => $auth->getChild()
                );
            }

            $assigns = $role->getAssigns();
            $assign = array();
            foreach ($assigns as $item) {
                if ($item !== false) {
                    $assign[] = $item->getId();
                }
            }

            $this->render('assign', array(
                'opera' => $opera,
                'role' => $role,
                'assign' => $assign,
            ));
        }
    }

    public function execute()
    {
        $roleId = $this->request->getPost('role', 0);
        $operationId = $this->request->getPost('operation', 0);

        $role = $this->auth->getRoleByPk($roleId);
        if ($role == false) {
            $this->response(404, '参数错误');
        } else {
            if ($role->isAssigned($operationId)) {
                if (!$role->revoke($operationId)) {
                    $this->response(500, '取消授权失败');
                }
            } else {
                if (!$role->assign($operationId)) {
                    $this->response(500, '授权失败');
                }
            }
        }
    }
}