<?php

namespace app\models;

use Yii;
use app\models\Base;
use app\models\Admin;

class CreateUserForm extends Base
{
    public $passwordConfirm;

    public static function tableName()
    {
        return Admin::tableName();
    }

    public function beforeSave($data)
    {
        parent::beforeSave($data);
        if ($this->getIsNewRecord()) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
        
        return true;
    }

    public function rules()
    {
        return [
            ['email', 'required', 'message' => '请输入邮箱'],
            ['email', 'email', 'message' => '邮箱格式错误'],
            ['email', 'unique', 'message' => '邮箱已被使用'],
            ['name', 'required', 'message' => '请输入姓名'],
            ['password', 'required', 'message' => '初始密码不能为空'],
            ['password', 'match', 'pattern' => '/^.{6,20}$/', 'message' => '初始密码长度应在6至20个字符之间'],
            ['passwordConfirm', 'required', 'message' => '初始密码确认不能为空'],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password', 'operator' => '===', 'message' => '初始密码确认不一致'],
        ];
    }
}
