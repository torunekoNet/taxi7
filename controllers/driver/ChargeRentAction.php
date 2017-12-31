<?php
/**
 * File: ChargeRentAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 2017/12/31 11:05
 * Description:
 */
class ChargeRentAction extends RedAction
{

    public function run()
    {
        $model = new ChargeRentForm();
        $model->attributes = array(
            'rentId' => $this->request->getPost('rentId'),
            'date' => $this->request->getPost('date'),
            'rent' => $this->request->getPost('rent'),
            'comment' => $this->request->getPost('comment'),
            'type' => $this->request->getPost('type')
        );
        if ($model->validate() && $model->save()) {
            $this->response(0, '操作成功');
        } else {
            $this->response(-1, '操作失败', $model->getErrors());
        }
    }
}