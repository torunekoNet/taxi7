<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminIdentity extends RedUserIdentity
{
    const ERROR_NOT_LOGIN = 3;

    public $errorMessage = '未知错误';

    public function authenticate()
    {
        $admin = User::model()->with('userRoles', 'userGroups')->find('`t`.`username`=:u', array('u' => $this->username));
        if (empty($admin)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->errorMessage = '用户名不存在';
        } else {
            if ($admin->approved <= 0 || $admin->state == 1) {
                $this->errorCode = self::ERROR_NOT_LOGIN;
                $this->errorMessage = '用户名已被锁定';

            } elseif (!CPasswordHelper::verifyPassword($this->password, $admin->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
                $this->errorMessage = '密码错误,剩余尝试次数：' . ($admin->approved - 1);
                $admin->approved -= 1;
                $admin->update();
            } else {
                $this->errorCode = self::ERROR_NONE;
                $role = array();
                foreach ($admin->getRelated('userRoles') as $item) {
                    $r = $item->getRelated('role');
                    if ($r) $role[] = $r->name;
                }
                $group = array();
                foreach ($admin->getRelated('userGroups') as $item) {
                    $g = $item->getRelated('group');
                    if ($g) $group[] = $g->name;
                }
                $this->setPersistentStates(array_merge($admin->getAttributes(), array(
                    'last_login_time' => $admin->last_login_time,
                    'last_login_ip' => $admin->last_login_ip,
                    'sign_up_time' => $admin->sign_up_time,
                    'sign_up_ip' => $admin->sign_up_ip,
                    'role' => $role,
                    'group' => $group
                )));
                $this->afterLogin($admin);
            }
        }
        return !$this->errorCode;
    }

    public function afterLogin($db)
    {
        $db->attributes = array(
            'last_login_time' => time(),
            'last_login_ip' => Yii::app()->request->getUserHostAddress(),
            'approved' => 5
        );
        $db->update();
    }
}