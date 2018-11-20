<?php

namespace app\models;

use yii\db\ActiveRecord;

class Base extends ActiveRecord
{
    const Enable = 0;
    const EnableName = '正常';
    const Disable = 1;
    const DisableName = '禁用';

    public function beforeSave($data)
    {
         if ($this->getIsNewRecord()) {
            $this->createdAt = time();
            $this->updatedAt = time();
        } else {
            $this->updatedAt = time();
        }

        return true;
    }

    public function getStatusName()
    {
        return $this->status === self::Enable ? self::EnableName : self::DisableName;
    }

    public function getOppositeStatusName()
    {
        return $this->status === self::Enable ? self::DisableName : self::EnableName;
    }

    public function getOppositeStatus()
    {
        return $this->status === self::Enable ? self::Disable : self::Enable;
    }

    public function getStatusOptions()
    {
        $status = [
            self::Enable => self::EnableName,
            self::Disable => self::DisableName,
        ];

        $str = '';

        foreach ($status as $k => $v) {

            if ($k === $this->status) {
                $str .= '<option value=' . $k . ' selected>' . $v . '</option>';
            } else {
                $str .= '<option value=' . $k . '>' . $v . '</option>';

            }

        }

        return $str;
    }
}
