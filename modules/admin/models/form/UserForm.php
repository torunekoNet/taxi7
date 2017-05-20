<?php

/**
 * File: UserForm.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/27 23:52
 * Description: 用户表单
 */
class UserForm extends CFormModel
{
    public $id;
    public $username;
    public $realname;
    public $nickname;
    public $email;
    public $password;
    public $confirm;
    public $state;
    public $approved;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('realname', 'required', 'message' => '请输入' . $labels['realname']),
            array('nickname', 'required', 'message' => '请输入' . $labels['nickname']),
            array('email', 'required', 'message' => '请输入' . $labels['email']),
            array('confirm', 'verify', 'message' => '二次' . $labels['password'] . '错误'),
            array('state, approved', 'numerical', 'integerOnly' => true),
            array('id, username', 'safe'),
        );
    }

    /**
     * 二次密码验证
     * @return bool
     */
    public function verify()
    {
        $this->password = trim($this->password);
        if (!empty($this->password)) {
            return $this->password == $this->confirm;
        }
        return true;
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'username' => '用户名',
            'realname' => '姓名',
            'nickname' => '昵称',
            'email' => '邮箱',
            'password' => '密码',
            'confirm' => '验证密码',
            'state' => '禁用',
            'approved' => '重置密码重试次数',
        );
    }

    public function save()
    {
        $app = Yii::app();

        $transaction = $app->db->beginTransaction();
        try {
            if (!$this->validate()) throw new CDbException('参数出错', 0, array());

            $user = User::model()->findByPk($this->id);
            if (!$user) throw new CDbException('参数出错', 1, array());
            if ($user->state == 2) throw new CDbException('不能修改的用户', 0, array());
            $attributes = array();

            if (!empty($this->password)) {
                $attributes['password'] = CPasswordHelper::hashPassword($this->password);
                $attributes['uuid'] = $app->getSecurityManager()->generateUUID($user->id . $attributes['password']);
            }

            if ($this->approved == true) {
                $attributes['approved'] = 5;
            }

            $attributes = array_merge($attributes, array(
                'realname' => $this->realname,
                'nickname' => $this->nickname,
                'email' => $this->email,
            ));
            if ($this->state >= 0) {
                $attributes['state'] = $this->state ? 1 : 0;
            }
            $user->attributes = $attributes;

            if ($user->save() === false) throw new CDbException('更新用户出错', 30, $user->getErrors());

            $transaction->commit();
        } catch (CDbException $e) {
            $transaction->rollback();
            $this->addErrors($e->errorInfo);
            return false;
        }

        return true;
    }
}
