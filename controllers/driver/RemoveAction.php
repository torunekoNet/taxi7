<?php

/**
 * File: AddAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/20 11:00
 * Description:
 */
class RemoveAction extends RedAction
{

    public function run()
    {
        $id = $this->request->getPost('id');
        $model = DriverVehicle::model()->findByPk($id);
        if ($model && $model->delete()) {
            $this->response(0, '删除成功');
        } else {
            $this->response(-1, '删除失败', $model->getErrors());
        }
    }
}