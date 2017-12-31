<?php

/**
 * File: ChargeRentForm.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 2017/12/31 11:07
 * Description:
 */
class ChargeRentForm extends CFormModel
{

    public $rentId;
    public $date;
    public $rent;
    public $comment;
    public $type;

    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('rentId', 'required', 'message' => '请输入' . $labels['rentId']),
            array('date', 'required', 'message' => '请输入' . $labels['date']),
            array('rent', 'required', 'message' => '请输入' . $labels['rent']),
            array('type', 'required', 'message' => '请选择' . $labels['type']),
            array('rentId, comment', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'rentId' => '编号',
            'date' => '实际日期',
            'rent' => '实际租金',
            'type' => '班次',
            'comment' => '备注'
        );
    }

    public function save()
    {
        if (empty($this->rentId)) return false;

        $app = Yii::app();
        $transaction = $app->db->beginTransaction();
        try {
            $vehicle = Vehicle::model()->findByPk($this->rentId);
            if (empty($vehicle)) {
                return false;
            }

            $recordId = 0;
            $temp = ($vehicle->day_record == $vehicle->night_record);
            if ($this->type == 0 || $temp) {
                //白 或者全天
                $recordId = $vehicle->day_record;
                $vehicle->attributes = array(
                    'day_begin_time' => null,
                    'day_end_time' => null,
                    'day_driver' => null,
                    'day_identity' => null,
                    'day_phone' => null,
                    'day_rent' => 0,
                    'day_term' => 0,
                    'day_record' => 0
                );
            }
            if ($this->type == 1 || $temp) {
                //夜
                $recordId = $vehicle->night_record;
                $vehicle->attributes = array(
                    'night_begin_time' => null,
                    'night_end_time' => null,
                    'night_driver' => null,
                    'night_identity' => null,
                    'night_phone' => null,
                    'night_rent' => 0,
                    'night_term' => 0,
                    'night_record' => 0
                );
            }

            if ($recordId == 0) {
                return false;
            }
            if ($vehicle->save()) {

                //写驾驶记录
                $driverVehicle = DriverVehicle::model()->findByPk($recordId);
                $driverVehicle->attributes = array(
                    'end_time' => date('Y-m-d', $this->date),
                    'rent' => round($this->rent * 100, 0),
                    'comment' => $this->comment
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