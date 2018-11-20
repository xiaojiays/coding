<?php

namespace app\controllers;

use Yii;
use app\controllers\BaseController;

class IndexController extends BaseController
{
    public function actionError()
    {

    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
