<?php

/**
 * File: RecordAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 2017/12/30 08:40
 * Description:
 */
class StatisticAction extends RedAction
{

    public function run()
    {
        $query = array(
            'driver' => $this->request->getQuery('driver'),
            'license' => $this->request->getQuery('license'),
        );
        $model = DriverVehicle::model();
        $model->attributes = $query;
        $condition = $this->createSearchCriteria($query);
        if (empty($condition['condition'])) {
            $condition['condition'] .= '`end_time`>=:begin AND `end_time`<=:end';
        } else {
            $condition['condition'] .= ' AND `end_time`>=:begin AND `end_time`<=:end';
        }
        $condition['params']['begin'] = $this->request->getQuery('begin_time');
        $condition['params']['end'] = $this->request->getQuery('end_time');

        $pager = new CPagination($model->count($condition));
        $pager->setPageSize(20);
        $condition['offset'] = $pager->getOffset();
        $condition['limit'] = $pager->getLimit();
        $condition['order'] = 'begin_time desc, id desc';
        $data = $model->findAll($condition);
        $this->response(0, "success", array(
            'list' => $data,
            'sum' => $model->sum('rent', $condition['condition'], $condition['params']),
            'total' => $model->sum('total_time', $condition['condition'], $condition['params']),
            'pager' => array(
                'pageSize' => $pager->getPageSize(),
                'pageCount' => $pager->getPageCount(),
                'itemCount' => (int)$pager->getItemCount(),
                'currentPage' => $pager->getCurrentPage()
            )
        ));
    }
}