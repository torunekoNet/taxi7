<?php

/**
 * File: CargoForm.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 18:32
 * Description:
 */
class StockForm extends CFormModel
{

    public $id;
    public $price;
    public $amount;
    public $comment;

    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('price', 'required', 'message' => '请输入' . $labels['price']),
            array('amount', 'required', 'message' => '请输入' . $labels['amount']),
            array('id, comment', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'number' => '编号',
            'name' => '名称',
            'price' => '进价',
            'amount' => '数量',
            'comment' => '备注',
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

            $cargo->store += $this->amount;
            $cargo->last_stor_number = $this->amount;
            $cargo->last_stor_time = time();
            if ($cargo->save()) {
                $Ymd = explode('-', date('Y-m-d'));
                $stock = new Stock();
                $stock->attributes = array(
                    'cargo_id' => $cargo->id,
                    'cargo_name' => $cargo->name,
                    'amount' => $this->amount,
                    'price' => round($this->price * 100, 0),
                    'comment' => $this->comment,
                    'gmt_create' => time(),
                    'gmt_year' => $Ymd[0],
                    'gmt_month' => $Ymd[1],
                    'gmt_day' => $Ymd[2],
                    'operator' => Yii::app()->user->getName(),
                );
                if ($stock->save()) {
                    $transaction->commit();
                } else {
                    throw new CDbException('更新流水表出错', 10, $stock->getErrors());
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