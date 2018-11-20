<?php

namespace app\controllers;

use Yii;
use app\controllers\BaseController;

class RoleController extends BaseController
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

        $role = $auth->createRole(Yii::$app->request->post('name'));
        $role->description = Yii::$app->request->post('desc');

        try {
            if ($auth->add($role)) {
                $this->addFlash('添加成功');

                return $this->redirect('index');
            }
        } catch (\Exception $e) {
            $this->addFlash('角色名称已被占用', self::Fail);
        }

        $this->layout = 'main';

        return $this->render('new', [
            'name' => Yii::$app->request->post('name'),        
            'desc' => Yii::$app->request->post('desc'),        
        ]);
    }

    public function actionIndex()
    {
        $roles = Yii::$app->authManager->getRoles();

        return $this->render('index', [
            'roles' => $roles,        
        ]);
    }

    public function actionDelete()
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRole(Yii::$app->request->get('name'));

        if (empty($role)) {
            $this->addFlash('数据不存在', self::Fail);
            
            return $this->redirect('index');
        }

        if ($auth->remove($role)) {
            $this->addFlash('删除成功');
        } else {
            $this->addFlash('删除失败', self::Fail);
        }

        return $this->redirect('index');
    }

    public function actionPermissions()
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRole(Yii::$app->request->get('name'));

        $permissions = $auth->getPermissions();

        $rolePermissions = $auth->getPermissionsByRole(Yii::$app->request->get('name'));
        
        return $this->render('permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,       
        ]);
    }

    public function actionUpdate()
    {
        $auth = Yii::$app->authManager;
    
        $name = Yii::$app->request->get('name');

        $role = $auth->getRole($name);

        $rolePermissions = $auth->getPermissionsByRole($name);

        if ($rolePermissions && !$auth->removeChildren($role)) {
            $this->addFlash('更新失败', self::Fail);

            return $this->redirect(['permissions', 'name' => $name] );
        }

        foreach ((array)Yii::$app->request->post('permission') as $v) {
            $permission = $auth->getPermission($v);

            if (!$auth->addChild($role, $permission)) {
                $this->addFlash('更新失败', self::Fail);

                return $this->redirect(['permissions', 'name' => $name]);
            }
        }

        $this->addFlash('更新成功');

        return $this->redirect(['permissions', 'name' => $name]);
    }
}
