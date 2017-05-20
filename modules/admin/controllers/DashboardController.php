<?php

/**
 * file:DashboardController.php
 * author:Toruneko@outlook.com
 * date:2014-7-14
 * desc:仪表盘
 */
class DashboardController extends Controller
{

    public function actionSysInfo()
    {
        $this->render('sysInfo');
    }

    public function actionUserInfo()
    {
        $this->render('userInfo');
    }
}