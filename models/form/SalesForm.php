<?php

/**
 * File: SalesForm.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/20 10:25
 * Description:
 */
class SalesForm extends CFormModel
{

    public $id;
    public $amount;
    public $price;
    public $to;
    public $comment;

    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('price', 'required', 'message' => '请输入' . $labels['price']),
            array('amount', 'required', 'message' => '请输入' . $labels['amount']),
            array('to', 'required', 'message' => '请输入' . $labels['to']),
            array('id, comment', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'number' => '编号',
            'name' => '名称',
            'price' => '售价',
            'amount' => '数量',
            'comment' => '备注',
            'to' => '去向',
        );
    }

    public function save()
    {
        if (empty($this->id)) return false;
        $cargo = Cargo::model()->findByPk($this->id);
        if (empty($cargo)) return false;

        $app = Yii::app();
        $transaction = $app->db->beginTransaction();
        try {
            $cargo->store -= $this->amount;
            $cargo->sales += $this->amount;
            if ($cargo->store < 0) {
                throw new CDbException('库存不足', 0, array('amount' => array("库存不足")));
            }

            if ($cargo->save()) {
                $Ymd = explode('-', date('Y-m-d'));
                $sales = new Sales();
                $sales->attributes = array(
                    'cargo_id' => $cargo->id,
                    'cargo_name' => $cargo->name,
                    'amount' => $this->amount,
                    'price' => round($this->price * 100, 0),
                    'to' => $this->to,
                    'comment' => $this->comment,
                    'gmt_create' => time(),
                    'gmt_year' => $Ymd[0],
                    'gmt_month' => $Ymd[1],
                    'gmt_day' => $Ymd[2],
                    'operator' => Yii::app()->user->getName(),
                );
                if ($sales->save()) {
                    $transaction->commit();
                } else {
                    throw new CDbException('更新流水表出错', 10, $sales->getErrors());
                }
            } else {
                throw new CDbException('更新库存出错', 20, $cargo->getErrors());
            }
        } catch (CDbException $e) {
            $transaction->rollback();
            $this->addErrors($e->errorInfo);
            return false;
        }

        return true;
    }

}