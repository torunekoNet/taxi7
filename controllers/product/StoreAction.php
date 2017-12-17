<?php

/**
 * File: StoreAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 18:29
 * Description:
 */
class StoreAction extends RedAction
{

    public function run()
    {
        $query = array(
            'name' => $this->request->getQuery('name'),
            'number' => $this->request->getQuery('number')
        );
        $model = Cargo::model();
        $model->attributes = $query;
        $condition = $this->createSearchCriteria($query);
        $pager = new CPagination($model->count($condition));
        $pager->setPageSize(20);
        $condition['offset'] = $pager->getOffset();
        $condition['limit'] = $pager->getLimit();
        $condition['order'] = 'last_stor_time desc';
        $data = $model->findAll($condition);
        $this->response(0, "success", array(
            'list' => $data,
            'pager' => array(
                'pageSize' => $pager->getPageSize(),
                'pageCount' => $pager->getPageCount(),
                'itemCount' => (int) $pager->getItemCount(),
                'currentPage' => $pager->getCurrentPage()
            )
        ));
    }
}