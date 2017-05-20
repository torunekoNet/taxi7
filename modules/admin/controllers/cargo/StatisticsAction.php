<?php

/**
 * File: StatisticsAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/6/9 12:50
 * Description:
 */
class StatisticsAction extends RedAction
{

    public function run()
    {
        $operationType = $this->request->getQuery('operationType', 'load');
        if (method_exists($this, $operationType)) {
            call_user_func(array($this, $operationType));
        } else {
            $this->load();
        }
    }

    public function load()
    {
        $toyear = date('Y');
        $years = range($toyear - 9, $toyear);
        $year = array();
        foreach ($years as $y) {
            $year[$y] = $y . '年';
        }
        $this->render('statistics', array(
            'year' => $year,
            'month' => array(
                '全年', '1月', '2月', '3月', '4月', '5月', '6月',
                '7月', '8月', '9月', '10月', '11月', '12月'
            ),
        ));
    }

    /**
     * 十年报表
     */
    public function year()
    {
        $redis = $this->app->redis;

        $today = date('Y');
        $years = range($today - 9, $today);

        $sales = array(); // 出货
        $stock = array(); // 进货
        foreach ($years as $year) {
            if (($data = $redis->get($year)) == false) {
                $data = array(
                    'sales' => Sales::model()->sum('price', 'gmt_year=:y', array('y' => $year)),
                    'stock' => Stock::model()->sum('price', 'gmt_year=:y', array('y' => $year))
                );
                if ($year != $today) {
                    $redis->set($year, $data);
                }
            }
            $sales[] = $data['sales'] / 100;
            $stock[] = $data['stock'] / 100;
        }

        foreach ($years as &$year) $year .= '年';
        $this->response(200, 'success', array(
            'xAxis' => $years,
            'sales' => $sales,
            'stock' => $stock,
            'title' => '十年报表',
        ));
    }

    /**
     * 年度报表
     */
    public function month()
    {
        $redis = $this->app->redis;

        $Ymd = $this->getYmd();
        $year = $Ymd['year'];
        $toyear = date('Y');

        if ($year == $toyear) {
            $today = date('n');
            $month = range(1, $today);
        } else {
            $month = range(1, 12);
        }

        $sales = array(); // 出货
        $stock = array(); // 进货
        foreach ($month as $mon) {
            if (($data = $redis->get($year . $mon)) == false) {
                $data = array(
                    'sales' => Sales::model()->sum('price', 'gmt_year=:y AND gmt_month=:m', array(
                        'y' => $year,
                        'm' => sprintf("%02d", $mon),
                    )),
                    'stock' => Stock::model()->sum('price', 'gmt_year=:y AND gmt_month=:m', array(
                        'y' => $year,
                        'm' => sprintf("%02d", $mon),
                    ))
                );
                if (!isset($today) || $mon != $today) {
                    $redis->set($year . $mon, $data);
                }
            }
            $sales[] = $data['sales'] / 100;
            $stock[] = $data['stock'] / 100;
        }

        foreach ($month as &$mon) $mon .= '月';
        $this->response(200, 'success', array(
            'xAxis' => $month,
            'sales' => $sales,
            'stock' => $stock,
            'title' => $year . '年度报表',
        ));
    }

    /**
     * 月度报表
     */
    public function day()
    {
        $redis = $this->app->redis;

        $Ymd = $this->getYmd();
        $year = $Ymd['year'];
        $month = $Ymd['month'];
        $toyear = date('Y');
        $tomonth = date('n');
        if ($year == $toyear && $month == $tomonth) {
            $today = date('j');
            $days = range(1, $today);
        } else {
            $days = range(1, $this->getDayOfYm($year, $month));
        }

        $sales = array(); // 出货
        $stock = array(); // 进货
        foreach ($days as $day) {
            if (($data = $redis->get($year . $month . $day)) == false) {
                $data = array(
                    'sales' => Sales::model()->sum('price', 'gmt_year=:y AND gmt_month=:m AND gmt_day=:d', array(
                        'y' => $year,
                        'm' => sprintf("%02d", $month),
                        'd' => sprintf("%02d", $day),
                    )),
                    'stock' => Stock::model()->sum('price', 'gmt_year=:y AND gmt_month=:m AND gmt_day=:d', array(
                        'y' => $year,
                        'm' => sprintf("%02d", $month),
                        'd' => sprintf("%02d", $day),
                    ))
                );
                if (!isset($today) || ($year != $toyear && $month != $tomonth)) {
                    $redis->set($year . $month . $day, $data);
                }
            }
            $sales[] = $data['sales'] / 100;
            $stock[] = $data['stock'] / 100;
        }

        foreach ($days as &$day) $day .= '日';
        $this->response(200, 'success', array(
            'xAxis' => $days,
            'sales' => $sales,
            'stock' => $stock,
            'title' => $year . '年' . $month . '月报表',
        ));
    }

    private function getYmd()
    {
        $Ymd = explode('-', date('Y-n'));
        $year = $this->request->getQuery('year', $Ymd[0]);
        $month = $this->request->getQuery('month', $Ymd[1]);

        if ($month < 1) $month = 1;
        if ($month > 12) $month = 12;

        if ($year > $Ymd[0]) $year = $Ymd[0];
        if ($year == $Ymd[0]) {
            if ($month > $Ymd[1]) $month = $Ymd[1];
        }

        return array(
            'year' => $year,
            'month' => $month,
        );
    }

    private function getDayOfYm($year, $month)
    {
        switch ($month) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                return 31;
            case 4:
            case 6:
            case 9:
            case 11:
                return 30;
            case 2:
                if ((($year % 4 == 0) && ($year % 100 != 0)) || ($year % 400 == 0)) {
                    return 29;
                } else {
                    return 28;
                }
        }

        return 1;
    }

    /**
     * 类目报表
     */
    public function category()
    {

    }
}