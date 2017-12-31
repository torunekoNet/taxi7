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
    public $term;

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
            array('term', 'required', 'message' => $labels['term'] . '错误'),
            array('license', 'safe'),
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
            'rent' => '日租金',
            'term' => '租期'
        );
    }

    public function save()
    {
        if (empty($this->license)) return false;

        $app = Yii::app();
        $transaction = $app->db->beginTransaction();
        try {
            //写驾驶记录
            $driverVehicle = new DriverVehicle();
            $driverVehicle->attributes = array(
                'driver' => $this->driver,
                'license' => $this->license,
                'begin_time' => date('Y-m-d', $this->begin),
                'type' => $this->type,
                'rent' => 0
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

            $data = array(
                'license' => $this->license
            );
            //白
            if ($this->type == 0 || $this->type == 2) {
                $data['day_begin_time'] = date('Y-m-d', $this->begin);
                $data['day_end_time'] = date('Y-m-d', $this->end);
                $data['day_driver'] = $this->driver;
                $data['day_identity'] = $this->identity;
                $data['day_phone'] = $this->phone;
                $data['day_rent'] = round($this->rent * 100, 0);
                $data['day_term'] = $this->term;
                $data['day_record'] = $driverVehicle->getPrimaryKey();
            }
            //夜
            if ($this->type == 1 || $this->type == 2) {
                $data['night_begin_time'] = date('Y-m-d', $this->begin);
                $data['night_end_time'] = date('Y-m-d', $this->end);
                $data['night_driver'] = $this->driver;
                $data['night_identity'] = $this->identity;
                $data['night_phone'] = $this->phone;
                $data['night_rent'] = round($this->rent * 100, 0);
                $data['night_term'] = $this->term;
                $data['night_record'] = $driverVehicle->getPrimaryKey();
            }

            $vehicle->attributes = $data;
            if (!$vehicle->save()) {
                throw new CDbException('更新车状态失败', 20, $vehicle->getErrors());
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