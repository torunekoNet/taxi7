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
        $model->attributes = array(
            'number' => $this->request->getPost('number'),
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'comment' => $this->request->getPost('comment')
        );
        if ($model->validate() && $model->save()) {
            $this->response(0, '添加成功');
        } else {
            $this->response(-1, '添加失败', $model->getErrors());
        }
    }
}