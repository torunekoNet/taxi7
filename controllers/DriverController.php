<?php
/**
 * File: DriverController.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 2017/12/23 13:44
 * Description:
 */
class DriverController extends Controller
{
    public function getActions()
    {
        return array('driver', 'vehicle', 'record', 'add', 'statistic');
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