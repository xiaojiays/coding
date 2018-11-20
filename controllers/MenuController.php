<?php

namespace app\controllers;

use Yii;
use app\controllers\BaseController;
use app\models\Menu;
use app\models\Grab;
use yii\data\Pagination;
use app\models\Article;
use app\models\Text;

class MenuController extends BaseController
{
    public function actionNew()
    {
        $model = new Menu;

        return $this->render('new', [
            'model' => $model,
            'menus' => Menu::getMenus(),
        ]);
    }

    public function actionCreate()
    {
        $model = new Menu;

        $post = Yii::$app->request->post();

        if ($_FILES['Menu']['size']['icon']) {
            $post['Menu']['icon'] = $this->uploadIcon();
        }

        if ($model->load($post) && $model->validate() && $model->save()) {
            $this->addFlash('添加成功');

            return $this->redirect('index');
        }

        return $this->render('new', [
            'model' => $model,
            'menus' => Menu::getMenus(),
        ]);
    }

    private function uploadIcon()
    {
        $name = $this->getFileName();

        move_uploaded_file($_FILES['Menu']['tmp_name']['icon'], 'uploads/' . $name);

        return $name;
    }

    private function getFileName()
    {
        $name = $_FILES['Menu']['name']['icon'];

        $arr = explode('.', $name);

        $suffix = end($arr);

        return uniqid() . '.' . $suffix;
    }

    public function actionIndex()
    {
        $query = Menu::find();
        $count = $query->count();
        $pages = new Pagination(['totalCount' => $count]);
        $data = $query->orderBy(['sortNo' => SORT_DESC])
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'data' => $data,
            'pages' => $pages,
            'menus' => Menu::getMenus(),
        ]);
    }

    public function actionStatus()
    {
        $menu = Menu::findOne(Yii::$app->request->get('id'));

        $menu->status = $menu->getOppositeStatus();

        if ($menu->save()) {
            $this->addFlash('操作成功');
        } else {
            $this->addFlash('操作失败', self::Fail);
        }

        return $this->redirect('index');
    }

    public function actionDelete()
    {
        $menu = Menu::findOne(Yii::$app->request->get('id'));

        if (empty($menu)) {
            $this->addFlash('数据不存在', self::Fail);
            return $this->redirect('index');
        }

        if ($menu->hasChild()) {
            $this->addFlash('请先删除子菜单', self::Fail);
            return $this->redirect('index');
        }

        if ($menu->delete()) {
            $this->addFlash('删除成功');
        } else {
            $this->addFlash('删除失败', self::Fail);
        }

        return $this->redirect('index');
    }

    public function actionEdit()
    {
        $model = Menu::findOne(Yii::$app->request->get('id'));

        return $this->render('edit', [
            'model' => $model,
            'menus' => Menu::getMenus(),
        ]);
    }

    public function actionUpdate()
    {
        $model = Menu::findOne(Yii::$app->request->get('id'));

        if (empty($model)) {
            $this->addFlash('数据不存在');
            return $this->redirect('index');
        }

        $post = Yii::$app->request->post();

        if ($_FILES['Menu']['size']['icon']) {
            $post['Menu']['icon'] = $this->uploadIcon();
        }

        if ($model->load($post) && $model->validate() && $model->save()) {
            $this->addFlash('修改成功');
            return $this->redirect('index');
        }

        return $this->render('edit', [
            'model' => $model,
            'menus' => Menu::getMenus(),
        ]);
    }

    public function actionGrab()
    {
        $model = new Grab;

        $u = Yii::$app->request->get('u');

        if ($u == 'kernel') {
            $res = $model->grabKernel($u);
        } else {
            $t = Yii::$app->request->get('t');
            $res = $model->grab($u, $t);
        }

        if ($res) {
            $this->addFlash('抓取成功');
        } else {
            $this->addFlash('抓取失败');
        }

        return $this->redirect('index');
    }

    public function actionImg()
    {
        $id = Yii::$app->request->get('id');
        $articles = Article::find()->where(['top_menu_id' => $id])->all();

        $pattern = '/<img.*?src="(.*?)"/';

        foreach ($articles as $a) {
            if (preg_match_all($pattern, $a->content, $matches)) {
                $content = $a->content;

                foreach ($matches[1] as $m) {
                    $img = Grab::img($m);
                    $content = str_replace($m, $img, $content);
                }

                $a->content = $content;
                if (!$a->save()) {
                    echo '保存失败' . $a->id;exit;
                }
            }
        }
        return 'success';
    }

    public function actionLink()
    {
        $id = Yii::$app->request->get('id');
        $articles = Article::find()->where(['top_menu_id' => $id])->all();

        $pattern = '/<a.*?href="(.*?)"/';

        foreach ($articles as $k=>$a) {
            if (preg_match_all($pattern, $a->content, $matches)) {
                $content = $a->content;
                foreach ($matches[1] as $m) {
                    if (strpos($m, 'try/try.php') !== false || strpos($m, 'try/tryit.php') !== false) {
                        $tp = Grab::getTp($m);
                        $content = str_replace('"' . $m . '"', '"/run/html?t=' . $tp . '"', $content);
                    } else if (strpos($m, 'try/color.php') !== false) {
                        $tp = Grab::getTp1($m);
                        $content = str_replace('"' . $m . '"', '"/run/color?t=' . $tp . '"', $content);
                    } else if (strpos($m, 'try/runcode.php') !== false || strpos($m, 'try/showphp2.php') !== false) {
                        $tp = Grab::getTp2($m);
                        $content = str_replace('"' . $m . '"', '"/run/php?t=' . $tp . '"', $content);
                    } else if (strpos($m, 'try/showphp.php') !== false) {
                        $tp = Grab::getTp3($m);
                        $content = str_replace('"' . $m . '"', '"/run/show?t=' . $tp . '"', $content);
                    } else if (strpos($m, 'try/try2') !== false) {
                        $tp = Grab::getTp4($m);
                        $content = str_replace('"' . $m . '"', '"/run/t2?t=' . $tp . '"', $content);
                    }
                }
                $a->content = $content;

                if (!$a->save()) {
                    echo '保存失败' . $a->id; exit;
                }
            }
        }
        return 'success';
    }

    public function actionUrl()
    {
        $id = Yii::$app->request->get('id');
        $articles = Article::find()->where(['top_menu_id' => $id])->all();

        $pattern = '/<a.*?href="(.*?)"/';

        $p = '/<iframe.*?src="(.*?)"/';
        foreach ($articles as $a) {
            $content = $a->content;
            if (preg_match_all($p, $content, $ms)) {
                foreach ($ms[1] as $m) {
                    if (strpos($m, 'http://www.w3cschool.cc') !== false) {
                        $tp = Grab::getTp6($m);
                        $content = str_replace('"' . $m . '"', '"/run/t3?t=' . $tp . '"', $content);
                    } else {
                        $tp = Grab::getTp5($m);
                        $content = str_replace('"' . $m . '"', '"/run/t1?t=' . $tp . '"', $content);
                    }
                }
                $a->content = $content;
                if (!$a->save()) {
                    print_r($a);
                    echo '保存失败'; exit;
                }
            }
        }

        $articles = Article::find()->where(['top_menu_id' => $id])->all();
        foreach($articles as $a) {
            $content = $a->content;
            if (preg_match_all($pattern, $content, $ms)) {
                foreach ($ms[1] as $m) {
                    if (strpos($m, 'run/') !== false || strpos($m, 'study_') !== false) {
                        continue;
                    }
                    $info = pathinfo($m);
                    if (!isset($info['extension']) || $info['extension'] != 'html') {
                        continue;
                    }

                    $url = $this->getUrl($m, $a);
                    
                    if (Article::has($url)) {
                        $path = Article::getPath($url);
                        $content = str_replace($m, $path, $content);
                        continue;
                    }

                    if (strpos($url, 'runoob.com') === false) {
                        continue;
                    }

                    $path = Grab::grt($url, $a);
                    $content = str_replace($m, $path, $content);
                }
                $a->content = $content;
                if (!$a->save()) {
                    print_r($a);
                    echo '保存失败'; exit;
                }
            }
        }

        echo 'success';
    }

    public function actionCheck()
    {
        $id = Yii::$app->request->get('id');

        $articles = Article::find()->where(['top_menu_id' => $id])->all();

        $pattern = '/<a.*?href="(.*?)"/';

        foreach ($articles as $a) {
            if (preg_match_all($pattern, $a->content, $ms)) {
                foreach ($ms[1] as $m) {
                    if (strpos($m, 'run/') === false && strpos($m, 'study_') === false) {
                        echo $a->title, $m, PHP_EOL;
                    }
                }
            }
        }
    }

    private function getUrl($path, $a)
    {
        if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
            $path = str_replace('http://www.w3cschool.cc/', 'http://www.runoob.com/', $path);
            return $path;
        }

        if (count(explode('/', $path)) > 1) {
            if ($path[0] == '/') {
                return 'http://www.runoob.com' . $path;
            } else {
                if ($path[0] == 'm' && $path[1] == '/') {
                    return 'http://www.runoob.com' . substr($path, 1);
                } else {
                    return 'http://www.runoob.com/' . $path;
                }
            }
        }

        $info = parse_url($a->source);
        $arr = explode('/', $info['path']);

        $url = 'http://www.runoob.com/' . $arr[1] . '/' . $path;
        return $url;
    }

    public function actionTt()
    {
        $data = Text::find()->all();
        foreach ($data as $d)
        {
            $c = $d->content;
            $c = str_replace('请在上面的文本框中编辑您的代码，然后单击提交按钮查看运行结果。', '', $c);
            $d->content = $c;
            $d->save();
        }
    }

    public function actionClear()
    {
        $id = Yii::$app->request->get('id');

        $articles = Article::find()->where(['top_menu_id' => $id])->all();

        foreach ($articles as $a) {
            $content = $a->content;
            $pattern = '/<a.*?href="(.*?)".*?>/';
            if (preg_match_all($pattern, $content, $ms)) {
                $change = false;
                foreach ($ms[1] as $k => $url) {
                    if (strpos($url, 'run/') === false && strpos($url, '/study_') === false && strpos($url, 'http://') === false && strpos($url, 'https://') === false) {
                        if ($url[0] != '#') {
                            $content = str_replace($ms[0][$k], '<a href="#">', $content);  
                            $change = true;             
                        }
                    }
                }
                if ($change) {
                    $a->content = $content;
                    $a->save();
                }
            }
        }

        echo 'finish';
    }
}
