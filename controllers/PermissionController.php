<?php

namespace app\controllers;

use Yii;
use app\controllers\BaseController;

class PermissionController extends BaseController
{
    public function actionNew()
    {
        return $this->render('new', [
            'name' => '',
            'desc' => '',            
        ]);
    }

    public function actionCreate()
    {
        $auth = Yii::$app->authManager;

        $permission = $auth->createPermission(Yii::$app->request->post('name'));
        $permission->description = Yii::$app->request->post('desc');

        try {
            if ($auth->add($permission)) {
                $this->addFlash('添加成功');

                return $this->redirect('index');
            }
        } catch (\Exception $e) {
            $this->addFlash('权限名称已被占用');
        }

        $this->layout = 'main';
        
        return $this->render('new', [
            'name' => Yii::$app->request->post('name'),        
            'desc' => Yii::$app->request->post('desc'),        
        ]);
    }

    public function actionIndex()
    {
        $auth = Yii::$app->authManager;

        $permissions = $auth->getPermissions();

        return $this->render('index', [
            'data' => $permissions ,       
        ]);
    }

    public function actionDelete()
    {
        $auth = Yii::$app->authManager;

        $permission = $auth->getPermission(Yii::$app->request->get('name'));

        if (empty($permission)) {
            $this->addFlash('数据不存在', self::Fail);

            return $this->redirect('index');
        }

        if ($auth->remove($permission)) {
            $this->addFlash('删除成功');
        } else {
            $this->addFlash('删除失败', self::Fail);
        }

        return $this->redirect('index');
    }
}
