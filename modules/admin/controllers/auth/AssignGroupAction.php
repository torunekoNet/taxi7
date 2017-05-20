<?php

/**
 * File: AddGroupAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 11:28
 * Description:
 */
class AssignGroupAction extends RedAction
{

    public function run()
    {
        $groupId = $this->request->getQuery('auth', 0);
        $userId = $this->request->getQuery('user', 0);

        $group = $this->auth->getGroupByPk($groupId);
        if ($group == false) {
            $this->response(404, '参数错误');
        } else {
            if ($group->hasUser($userId)) {
                if ($group->removeUser($userId)) {
                    $this->response(500, '移出用户组成功');
                } else {
                    $this->response(500, '移出用户组失败');
                }
            } else {
                if ($group->addUser($userId)) {
                    $this->response(500, '加入用户组成功');
                } else {
                    $this->response(500, '加入用户组失败');
                }
            }
        }
    }
}