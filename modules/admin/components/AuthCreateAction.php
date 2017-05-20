<?php

/**
 * File: AuthCreateAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 00:25
 * Description:
 */
abstract class AuthCreateAction extends AuthAction
{

    protected function execute()
    {
        $id = $this->request->getPost('id', 0);
        $item = $this->getAuthItemByPk($id);
        if (!empty($item)) {
            if (($child = $item->addChild('未命名')) != false) {
                $this->response(200, '添加成功', array(
                    'id' => $child->getId(),
                    'name' => $child->getName(),
                    'isParent' => false,
                ));
            } else {
                $this->response(500, '添加失败');
            }
        } else {
            $this->response(404, '参数错误');
        }
    }

    abstract protected function getAuthItemByPk($id);

    protected function model()
    {
    }
}