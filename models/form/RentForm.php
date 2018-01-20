<?php

/**
 * File: AentForm.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 2017/12/30 08:43
 * Description:
 */
class RentForm extends CFormModel
{

    public $license;
    public $driver;
    public $identity;
    public $phone;
    public $begin;
    public $end;
    public $type;
    public $rent;
    public $comment;

    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('license', 'required', 'message' => '请输入' . $labels['license']),
            array('driver', 'required', 'message' => '请输入' . $labels['driver']),
            array('identity', 'required', 'message' => '请输入' . $labels['identity']),
            array('phone', 'required', 'message' => '请输入' . $labels['phone']),
            array('begin', 'required', 'message' => '请选择' . $labels['begin']),
            array('end', 'required', 'message' => '请选择' . $labels['end']),
            array('type', 'required', 'message' => '请选择' . $labels['type']),
            array('rent', 'required', 'message' => '请选择' . $labels['rent']),
            array('license, comment', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'license' => '车牌',
            'driver' => '驾驶证',
            'identity' => '证件号码',
            'phone' => '手机号码',
            'begin' => '开始时间',
            'end' => '结束时间',
            'type' => '班次',
            'rent' => '日租金'
        );
    }

    public function save()
    {
        if (empty($this->license)) return false;

        $app = Yii::app();
        $transaction = $app->db->beginTransaction();
        try {
            $totalTime = round(($this->end - $this->begin) / 86400) + 1;
            //写驾驶记录
            $driverVehicle = new DriverVehicle();
            $driverVehicle->attributes = array(
                'driver' => $this->driver,
                'license' => $this->license,
                'begin_time' => date('Y-m-d', $this->begin),
                'end_time' => date('Y-m-d', $this->end),
                'total_time' => $totalTime,
                'type' => $this->type,
                'rent' => round($this->rent * 100, 0),
                'comment' => $this->comment
            );

            if (!$driverVehicle->save()) {
                throw new CDbException('写驾驶记录失败', 10, $driverVehicle->getErrors());
            }

            $vehicle = Vehicle::model()->findByAttributes(array(
                'license' => $this->license
            ));
            if (empty($vehicle)) {
                $vehicle = new Vehicle();
            }
            if ($this->type == 0) {
                $vehicle->attributes = array(
                    'license' => $this->license,
                    'day_rent' => round($this->rent * 100, 0)
                );
            } elseif ($this->type == 1) {
                $vehicle->attributes = array(
                    'license' => $this->license,
                    'night_rent' => round($this->rent * 100, 0)
                );
            } else {
                $vehicle->attributes = array(
                    'license' => $this->license,
                    'rent' => round($this->rent * 100, 0)
                );
            }
            if (!$vehicle->save()) {
                throw new CDbException('更新车数据失败', 10, $vehicle->getErrors());
            }

            //查看驾驶员表
            $driver = Driver::model()->findByAttributes(array(
                'name' => $this->driver
            ));
            if (empty($driver)) {
                $driver = new Driver();
            }
            $driver->attributes = array(
                'name' => $this->driver,
                'identity' => $this->identity,
                'phone' => $this->phone
            );
            if (!$driver->save()) {
                throw new CDbException('更新驾驶员失败', 10, $driver->getErrors());
            }

            $transaction->commit();
        } catch (CDbException $e) {
            $transaction->rollback();
            $this->addErrors($e->errorInfo);
            return false;
        }

        return true;
    }

}