<?php

namespace app\models;

use Yii;
use app\models\Base;
use app\models\Menu;
use app\models\Article;

class Grab extends Base
{
    public function grab($name, $type)
    {
        $res = false;

        switch ($type) {
            case 0:
                $res = $this->grabType1($name);
                break;

            case 1:
                break;

            case 2:
                break;

            default:
                break;
        }

        return $res;
    }

    private function grabType1($name)
    {
        $menu = Menu::getMenuByUname($name);

        $file =  dirname(__FILE__) . '/../' . Yii::$app->params['path'] . '/' . $name . '.txt';

        if (!file_exists($file)) {
            echo '文件不存在'; exit;
        }

        $content = file_get_contents($file);

        $arr = explode('<h2', $content);

        foreach ($arr as $k => $a) {
            $tag = $this->getTag($k, $a);

            $pattern = '/<a.*?href="(.*?)".*?>([\s\S]*?)<\/a>/';
            if (preg_match_all($pattern, $a, $m)) {
                foreach ($m[1] as $key => $link) {
                    $url = $this->getUrl($link, $m[1]);
                    $arr = explode('.', $url);
                    if (!Article::has($url) && end($arr) == 'html') {
                        $this->grabContent($url, trim($m[2][$key]), $tag, $menu);
                    }
                }
            } else {
                echo '获取链接失败';exit;
            }
        }
        return true;
    }

    private function getTag($k, $a)
    {
        if ($k) {
            $a = '<h2 ' . $a;
            $pattern = '/<h2.*?>([\s\S]*?)<\/h2>/';
        } else {
            $pattern = '/<div.*?class="tab".*?>([\s\S]*?)<\/div>/';
        }

        if (preg_match($pattern, $a, $m)) {
            return strip_tags($m[1]);
        }
        echo '获取tag失败';exit;
    }

    private function getUrl($link, $arr)
    {
        if (strpos($link, 'http://www.w3cschool.cc') !== false) {
            $link = str_replace('http://www.w3cschool.cc', 'http://www.runoob.com', $link);
            return $link;
        }

        if (strpos($link, 'runoob.com') !== false) {
            return $link;
        }


        if (count(explode('/', $link)) > 1) {
            return 'http://www.runoob.com' . $link;
        }

        $prefix = $this->getPrefix($arr);

        if ($prefix !== null) {
            return 'http://www.runoob.com/' . $prefix . '/' . $link;
        }

        $arr = explode('-', $link);
        if (count($arr) > 1) {
            return 'http://www.runoob.com/' . $arr[0] . '/' . $link;
        }
        echo '获取url' . $link . '失败'; exit;
    }

    private function getPrefix($arr)
    {
        foreach ($arr as $a) {
            $data = explode('/', $a);
            if (count($data) > 1) {
                return $data[1];
            }
        }

        return null;
    }

    private function grabContent($url, $title, $tag, $menu)
    {
        $content = $this->getContent($url);

        $pattern = '/<div.*?class="article-body".*?>([\s\S]*?)<div.*?class="previous-next-links".*?>/';

        if (!preg_match($pattern, $content, $m)) {
            echo '抓取url ' . $url . '失败';exit;
        }

        $content = '<div class="article-body">' . $m[1];

        $article = new Article;
        $article->title = $title;
        $article->tag = $tag;
        $article->menu_id = $menu->id;
        $article->top_menu_id = $menu->pid;
        $article->source = $url;
        $article->content = $content;
        $article->keyword = $this->getKeyword($title);
        $article->uuid - uniqid();
        $article->publish_time = time();
        $article->uname = $menu->uname;

        if (!$article->save()) {
            print_r($article->getErrors());
            echo $url . '采集失败';exit;
        }
    }

    private function getContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    private function getKeyword($text)
    {
        $sh = scws_open();

        $dir = dirname(__FILE__) . '/../tps';

        scws_set_charset($sh, 'utf8');
        scws_set_dict($sh, $dir . '/dict.utf8.xdb');
        scws_set_rule($sh, $dir . '/rules.utf8.ini');
        scws_send_text($sh, $text);

        $top = scws_get_tops($sh, 5);

        $str = '';
        foreach ($top as $t) {
            $str .= $t['word'] . ',';
        }

        if (strlen($str) > 0) {
            $str = substr($str, 0, strlen($str)-1);
        }
        return $str;
    }

    public static function img($img)
    {
        $name = self::getImgName($img);

        if (!$name) {
            echo '获取图片名称失败 ' . $img; exit;
        }

        if (strpos($img, 'gggg') !== false) {
            return $img;
        }

        if (strpos($img, 'http://') === false) {
            $img = 'http://www.runoob.com' . $img;
        }


        $content = file_get_contents($img);

        if (!$content) {
            echo '获取图片内容失败 ' . $img; exit;
        }

        $fp = fopen(Yii::$app->params['img'] . '/' . $name, 'w+');
        fwrite($fp, $content);
        fclose($fp);

        return '/images/gggg/' . $name;
    }

    private static function getImgName($img)
    {
        $arr = pathinfo($img);

        return $arr['basename'];
    }

    public static function getTp1($path)
    {
        $path = 'http://www.runoob.com' . $path;

        $content = self::getCon($path);

        $pattern = '/<center>([\s\S]*?)<\/center>/';

        $name = uniqid();

        if (preg_match($pattern, $content, $m)) {
           // $fp = fopen(Yii::$app->params['tp'] . '/' . $name . '.php', 'w+');
            $content = $m[0];
            $pattern = '/<label.*?class="pull-right".*?>.*?<\/label>/';
            $content = preg_replace($pattern, "", $content);
            $pattern = '/<div.*?class="headerText".*?>[\s\S]*?<\/div>/';
            $content = preg_replace($pattern, "", $content);
           // fwrite($fp, $content);
           // fclose($fp);
           // return $name;
           return self::saveText('', $content, $path);
        } else {
            echo $path . '匹配失败'; exit;
        }
    }

    public static function getTp2($path)
    {
        $path = 'http://www.runoob.com' . $path;
        $content = self::getCon($path);

        $pattern = '/<div.*?class="row".*?style="background-color: #e5eecc;">([\s\S]*?)<script.*?type="text\/javascript"/';
        if (!preg_match($pattern, $content, $m)) {
            echo '获取runcode内容失败' . $path; exit;
        }
        $content = $m[1];
        $pattern = '/<iframe.*?src="([\s\S]*?)"/';
        if (preg_match_all($pattern, $content, $ms)) {
            foreach($ms[1] as $m) {
                $data = self::getcon($m);
               // $name = uniqid();
               // $fp = fopen(Yii::$app->params['tp'] . '/' . $name . '.php', 'w+');
               // fwrite($fp, $data);
               // fclose($fp);
                $name = self::saveText('', $data, $m);
                $content = str_replace($m, '/run/oo?t=' . $name, $content);
            }
        }

        //$name = uniqid();
       // $fp = fopen(Yii::$app->params['tp'] . '/' . $name . '.php', 'w+');
            $pattern = '/<label.*?class="pull-right".*?>.*?<\/label>/';
            $content = preg_replace($pattern, "", $content);
            $pattern = '/<div.*?class="headerText".*?>[\s\S]*?<\/div>/';
            $content = preg_replace($pattern, "", $content);
           // fwrite($fp, $content);
            //fclose($fp);
            return self::saveText('', $content, $path);
       // return $name;
    }

    public static function getTp3($path)
    {
        $path = 'http://www.runoob.com' . $path;
        $content = self::getCon($path);

        $pattern = '/<div.*?id="content".*?>([\s\S]*?)<\/body>/';

        if (!preg_match($pattern, $content, $m)) {
            echo '获取showcode内容失败' . $path;exit;
        }
       // $name = uniqid();
            $content = $m[1];
            $pattern = '/<label.*?class="pull-right".*?>.*?<\/label>/';
            $content = preg_replace($pattern, "", $content);
            $pattern = '/<div.*?class="headerText".*?>[\s\S]*?<\/div>/';
            $content = preg_replace($pattern, "", $content);
            $pattern = '/<div.*?style="display:none;".*?>[\s\S]*?<\/div>/';
            $content = preg_replace($pattern, "", $content);
            $content = self::special($content);
           // $fp = fopen(Yii::$app->params['tp'] . '/' . $name . '.php', 'w+');
            //fwrite($fp, $content);
            //fclose($fp);
       // return $name;
       return self::saveText('', $content, $path);
    }

    public static function getTp4($path)
    {
        $path = 'http://www.runoob.com' . $path;
        $content = self::getCon($path);

        $pattern = '/<div class="container".*?>([\s\S]*?)<script/';
        if (!preg_match($pattern, $content, $m)) {
            echo '抓取try2失败', $path; exit;
        }

        return self::saveText('', $m[1], $path);

       /* $name = uniqid();

        $fp = fopen(Yii::$app->params['tp'] . '/' . $name, 'w+');
        fwrite($fp, $m[1]);
        fclose($fp);

        return $name;*/
    }

    public static function getTp5($path)
    {
        $path = 'http://www.runoob.com' . $path;    
        $content = self::getCon($path);

        $pattern = '/<body.*?>([\s\S]*?)<\/body>/';
        if (!preg_match($pattern, $content, $m)) {
            echo '抓取失败5' , $path;exit;
        }

        return self::saveText('', $m[0], $path);

       /* $name = uniqid();

        $fp = fopen(Yii::$app->params['tp'] . '/' . $name . '.php', 'w+');
        fwrite($fp, $m[0]);
        fclose($fp);

        return $name;*/
    }

    public static function getTp6($path)
    {
        $content = self::getCon($path);

        $pattern = '/<script.*?src="(.*?)">/';
        if (preg_match_all($pattern, $content, $ms)) {
            foreach ($ms[1] as $m) {
                $name = self::getImgName($m);
                $content = str_replace($m, '/js/' . $name, $content);
            }
        }

        $pattern = '/<link.*?href=(.*?)/';
        if (preg_match_all($pattern, $content, $ms)) {
            foreach($ms[1] as $m) {
                $name = self::getImgName($m);
                $content = str_replace($m, '/css/' . $name, $content);
            }
        }

        return self::saveText('', $content, $path);

      /*  $name = uniqid();
        $fp = fopen(Yii::$app->params['tp'] . '/' . $name . '.php', 'w+');
        fwrite($fp, $content);
        fclose($fp);

        return $name;*/
    }

    private static function special($content)
    {
        $pattern = '/<div.*?id="result".*?>[\s\S]*?<iframe.*?src="(.*?)"/';

        if (!preg_match($pattern, $content, $m)) {
            return $content;
        }

        $arr = explode('?', $m[1]);
        //  $name = end($arr);
        $path = 'http://www.runoob.com/try/' . $m[1];
        $data = self::getCon($path);

      //  $fp = fopen(Yii::$app->params['tp'] . '/' . $name . '.php', 'w+');
      //  fwrite($fp, $data);
      //  fclose($fp);

        $name = self::saveText('', $data, $path);

        $content = str_replace($m[1], '/run/excute?t=' . $name, $content);
        return $content;
    }

    public static function getTp($path)
    {
        $path = 'http://www.runoob.com' . $path;
        $content = self::getCon($path);

        $pattern = '/<textarea.*?>([\s\S]*?)<\/textarea>/';

       // $name = uniqid();

        if (preg_match($pattern, $content, $m)) {
            $content = self::formatContent($m[1]);
           // $fp = fopen(Yii::$app->params['tp'] . '/' . $name . '.php', 'w+');
           // fwrite($fp, $content);
           // fclose($fp);
           // return $name;
            return self::saveText('', $content, $path);
        } else {
            echo '获取内容失败' . $path;
            return 'default';
        }
    }

    private static function getCon($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    private static function formatContent($content)
    {
        $content = str_replace('菜鸟教程(runoob.com)', '新手教程(www.kabikabi.cn)', $content);

        $pattern = '/script.*?src=&quot;(.*?)&quot;/';
        if (preg_match_all($pattern, $content, $ms)) {
            foreach ($ms[1] as $m) {
                if (strpos($m, 'http://') === false || strpos($m, 'runoob.com') === false) {
                    continue;
                }

                $name = self::getImgName($m);

                self::download($m, Yii::$app->params['js'] . '/' . $name);
                $content = str_replace($m, '/js/' . $name, $content);
            }
        }

        $pattern = '/&lt;link.*?href=&quot;(.*?)&quot;/';
        if (preg_match_all($pattern, $content, $ms)) {
            foreach ($ms[1] as $m) {
                if (strpos($m, 'http://') === false || strpos($m, 'runoob.com') == false) {
                    continue;
                }

                $name = self::getImgName($m);

                self::download($m, Yii::$app->params['css'] . '.' . $name);
                $content = str_replace($m, '/css/' . $name, $content);
            }
        }

        $pattern = '/&lt;embed.*?src=&quot;(.*?)&quot;/';
        if (preg_match_all($pattern, $content, $ms)) {
            foreach($ms[1] as $m) {
                $name = $m;
                self::download('http://www.runoob.com/try/demo_source/' . $m, Yii::$app->params['img'] . '/' . $name);
            }
        }

        $pattern = '/&lt;object.*?data=&quot;(.*?)&quot;/';
        if (preg_match_all($pattern, $content, $ms)) {
            foreach($ms[1] as $m) {
                $name = $m;
                self::download('http://www.runoob.com/try/demo_source/' . $m, Yii::$app->params['img'] . '/' . $name);
            }
        }

        $pattern = '/&lt;img.*?src=&quot;(.*?)&quot;/';
        if (preg_match_all($pattern, $content, $ms)) {
            foreach ($ms[1] as $m) {
                $name =  self::getImgName($m);
                self::download('http://www.runoob.com' . $m, Yii::$app->params['img'] . $name);
                $content = str_replace($m, '/images/gggg/' . $name, $content);
            }
        }

        return $content;
    }

    private static function download($url, $file) {
        if (file_exists($file)) {
            return;
        }

        $content = @file_get_contents($url);

        $fp = fopen($file, 'w+');
        fwrite($fp, $content);
        fclose($fp);
    }

    public static function grt($url, $a)
    {
        $content = self::getCon($url);

        $pattern = '/<title>([\s\S]*?)<\/title>/';
        if (!preg_match($pattern, $content, $m)) {
            echo '获取标题失败', $url;
            return str_replace('http://www.runoob.com', '', $url);
        }

        $title = strip_tags($m[1]);
        $title = str_replace('| 菜鸟教程', '', $title);
        $title = trim($title);
        if ($art = Article::hasTitle($title)) {
            return '/run/ot?t=' . $art->uuid;
        }

        $pattern = '/<div.*?class="article-body".*?>([\s\S]*?)<div.*?class="previous-next-links".*?>/';

        if (!preg_match($pattern, $content, $m)) {
            echo '抓取失败 ' . $url;
            return str_replace('http://www.runoob.com', '', $url);
        }

        $content = '<div class="article-body">' . $m[1];

        $article = new Article;
        $article->title = $title;
        $article->top_menu_id = $a->top_menu_id;
        $article->menu_id = $a->menu_id;
        $article->mode = 1;
        $article->source = $url;
        $article->content = $content;
        $article->keyword = self::getKey($title);
        $article->uuid = uniqid();
        $article->publish_time = time();

        if (!$article->save()) {
            print_r($article->getErrors());
            echo $url . '采集失败';exit;
        }

        return '/run/ot/?t=' . $article->uuid;
    }

    private static function getKey($text)
    {
        $sh = scws_open();

        $dir = dirname(__FILE__) . '/../tps';

        scws_set_charset($sh, 'utf8');
        scws_set_dict($sh, $dir . '/dict.utf8.xdb');
        scws_set_rule($sh, $dir . '/rules.utf8.ini');
        scws_send_text($sh, $text);

        $top = scws_get_tops($sh, 5);

        $str = '';
        foreach ($top as $t) {
            $str .= $t['word'] . ',';
        }

        if (strlen($str) > 0) {
            $str = substr($str, 0, strlen($str)-1);
        }
        return $str;
    }

    public static function saveText($title, $content, $source)
    {
        $data = Text::find()->where(['source' => $source])->one();
        if ($data) {
            return $data->id;
        }

        $content = json_decode(json_encode($content));

        $keywords = self::getKey($title);

        $txt = new Text;
        $txt->title = $title;
        $txt->content = $content;
        $txt->source = $source;
        $txt->keywords = $keywords;

        if ($txt->save()) {
            return $txt->id;
        }

        echo '保存失败';
        print_r($txt);exit;
    } 

    public function grabKernel($u)
    {
        $menu = Menu::find()->where(['uname' => $u])->one();

        $url = 'http://www.php-internals.com/book/';
        $contents = file_get_contents($url);

        $pattern = '/div.*?class="inner-containner".*?>([\s\S]*?)<div.*?id="footer"/';
        if (!preg_match($pattern, $contents, $m)) {
            echo '抓取目录失败';exit;
        }
        $pattern = '/<a.*?href="(.*?)">(.*?)<\/a>/';
        if (!preg_match_all($pattern, $m[0], $m)) {
            echo '抓取链接失败';exit;
        }
        foreach ($m[1] as $k=>$url) {
            $content = file_get_contents('http://www.php-internals.com/book/' . $url);
            $pattern = '/<div.*?class="inner-containner".*?>([\s\S]*?)<\/div>/';
            if (preg_match($pattern, $content, $ms)) {
                $arr = explode('<div', $ms[1]);
                $content = $arr[0];
                $article = new Article;
                $article->title = $m[2][$k];
                $article->tag = '';
                $article->menu_id = $menu->id;
                $article->top_menu_id = $menu->pid;
                $article->source = 'http://www.php-internals.com/book/' . $url;
                $article->content = $content;
                $article->keyword = $this->getKeyword($m[2][$k]);
                $article->uuid - uniqid();
                $article->publish_time = time();
                $article->uname = $menu->uname;
                if (!$article->save()) {
                    echo '保存失败';exit;
                }
                
            }else {
                echo '获取' . $url . '内容失败'; exit;
            }
        }
    }  
}
