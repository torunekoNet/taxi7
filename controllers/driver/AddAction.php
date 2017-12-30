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
        $model = new RentForm();
        $model->attributes = array(
            'license' => $this->request->getPost('license'),
            'driver' => $this->request->getPost('driver'),
            'identity' => $this->request->getPost('identity'),
            'phone' => $this->request->getPost('phone'),
            'begin' => $this->request->getPost('begin'),
            'end' => $this->request->getPost('end'),
            'type' => $this->request->getPost('type'),
            'rent' => $this->request->getPost('rent')
        );
        if ($model->validate() && $model->save()) {
            $this->response(0, '添加成功');
        } else {
            $this->response(-1, '添加失败', $model->getErrors());
        }
    }
}