<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    const Success = 1;
    const Fail = 2;

    public function beforeAction($action)
    {
        $name = $action->controller->id . ':' . $action->id;
        
        $permission = Yii::$app->authManager->getPermission($name);

        if (empty($permission)) {
            return true;
        }
        
        if (Yii::$app->user->can($name)) {
            return true;
        }

        echo $this->render('@app/views/user/403.php');

        return false;
    }

    public function addFlash($message, $type = self::Success)
    {
        $this->layout = false;

        $content = $this->getContent($type, $message);

        if (!Yii::$app->session->isActive) {
            Yii::$app->session->open();
        }

        Yii::$app->session->addFlash('flash_message', $content, false);
    }

    private function getContent($type, $message)
    {
        $content = '';
        switch ($type) {
            case self::Success:
                $content = $this->renderFile('@app/views/layouts/success.php', [
                    'msg' => $message,        
                ]);
                break;
            case self::Fail;
                $content = $this->renderFile('@app/views/layouts/fail.php', [
                    'msg' => $message,        
                ]);
                break;
            default:
                break;
        }
        return $content;
    }
}
