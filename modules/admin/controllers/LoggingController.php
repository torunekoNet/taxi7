<?php

/**
 * file:LoggingController.php
 * author:Toruneko@outlook.com
 * date:2014-7-14
 * desc:日志中心
 */
class LoggingController extends Controller
{

    public function search($begin, $end)
    {
        $condition = 'time>=:begin AND time<=:end';
        $params = array('begin' => $begin, 'end' => $end);
        $model = Logging::model();

        $pager = new CPagination($model->count($condition, $params));
        $pager->setPageSize(100);
        $logging = $model->findAll(array(
            'condition' => $condition,
            'params' => $params,
            'offset' => $pager->getOffset(),
            'limit' => $pager->getLimit(),
            'order' => 'time desc',
        ));

        $this->render('index', array(
            'logging' => new RedArrayDataProvider($logging),
            'pager' => $pager
        ));
    }

    public function actionAll()
    {
        $this->search(0, time());
    }

    public function actionToday()
    {
        $this->search(strtotime('today'), time());
    }

    public function actionYesterday()
    {
        $begin = strtotime('yesterday');
        $this->search($begin, $begin + 86399);
    }

    public function actionWeek()
    {
        $this->search(strtotime('monday this week'), time());
    }

    public function actionMonth()
    {
        $this->search(strtotime('first day of this month midnight'), time());
    }
}