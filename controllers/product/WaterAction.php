<?php

/**
 * File: WaterAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/20 12:21
 * Description:
 */
class WaterAction extends RedAction
{

    public function run()
    {
        $operationType = $this->request->getQuery('operationType', 'sales');
        if (method_exists($this, $operationType)) {
            call_user_func(array($this, $operationType));
        } else {
            $this->sales();
        }
    }

    public function sales()
    {
        $post = array(
            'to' => $this->request->getQuery('to'),
            'comment' => $this->request->getQuery('comment')
        );
        $model = Sales::model();
        $model->attributes = $post;
        $this->search($model, $post);
    }

    public function stock()
    {
        $this->search(Stock::model());
    }

    private function search($model, $query = array())
    {
        $condition = $this->createSearchCriteria($query);
        $pager = new CPagination($model->count($condition));
        $pager->setPageSize(20);
        $condition['offset'] = $pager->getOffset();
        $condition['limit'] = $pager->getLimit();
        $condition['order'] = 'gmt_create desc';
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