<?php

/**
 * File: AllowCheck.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/28 13:21
 * Description:
 */
class AllowCheck extends CFilter
{

    public function preFilter($filterChain)
    {
        $parameters = $this->getParameterByCA($filterChain->controller->getId(), $filterChain->controller->action->getId());
        if (empty($parameters)) return true;

        $auth = Yii::app()->getAuthManager();
        $uid = Yii::app()->user->getId();
        $allow = true;
        foreach ($parameters as $param) {
            switch ($param['type']) {
                case "group":
                    $allow = $allow && $this->checkGroup($auth, $uid, $param['data']);
                    break;
                case "role":
                    $allow = $allow && $this->checkRole($auth, $uid, $param['data']);
                    break;
                case "user":
                    $allow = $allow && $this->checkUser($auth, $uid, $param['data']);
                    break;
                case "operation":
                    $allow = $allow && $this->checkOperation($auth, $uid, $param['data']);
            }
        }

        if ($allow) return $allow;
        else $filterChain->controller->response(403, '无权操作');
    }

    private function checkGroup($auth, $uid, $gid)
    {
        $group = $auth->getGroupByUserId($uid);

        foreach ($group as $item) {
            if ($item->hasChild($gid)) return true;
        }
        return false;
    }

    private function checkRole($auth, $uid, $rid)
    {
        $role = $auth->getRoleByUserId($uid);

        foreach ($role as $item) {
            if ($item->hasChild($rid)) return true;
        }
        return false;
    }

    private function checkUser($auth, $uid, $tid)
    {
        $myGroup = $auth->getGroupByUserId($uid);
        $targetGroup = $auth->getGroupByUserId($tid);

        if (empty($targetGroup)) return true;

        foreach ($myGroup as $item) {
            foreach ($targetGroup as $target) {
                if ($item->getLft() < $target->getLft() && $target->getRgt() < $item->getRgt()) {
                    return true;
                }
            }
        }

        return false;
    }

    private function checkOperation($auth, $uid, $oid)
    {
        $operation = $auth->getOperationByPk($oid);
        if (empty($operation)) return false;

        return $auth->checkAccess(array(
            'module' => $operation->getModule(),
            'controller' => $operation->getController(),
            'action' => $operation->getAction()
        ), $uid);
    }

    private function getParameterByCA($controller, $action)
    {
        $request = Yii::app()->request;
        $ca = Yii::app()->params['allowCheck'];
        $method = strtolower($request->getRequestType());
        if (isset($ca[$controller]) && isset($ca[$controller][$action])) {
            $rules = $ca[$controller][$action];
        } else {
            return array();
        }

        $parameter = array();
        foreach ($rules as $rule) {
            if ($rule[2] == $method) {
                if ($method == 'get') $method = 'query';
                $func = 'get' . ucfirst($method);
                if (method_exists($request, $func)) {
                    if (is_array($rule[0])) {
                        $data = call_user_func(array($request, $func), $rule[0][0]);
                        if (!empty($data)) {
                            $parameter[] = array(
                                'data' => $data[$rule[0][1]],
                                'type' => $rule[1]
                            );
                        }
                    } else {
                        $data = call_user_func(array($request, $func), $rule[0]);
                        if (!empty($data)) {
                            $parameter[] = array(
                                'data' => $data,
                                'type' => $rule[1]
                            );
                        }
                    }
                }
            }
        }

        return $parameter;
    }

}