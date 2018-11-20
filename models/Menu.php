<?php

namespace app\models;

use app\models\Base;

class Menu extends Base
{
    public static function tableName()
    {
        return 'menus';
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => '请填写菜单名称'],
            ['name', 'unique', 'message' => '菜单名称已被使用'],
            ['uname', 'required', 'message' => '请填写链接名称'],
            ['uname', 'unique', 'message' => '链接名称已被使用'],
            ['pid', 'required', 'message' => '请选择上级菜单'],
            ['pid', 'integer', 'message' => '上级菜单数据错误'],
            ['sortNo', 'required', 'message' => '请填写排序数'],
            ['sortNo', 'integer', 'message' => '排序数必须为整数'],
            [['name', 'pid', 'sortNo', 'status', 'icon', 'desc', 'uname', 'keywords', 'type'], 'safe'],
        ];
    }

    public function getMenuOptions($menus, $select, $pid = 0, $index = 0)
    {
        $str = '';

        if (!$pid) {
            $str = '<option value=0>无</option>';
        }

        foreach ($menus as $m) {
            if ($m->pid === $pid) {
                $prefix = $this->getPrefix($index);

                if ($select === $m->id) {
                    $str .= '<option value=' . $m->id . ' selected>' . $prefix . $m->name . '</option>';
                } else {
                    $str .= '<option value=' . $m->id . '>' . $prefix . $m->name . '</option>';
                }

                $str .= $this->getMenuOptions($menus, $select, $m->id, $index+1);
            }
        }

        return $str;
    }

    private function getPrefix($index)
    {
        $str = '';

        for ($i = 0; $i < $index; $i++) {
            $str .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        }

        return $str;
    }

    public function getParentName($menus)
    {
        if (!$this->pid) {
            return '无';
        }

        foreach ($menus as $m) {
            if ($m->id === $this->pid) {
                return $m->name;
            }
        }

        return '';
    }

    public function hasChild()
    {
        $count = static::find()->where(['pid' => $this->id])->count();

        return $count > 0;
    }

    public static function getMenus()
    {
        return static::find()->orderBy(['sortNo' => SORT_DESC])->all();
    }

    public static function getMenuByUname($uname)
    {
        return static::find()->where(['uname' => $uname])->one();
    }
}
