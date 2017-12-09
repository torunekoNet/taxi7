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
        $query = $this->request->getQuery('Cargo', array());
        $model = Cargo::model();
        $model->attributes = $query;
        $condition = $this->createSearchCriteria($query);
        $pager = new CPagination($model->count($condition));
        $pager->setPageSize(20);
        $condition['offset'] = $pager->getOffset();
        $condition['limit'] = $pager->getLimit();
        $condition['order'] = 'last_stor_time desc';
        $data = $model->findAll($condition);
        $this->render('cargo', array(
            'data' => new RedArrayDataProvider($data),
            'pager' => $pager,
            'model' => $model,
        ));
    }
}