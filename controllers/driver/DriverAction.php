<?php
/**
 * File: DriverAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 2017/12/30 08:38
 * Description:
 */
class DriverAction extends RedAction
{

    public function run()
    {
        $query = array(
            'name' => $this->request->getQuery('name')
        );
        $model = Driver::model();
        $model->attributes = $query;
        $condition = $this->createSearchCriteria($query);
        $data = $model->findAll($condition);
        $this->response(0, "success", array(
            'list' => $data
        ));
    }
}