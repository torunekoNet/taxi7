<?php

/**
 * file:UserController.php
 * author:Toruneko@outlook.com
 * date:2014-7-19
 * desc:用户中心
 */
class UserController extends Controller
{

    public function getActions()
    {
        return array('account', 'register', 'edit');
    }

    public function createSearchCriteria($data = array())
    {
        $condition = '';
        $params = array();
        if (!empty($data)) {
            $con = array();
            foreach ($data as $key => $value) {
                if (empty($value)) continue;
                $con[] = $key . '=:' . $key;
                $params[$key] = $value;
            }
            $condition = join(' AND ', $con);
        }
        return array('condition' => $condition, 'params' => $params);
    }
}
