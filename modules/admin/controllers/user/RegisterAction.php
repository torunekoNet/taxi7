<?php

/**
 * File: RegisterAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/27 23:51
 * Description: 注册用户
 */
class RegisterAction extends RedAction
{

    public function run()
    {
        $model = new RegisterForm();

        if (($post = $this->request->getPost('RegisterForm', false)) !== false) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->response(200, '注册用户成功');
                $this->app->end();
            }
        }

        $this->render('register', array(
            'model' => $model,
        ));
    }
}