<?php

namespace app\models;

use app\models\Base;

class Article extends Base
{
    public static function tableName()
    {
        return 'articles';
    }

    public function beforeSave($data)
    {
        parent::beforeSave($data);

        if (!$this->uuid) {
            $this->uuid = uniqid();
        }

        return true;
    }

    public function rules()
    {
        return [
            ['title', 'required', 'message' => '请填写标题'],
           // ['menu_id', 'validateMenuId', 'message' => '请选择所属菜单'],
            ['content', 'required', 'message' => '请填写内容'],
            ['publish_time', 'required', 'message' => '请填写发布时间'],
            [['title', 'content', 'author_id', 'author_name', 'publish_time', 'status', 'menu_id', 'keyword', 'second_title'], 'safe'],
        ];
    }

    public function validateMenuId($attribute, $params)
    {
        if ($this->menu_id <= 0) {
            $this->addError('menu_id', '请选择所属菜单');
        }
    }

    public function getMenuName($menus)
    {
        foreach ($menus as $m) {
            if ($m->id == $this->menu_id) {
                return $m->name;
            }
        }

        return '';
    }

    public static function has($url)
    {
        return static::find()->where(['source' => $url])->one();
    }

    public static function getPath($url)
    {
        $data = static::find()->where(['source' => $url])->one();

        $menu = Menu::find()->where(['id' => $data->top_menu_id])->one();

        if (!$data->mode) {
            return '/' . $menu->uname . '/' . $data->uname . '/' . $data->uuid;
        } else {
            return '/run/ot?t=' . $data->uuid;
        }
    }

    public static function hasTitle($title)
    {
        return static::find()->where(['title' => $title])->one();
    }
}
