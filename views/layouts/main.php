<?php
use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->beginContent('@app/views/layouts/head.php') ?>
    <?php $this->endContent() ?>
    <?php $this->head() ?>
</head>
<body class="pace-done">
    <?php $this->beginContent('@app/views/layouts/top.php') ?>
    <?php $this->endContent() ?>
    <?php $this->beginContent('@app/views/layouts/side.php') ?>
    <?php $this->endContent() ?>
    <?php $this->beginBody() ?>
    <div id="content">
        <div class="content-wrapper">
            <?php $this->beginContent('@app/views/layouts/bread.php') ?>
            <?php $this->endContent() ?>
            <div class="outlet">
                <?= $content ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php $this->endBody() ?>
    <?php $this->beginContent('@app/views/layouts/foot.php') ?>
    <?php $this->endContent() ?>
</body>
</html>
<?php $this->endPage() ?>
