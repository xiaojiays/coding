<?php

namespace app\controllers;

use Yii;
use app\controllers\BaseController;
use app\models\SigninForm;
use app\models\CreateUserForm;
use app\models\Admin;
use yii\data\Pagination;

class UserController extends BaseController
{
    public function actionLogin()
    {
        $this->layout = false;
        $model = new SigninForm;

        return $this->render('login', [
            'model' => $model,       
        ]);
    }

    public function actionSignin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/index/index');
        }
        
        $model = new SigninForm();
        $model->setAttributes(Yii::$app->request->post()); 
        
        if ($model->signin()) {
            return $this->redirect('/index/index');
        }
        
        $this->layout = false; 

        return $this->render('login', [
            'model' => $model,        
        ]);
    }

    public function actionIndex()
    {
        $query = Admin::find();
        $cloneQuery = clone $query;
        $pages = new Pagination(['totalCount' => $cloneQuery->count()]);
        $data = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'data' => $data,
            'pages' => $pages,       
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('login');
    }

    public function actionNew()
    {
        $model = new CreateUserForm;

        return $this->render('new', [
            'model' => $model,     
        ]);
    }

    public function actionCreate()
    {
        $model = new CreateUserForm;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                
            if ($model->save()) {
                $this->addFlash('添加成功');
                return $this->redirect('index');
            }

        }

        return $this->render('new', [
            'model' => $model,       
        ]);
    }

    public function actionStatus()
    {
        $admin = Admin::findOne(Yii::$app->request->get('id'));

        $admin->status = $admin->getOppositeStatus();
        
        if ($admin->save()) {
            $this->addFlash('操作成功');
        } else {
            $this->addFlash('操作失败', self::Fail);
        }
        
        return $this->redirect('index');
    }

    public function actionDelete()
    {
        $admin = Admin::findOne(Yii::$app->request->get('id'));

        if (empty($admin)) {
            $this->addFlash('数据不存在', self::Fail);
            return $this->redirect('index');
        }

        if ($admin->delete()) {
            $this->addFlash('删除成功');
        } else {
            $this->addFlash('删除失败', self::Fail);
        }

        return $this->redirect('index');
    }

    public function actionRole()
    {
        $auth = Yii::$app->authManager;

        $admin = Admin::findOne(Yii::$app->request->get('id'));

        $adminRoles = $auth->getRolesByUser($admin->id);

        $roles = $auth->getRoles();

        return $this->render('role', [
            'admin' => $admin,
            'adminRoles' => $adminRoles,
            'roles' => $roles,        
        ]);
    }

    public function actionRoles()
    {
        $auth = Yii::$app->authManager;

        $id = Yii::$app->request->get('id');

        $adminRoles = $auth->getRolesByUser($id);

        if ($adminRoles && !$auth->revokeAll($id)) {
            $this->addFlash('更新失败', self::Fail);

            return $this->redirect(['role', 'id' => $id]);
        }

        foreach ((array)Yii::$app->request->post('roles') as $v) {
            $role = $auth->getRole($v);

            if (!$auth->assign($role, $id)) {
                $this->addFlash('更新失败', self::Fail);

                return $this->redirect(['role', 'id' => $id]);
            }
        }

        $this->addFlash('更新成功');

        return $this->redirect(['role', 'id' => $id]);
    }

    public function action403()
    {
        return $this->render(403);
    }
}
