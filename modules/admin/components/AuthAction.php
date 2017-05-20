<?php

/**
 * File: AuthAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 23:28
 * Description:
 */
abstract class AuthAction extends RedAction
{

    public function run()
    {
        $operationType = $this->request->getPost('operationType', false);

        if ($operationType && method_exists($this, $operationType)) {
            call_user_func(array($this, $operationType));
        } else {
            $this->execute();
        }
    }

    /**
     * 异步加载
     */
    protected function asyncLoad()
    {
        $id = $this->request->getPost('id', 0);
        $operation = $this->model()->findAll('fid=:id', array('id' => $id));
        $data = array();
        foreach ($operation as $op) {
            $data[] = array(
                'id' => $op->getAttribute('id'),
                'name' => $op->getAttribute('name'),
                'isParent' => true,
            );
        }

        $this->response(200, 'success', $data);
    }

    abstract protected function model();

    abstract protected function execute();
}