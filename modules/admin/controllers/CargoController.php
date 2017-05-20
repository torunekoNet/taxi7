<?php

/**
 * File: CargoController.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 18:25
 * Description:
 */
class CargoController extends Controller
{

    public function getActions()
    {
        return array('sales', 'stock', 'store', 'add', 'water', 'delete', 'edit', 'statistics');
    }

    public function createSearchCriteria($data = array(), $like = true)
    {
        $condition = '';
        $params = array();
        if (!empty($data)) {
            $con = array();
            foreach ($data as $key => $value) {
                if (empty($value)) continue;
                if ($like) {
                    $con[] = "`" . $key . "` LIKE :" . $key;
                    $params[$key] = '%' . $value . '%';
                } else {
                    $con[] = "`" . $key . "`=:" . $key;
                    $params[$key] = $value;
                }
            }
            $condition = join(' AND ', $con);
        }
        return array('condition' => $condition, 'params' => $params);
    }
}