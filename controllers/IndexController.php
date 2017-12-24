<?php

/**
 * file:SiteController.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc: 主站
 */
class IndexController extends Controller
{

    public function actionIndex()
    {
        $this->layout = '/layouts/react';
        $this->render('index', array(
            'jsVersion' => '1512802105'
        ));
    }

    public function actionDriver()
    {
        $this->layout = '/layouts/react';
        $this->render('driver', array(
            'jsVersion' => '1512802105'
        ));
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        } else {
            $this->render('error');
        }
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