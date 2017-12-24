<?php

/**
 * file:AccountController.php
 * author:Toruneko@outlook.com
 * date:2014-7-13
 * desc:登录入口
 */
class AccountController extends Controller
{

    public function init()
    {
        parent::init();

        $this->layout = '/layouts/main';
    }

    public function actionLogin()
    {
        $returnUrl = $this->request->getQuery('returnUrl');
        if (empty($returnUrl)) {
            $returnUrl = $this->createUrl('index/index');
        }
        if (!Yii::app()->user->isGuest) {
            $this->redirect($returnUrl);
        }

        $model = new LoginForm();
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                $this->redirect($returnUrl);
            }
        }

        $this->render('login', array('model' => $model));
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect($this->createUrl('login'));
    }

    public function actionSession()
    {
        if (Yii::app()->user->isGuest) {
            $this->response(-301, "redirect");
        } else {
            $this->response(0, "success", array(
                'username' => Yii::app()->user->username,
                'realname' => Yii::app()->user->realname
            ));
        }
    }

    public function getFilters()
    {
        return array();
    }

    /*
     * @see Controller::allowGuest()
     */
    public function allowGuest()
    {
        return true;
    }

    /*
     * @see Controller::allowHttpRequest()
     */
    public function allowHttpRequest()
    {
        return true;
    }

    /*
     * @see Controller::allowAjaxRequest()
     */
    public function allowAjaxRequest()
    {
        return true;
    }
}