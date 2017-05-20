<?php

/**
 * File: SalesAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 18:29
 * Description:
 */
class SalesAction extends RedAction
{

    public function run()
    {
        $model = new SalesForm();
        if (($post = $this->request->getPost('SalesForm', false)) != false) {
            $id = $post['id'];
            $model->attributes = $post;
            if ($model->validate() && $model->save()) {
                $this->response(200, '出货成功');
                $this->app->end();
            }
        } else {
            $id = $this->request->getQuery('id', 0);
            $model->id = $id;
        }

        $cargo = Cargo::model()->findByPk($id);
        if (empty($cargo)) {
            $this->response(404, '找不到对应的货物');
        } else {
            $this->render('sales', array(
                'model' => $model,
                'cargo' => $cargo,
            ));
        }
    }
}