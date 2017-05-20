<?php

/**
 * file:ErrorController.php
 * author:Toruneko@outlook.com
 * date:2014-7-13
 * desc:ErrorController
 */
class ErrorController extends Controller
{

    public function actionIndex()
    {
        if ($error = $this->app->errorHandler->error) {
            $this->render('error', $error);
        }
    }

    public function allowGuest()
    {
        return true;
    }

    public function allowAjaxRequest()
    {
        return true;
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