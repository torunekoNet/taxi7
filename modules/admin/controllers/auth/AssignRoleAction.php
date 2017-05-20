<?php

/**
 * File: AddRoleAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 11:22
 * Description:
 */
class AssignRoleAction extends RedAction
{

    public function run()
    {
        $roleId = $this->request->getQuery('auth', 0);
        $userId = $this->request->getQuery('user', 0);

        $role = $this->auth->getRoleByPk($roleId);
        if ($role == false) {
            $this->response(404, '参数错误');
        } else {
            if ($role->hasUser($userId)) {
                if ($role->removeUser($userId)) {
                    $this->response(200, '取消角色成功');
                } else {
                    $this->response(500, '取消角色失败');
                }
            } else {
                if ($role->addUser($userId)) {
                    $this->response(200, '赋予角色成功');
                } else {
                    $this->response(500, '赋予角色失败');
                }
            }
        }
    }
}