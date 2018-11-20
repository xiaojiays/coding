<?php

namespace app\controllers;

use Yii;
use app\controllers\BaseController;
use app\models\Article;
use app\models\Menu;
use yii\data\Pagination;

class ArticleController extends BaseController
{
    public function actionNew()
    {
        $model = new Article;

        return $this->render('new', [
            'model' => $model,
            'menus' => Menu::getMenus(),
        ]);
    }

    public function actionCreate()
    {
        $model = new Article;

        $post = Yii::$app->request->post();
        $post['Article']['publish_time'] = strtotime($post['Article']['publish_time']);

        if ($model->load($post) && $model->validate() && $model->save()) {
            $this->addFlash('添加成功');

            return $this->redirect('index');
        }

        return $this->render('new', [
            'model' => $model,
            'menus' => Menu::getMenus(),
        ]);
    }

    public function actionIndex()
    {
        $query = Article::find();
        $count = $query->count();
        $pages = new Pagination(['totalCount' => $count]);
        $data = $query->orderBy(['id' => SORT_DESC])
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'data' => $data,
            'pages' => $pages,
            'menus' => Menu::getMenus(),
        ]);
    }

    public function actionUpload()
    {
        $name = $this->getFileName();

        move_uploaded_file($_FILES['upload']['tmp_name'], 'uploads/' . $name);

        return 'uploads/' . $name;
    }

    private function getFileName()
    {
        $name = $_FILES['upload']['name'];

        $arr = explode('.', $name);

        $suffix = end($arr);

        return uniqid() . '.' . $suffix;
    }

    public function actionStatus()
    {
        $article = Article::findOne(Yii::$app->request->get('id'));

        $article->status = $article->getOppositeStatus();

        if ($article->save()) {
            $this->addFlash('操作成功');
        } else {
            $this->addFlash('操作失败', self::Fail);
        }

        return $this->redirect('index');
    }

    public function actionDelete()
    {
        $article = Article::findOne(Yii::$app->request->get('id'));

        if (empty($article)) {
            $this->addFlash('数据不存在', self::Fail);
            return $this->redirect('index');
        }

        if ($article->delete()) {
            $this->addFlash('删除成功');
        } else {
            $this->addFlash('删除失败', self::Fail);
        }

        return $this->redirect('index');
    }

    public function actionEdit()
    {
        $model = Article::findOne(Yii::$app->request->get('id'));

        return $this->render('edit', [
            'model' => $model,
            'menus' => Menu::getMenus(),
        ]);
    }

    public function actionUpdate()
    {
        $model = Article::findOne(Yii::$app->request->get('id'));

        if (empty($model)) {
            $this->addFlash('数据不存在');
            return $this->redirect('index');
        }

        $post = Yii::$app->request->post();
        $post['Article']['publish_time'] = strtotime($post['Article']['publish_time']);

        if ($model->load($post) && $model->validate() && $model->save()) {
            $this->addFlash('修改成功');
            return $this->redirect('index');
        }

        return $this->render('edit', [
            'model' => $model,
            'menus' => Menu::getMenus(),
        ]);
    }
}
