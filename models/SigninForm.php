<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SigninForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = false;

    private $_admin = false;

    public function rules()
    {
        return [
            ['email', 'required', 'message' => '请输入邮箱'],
            ['password', 'required', 'message' => '请输入密码'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword', 'message' => '用户名或密码错误'],        
        ];
    }

    public function signin()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getAdmin(), $this->rememberMe ? 3600*24*7 : 0);
        }

        return false;
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $admin = $this->getAdmin();
            
            if (!$admin || !$admin->validatePassword($this->password) || $admin->disable()) {
                $this->addError('password', '用户名或密码错误');
            }
        }
    }

    public function getAdmin()
    {
        if ($this->_admin === false) {
            $this->_admin = Admin::findByEmail($this->email);
        }

        return $this->_admin;
    }
}
