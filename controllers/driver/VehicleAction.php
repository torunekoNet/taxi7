<?php
/**
 * File: VehicleAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 2017/12/30 08:31
 * Description:
 */
class VehicleAction extends RedAction
{

    public function run()
    {
        $query = array(
            'license' => $this->request->getQuery('license')
        );
        $model = Vehicle::model();
        $model->attributes = $query;
        $condition = $this->createSearchCriteria($query);
//        $pager = new CPagination($model->count($condition));
//        $pager->setPageSize(20);
//        $condition['offset'] = $pager->getOffset();
//        $condition['limit'] = $pager->getLimit();
        $data = $model->findAll($condition);
        $this->response(0, "success", array(
            'list' => $data,
//            'pager' => array(
//                'pageSize' => $pager->getPageSize(),
//                'pageCount' => $pager->getPageCount(),
//                'itemCount' => (int) $pager->getItemCount(),
//                'currentPage' => $pager->getCurrentPage()
//            )
        ));
    }
}