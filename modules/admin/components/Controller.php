<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RedController
{
    public $layout = false;
    private $auth;

    public function init()
    {
        parent::init();

        $this->auth = $this->app->authManager;

        $this->setPageTitle(Yii::app()->name . " 管理系统");
    }

    public function actionIndex()
    {
        $operation = Operation::model()->findByAttributes(array(
            'module' => $this->getModule()->getId(),
            'controller' => $this->getId(),
            'action' => $this->getAction()->getId()
        ));
        if ($operation->getAttribute('level') == 1) {
            $maxLevel = 2;
        } else {
            $maxLevel = PHP_INT_MAX;
        }
        $operation = $this->auth->getOperationByPk($operation->getAttribute('id'));
        $child = $operation->getChild();
        usort($child, function ($a, $b) {
            if ($a->getRawData('sort') == $b->getRawData('sort')) return 0;
            if ($a->getRawData('sort') < $b->getRawData('sort')) {
                return 1;
            } else {
                return 0;
            }
        });
        $nav = array();
        foreach ($child as $item) {
            if ($item->getStatus() || $item->getLevel() > $maxLevel) continue;
            $nav[] = array($item->getName(),
                $this->app->createUrl($item->getModule() . '/' . $item->getController() . '/' . $item->getAction()));
        }

        $this->render('/public/nav', array('nav' => $nav));
    }

    public function getFilters()
    {
        return array(
            array('AccessControl'),
            array('AllowCheck')
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