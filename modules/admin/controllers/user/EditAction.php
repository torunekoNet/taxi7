<?php

/**
 * File: EditAction.php
 * User: daijianhao@zhubajie.com
 * Date: 14-8-18 15:18
 * Description:
 */
class EditAction extends RedAction
{

    public function run()
    {
        $model = new UserForm();

        if (($post = $this->request->getPost('UserForm', false)) !== false) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->response(200, '更新用户成功');
            } else {
                $this->response(500, '更新用户失败');
            }
            $this->app->end();
        } else if (($id = $this->request->getQuery('id', 0)) != false) {
            if (($user = User::model()->findByPk($id)) != false) {
                $model->attributes = array(
                    'id' => $user->id,
                    'username' => $user->username,
                    'realname' => $user->realname,
                    'nickname' => $user->nickname,
                    'email' => $user->email,
                    'state' => $user->state,
                );
                $auth = $this->app->getAuthManager();

                $roles = $auth->getRoleByUserId($id);
                $role = array();
                foreach ($roles as $item) {
                    $role[] = $item->getId();
                }
                $groups = $auth->getGroupByUserId($id);
                $group = array();
                foreach ($groups as $item) {
                    $group[] = $item->getId();
                }

                $this->render('edit', array(
                    'model' => $model,
                    'role' => $role,
                    'group' => $group,
                    'roleList' => Role::model()->findAll(),
                    'groupList' => Group::model()->findAll(),
                ));
                $this->app->end();
            }
        }

        $this->response(404, '参数错误');
    }
}