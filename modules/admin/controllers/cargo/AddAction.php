<?php

/**
 * File: AddAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/20 11:00
 * Description:
 */
class AddAction extends RedAction
{

    public function run()
    {
        $model = new StoreForm();
        if (($post = $this->request->getPost('StoreForm', false)) != false) {
            $model->attributes = $post;
            if ($model->validate() && $model->save()) {
                $this->response(200, '添加成功');
                $this->app->end();
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }
}