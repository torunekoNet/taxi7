<?php

/**
 * file:IndexController.php
 * author:Toruneko@outlook.com
 * date:2014-7-12
 * desc:管理入口
 */
class IndexController extends Controller
{

    public function init()
    {
        parent::init();

        $this->layout = '/layouts/index';
    }

    public function allowAjaxRequest()
    {
        return false;
    }

    public function allowHttpRequest()
    {
        return true;
    }

    public function getFilters()
    {
        return array();
    }
}