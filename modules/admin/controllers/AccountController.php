<?php

/**
 * file:AccountController.php
 * author:Toruneko@outlook.com
 * date:2014-7-13
 * desc:登录入口
 */
class AccountController extends Controller
{

    public function init()
    {
        parent::init();

        $this->layout = '/layouts/main';
    }

    public function actionLogin()
    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('index/index'));
        }

        $model = new LoginForm();
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                $this->redirect($this->createUrl('index/index'));
            }
        }

        $this->render('login', array('model' => $model));
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect($this->createUrl('login'));
    }

    public function actionEdit()
    {
        $model = new UserForm();

        if (($post = $this->request->getPost('UserForm', false)) !== false) {
            $post['state'] = -1;
            $model->attributes = $post;
            if ($model->save()) {
                $this->response(200, '更新用户成功');
            } else {
                $this->response(500, '更新用户失败');
            }
        } else if (($id = $this->request->getQuery('id', 0)) != false) {
            if (($user = User::model()->findByPk($id)) != false) {
                $model->attributes = array(
                    'id' => $user->id,
                    'username' => $user->username,
                    'realname' => $user->realname,
                    'nickname' => $user->nickname,
                    'email' => $user->email,
                    'state' => -1,
                );

                $this->render('edit', array(
                    'model' => $model,
                ));
            }
        } else {
            $this->response(404, '参数错误');
        }
    }

    public function getFilters()
    {
        return array();
    }

    /*
     * @see Controller::allowGuest()
     */
    public function allowGuest()
    {
        return true;
    }

    /*
     * @see Controller::allowHttpRequest()
     */
    public function allowHttpRequest()
    {
        return true;
    }

    /*
     * @see Controller::allowAjaxRequest()
     */
    public function allowAjaxRequest()
    {
        return true;
    }
}