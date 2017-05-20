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
        $this->request->redirect($this->app->createUrl('admin'));
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
}