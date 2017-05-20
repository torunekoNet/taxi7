<?php

/**
 * File: AuthEditAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 00:41
 * Description:
 */
abstract class AuthEditAction extends AuthAction
{

    protected function drop()
    {
        $id = $this->request->getPost('id', 0);
        $tid = $this->request->getPost('tid', 0);
        $item = $this->getAuthItemByPk($id);
        $titem = $this->getAuthItemByPk($tid);

        if ($item != false && $titem != false) {
            $item->setFid($tid);
            if ($item->update()) {
                $this->response(200, '更新成功');
            } else {
                $this->response(500, '更新失败');
            }
        } else {
            $this->response(404, '参数错误');
        }
    }

    protected function execute()
    {
        $model = $this->createFormModel();

        if (($post = $this->request->getPost(get_class($model), false)) !== false) {
            $model->attributes = $post;
            if ($model->validate() && $model->save()) {
                $this->response(200, '更新成功');
            } else {
                $this->response(500, '更新失败');
            }
            $this->app->end();
        } else if (($id = $this->request->getPost('id', false)) != false) {
            if (($item = $this->model()->findByPk($id)) != false) {
                $model->attributes = array(
                    'id' => $item->getAttribute('id'),
                    'name' => $item->getAttribute('name'),
                    'description' => $item->getAttribute('description'),
                    'status' => $item->getAttribute('status'),
                    'module' => $item->getAttribute('module'),
                    'controller' => $item->getAttribute('controller'),
                    'action' => $item->getAttribute('action'),
                    'sort' => $item->getAttribute('sort'),
                );

                $this->render($this->getView(), array(
                    'model' => $model,
                    'assigns' => $this->getAssigns($id)
                ));
                $this->app->end();
            }
        }

        $this->response(404, '参数错误');
    }

    protected function getAssigns($id)
    {
        $item = $this->getAuthItemByPk($id);
        $assigns = $item->getUsers();

        $users = array();
        foreach ($assigns as $assign) {
            $users[] = $assign['user_id'];
        }

        $user = array();
        if (!empty($users)) {
            $user = User::model()->findAll('id IN (' . join(',', $users) . ')');
        }

        return new RedArrayDataProvider($user);
    }

    abstract protected function getAuthItemByPk($id);

    abstract protected function createFormModel();

    abstract protected function getView();

}