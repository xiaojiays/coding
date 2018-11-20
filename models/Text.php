<?php

namespace app\models;

use app\models\Base;

class Text extends Base
{
    public static function tableName()
    {
        return 'texts';
    }

    public function rules()
    {
        return [
            [['title', 'content', 'keywords', 'source'], 'safe'],
        ];
    }
}
