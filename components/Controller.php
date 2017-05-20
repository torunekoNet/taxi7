<?php

/**
 * file:Controller.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc:控制器基类
 */
class Controller extends RedController
{
    public $name;
    public $keyword = array();
    public $description = '';

    public function init()
    {
        parent::init();

        $this->cs->registerPackage('bootstrap');
    }

    public function setName($name)
    {
        $this->name .= $name;
    }

    public function setKeyword($keyword)
    {
        $this->keyword[] = $keyword;
    }

    public function setDescription($desc)
    {
        $this->description = $desc;
    }

    public function allowAjaxRequest()
    {
        return true;
    }
}