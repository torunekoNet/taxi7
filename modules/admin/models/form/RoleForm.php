<?php

/**
 * File: RoleForm.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 00:15
 * Description:
 */
class RoleForm extends CFormModel
{
    public $id;
    public $name;
    public $description;
    public $status;

    public $module;
    public $controller;
    public $action;
    public $sort;

    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('name', 'required', 'message' => '请输入' . $labels['name']),
            array('id, status', 'numerical', 'integerOnly' => true),
            array('description, module, controller, action, sort', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name' => '名称',
            'description' => '描述',
            'status' => '禁用',
        );
    }

    public function save()
    {

        try {
            if ($this->id) {
                $model = Role::model()->findByPk($this->id);
                if (empty($model)) throw new CDbException('参数出错', 1, array());
            } else {
                $model = new Role();
            }

            $model->attributes = array(
                'name' => $this->name,
                'description' => $this->description,
                'status' => $this->status
            );

            if ($model->save() === false)
                throw new CDbException('更新用户出错', 2, $model->getErrors());

        } catch (CDbException $e) {
            $this->addErrors($e->errorInfo);
            return false;
        }

        return true;
    }
}