<?php

namespace app\models;

use Yii;
use app\models\Base;
use yii\web\IdentityInterface;

class Admin extends Base implements IdentityInterface
{
    public static function tableName()
    {
        return 'admins';
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findByEmail($email)
    {
        return static::find()->where(['email' => $email])->one();
    }

    public function disable()
    {
        return $this->status == self::Disable;
    }

    public function validatePassword($pwd)
    {
        return password_verify($pwd, $this->password);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRoles()
    {
        $auth = Yii::$app->authManager;

        $roles = $auth->getRolesByUser($this->id);

        $str = '';

        foreach ($roles as $r) {
            $str .= $r->description . '</br>';
        }

        return $str;
    }
}
