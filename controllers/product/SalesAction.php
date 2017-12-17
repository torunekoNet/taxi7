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
        $model->attributes = array(
            'id' => $this->request->getPost('productId'),
            'amount' => $this->request->getPost('amount'),
            'price' => $this->request->getPost('price'),
            'to' => $this->request->getPost('to'),
            'comment' => $this->request->getPost('comment')
        );
        if ($model->validate() && $model->save()) {
            $this->response(0, '出货成功');
        } else {
            $this->response(-1, '出货失败', $model->getErrors());
        }
    }
}