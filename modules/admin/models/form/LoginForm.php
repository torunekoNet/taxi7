<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends RedLoginForm
{
    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_identity = new AdminIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate()) {
                switch ($this->_identity->errorCode) {
                    case AdminIdentity::ERROR_USERNAME_INVALID:
                        $name = 'username';
                        break;
                    case AdminIdentity::ERROR_PASSWORD_INVALID:
                        $name = 'password';
                        break;
                    case AdminIdentity::ERROR_NOT_LOGIN:
                        $name = 'username';
                        break;
                    case AdminIdentity::ERROR_UNKNOWN_IDENTITY:
                        $name = 'unknown';
                        break;
                    default:
                        $name = 'success';
                        break;
                }
                $this->addError($name, $this->_identity->errorMessage);
            }
        }
    }
}
