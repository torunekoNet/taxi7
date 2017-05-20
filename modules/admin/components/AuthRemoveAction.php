<?php

/**
 * File: AuthRemoveAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 00:32
 * Description:
 */
abstract class AuthRemoveAction extends AuthAction
{

    public function execute()
    {
        $id = $this->request->getPost('id', 0);

        if (!empty($id)) {
            if ($this->removeAuthItemByPk($id)) {
                $this->response(200, '删除成功');
            } else {
                $this->response(500, '删除失败');
            }
        } else {
            $this->response(404, '参数错误');
        }
    }

    abstract protected function removeAuthItemByPk($id);

    protected function model()
    {
    }
}