<?php

/**
 * File: DeleteAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/27 09:56
 * Description:
 */
class DeleteAction extends RedAction
{

    public function run($id)
    {
        $cargo = Cargo::model()->findByPk($id);
        if (empty($cargo)) {
            $this->response(-1, "不存在此ID");
        } else {
            if ($cargo->delete()) {
                $this->response(0, "删除成功");
            } else {
                $this->response(-1, "删除失败");
            }
        }
    }
}