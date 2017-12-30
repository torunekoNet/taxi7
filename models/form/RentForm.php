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
        );
    }

    public function save()
    {
        if (empty($this->license)) return false;
        $vehicle = Vehicle::model()->findAllByAttributes(array(
            'license' => $this->license
        ));

        $app = Yii::app();
        $transaction = $app->db->beginTransaction();
        try {
            if (empty($vehicle)) {
                $vehicle = Vehicle::model();
            }

            $data = array(
                'license' => $this->license
            );
            //白
            if ($this->type == 0 || $this->type == 2) {
                $data['day_begin_time'] = $this->begin;
                $data['day_end_time'] = $this->end;
                $data['day_driver'] = $this->driver;
                $data['day_identity'] = $this->identity;
                $data['day_phone'] = $this->phone;
                $data['day_rent'] = round($this->rent * 100, 0);
            }
            //夜
            if ($this->type == 1 || $this->type == 2) {
                $data['night_begin_time'] = $this->begin;
                $data['night_end_time'] = $this->end;
                $data['night_driver'] = $this->driver;
                $data['night_identity'] = $this->identity;
                $data['night_phone'] = $this->phone;
                $data['night_rent'] = round($this->rent * 100, 0);
            }
            $vehicle->attributes = $data;
            if ($vehicle->save()) {
                //查看驾驶员表
                $driver = Driver::model()->findAllByAttributes(array(
                    'driver' => $this->driver
                ));
                if (empty($driver)) {
                    $driver = Driver::model();
                }
                $driver->attributes = array(
                    'driver' => $this->driver,
                    'identity' => $this->identity,
                    'phone' => $this->phone
                );
                if (!$driver->save()) {
                    throw new CDbException('更新驾驶员失败', 10, $driver->getErrors());
                }

                //写驾驶记录
                $driverVehicle = DriverVehicle::model();
                $driverVehicle->attributes = array(
                    'driver' => $this->driver,
                    'license' => $this->license,
                    'begin_time' => $this->begin,
                    'type' => $this->type,
                );
                if ($driverVehicle->save()) {
                    $transaction->commit();
                } else {
                    throw new CDbException('更新驾驶记录失败', 10, $driverVehicle->getErrors());
                }
            } else {
                throw new CDbException('更新车状态失败', 20, $vehicle->getErrors());
            }
        } catch (CDbException $e) {
            $transaction->rollback();
            $this->addErrors($e->errorInfo);
            return false;
        }

        return true;
    }

}