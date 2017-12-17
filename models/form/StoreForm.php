<?php

/**
 * File: StoreForm.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/20 10:25
 * Description:
 */
class StoreForm extends CFormModel
{

    public $id;
    public $number;
    public $name;
    public $price;
    public $comment;

    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('number', 'required', 'message' => '请输入' . $labels['number']),
            array('name', 'required', 'message' => '请输入' . $labels['name']),
            array('price', 'required', 'message' => '请输入' . $labels['price']),
            array('id, comment', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'number' => '编号',
            'name' => '名称',
            'price' => '建议价',
            'comment' => '备注',
        );
    }

    public function save()
    {
        if (empty($this->id)) {
            $model = new Cargo();
        } else {
            $model = Cargo::model()->findByPk($this->id);
            if (empty($model)) return false;
        }

        if ($this->id) {
            $model->attributes = array(
                'number' => $this->number,
                'name' => $this->name,
                'price' => round($this->price * 100, 0),
                'comment' => $this->comment,
            );
        } else {
            $model->attributes = array(
                'number' => $this->number,
                'name' => $this->name,
                'price' => round($this->price * 100, 0),
                'comment' => $this->comment,
                'store' => 2147483647, // 直接设置为最大值
                'sales' => 0,
                'gmt_create' => time(),
                'last_stor_number' => 0,
                'last_stor_time' => 0,
            );
        }

        return $model->save();
    }
}