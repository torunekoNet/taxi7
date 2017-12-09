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

        $this->setPageTitle(Yii::app()->name . " 管理系统");
    }

    public function getFilters()
    {
        return array(
            array('AccessControl')
        );
    }

    /*
     * @see RedController::accessDenied()
     */
    public function accessDenied($role)
    {
        $this->response(403, '没有访问权限');
    }

    /*
     * @see RedController::allowAjaxRequest()
     */
    public function allowAjaxRequest()
    {
        return true;
    }

    /*
     * @see RedController::allowHttpRequest()
     */
    public function allowHttpRequest()
    {
        return false;
    }

    /*
     * @see RedController::allowGuest()
     */
    public function allowGuest()
    {
        $this->redirect($this->createUrl('account/login'));
    }

    public function missingAction($actionID)
    {
        throw new CHttpException(200, Yii::t('yii', 'The system is unable to find the requested action "{action}".',
            array('{action}' => $actionID == '' ? $this->defaultAction : $actionID)));
    }
}