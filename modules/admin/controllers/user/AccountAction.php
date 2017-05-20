<?php

/**
 * File: AccountAction.php
 * User: daijianhao@zhubajie.com
 * Date: 14-8-18 14:59
 * Description:
 */
class AccountAction extends RedAction
{
    public function run()
    {
        $query = $this->request->getPost('User', array());
        $model = User::model();
        $model->attributes = $query;
        $condition = $this->createSearchCriteria($query);
        $pager = new CPagination($model->count($condition));
        $pager->setPageSize(20);
        $condition['offset'] = $pager->getOffset();
        $condition['limit'] = $pager->getLimit();
        $condition['order'] = 'sign_up_time desc';
        $data = $model->findAll($condition);
        $this->render('account', array(
            'data' => new RedArrayDataProvider($data),
            'pager' => $pager,
            'model' => $model,
        ));
    }
}