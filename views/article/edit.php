<?php use app\models\Menu; ?>
<script src="/ckeditor/ckeditor.js"></script>
<script src="/ckeditor/art.js"></script>
<script src="/WDatePicker/WdatePicker.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default toggle" id="spr_0">
            <div class="panel-heading">
                <h3 class="panel-title">修改文章</h3>
                <div class="panel-controls panel-controls-hide" style="display: none;">
                    <a href="#" class="toggle panel-minimize">
                        <i class="im-minus"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
            <form id="form" method="post" action="/article/update?id=<?=$model->id?>" class="form-horizontal group-border hover-stripped" role="form">
                    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                    <div class="form-group <?=$model->getFirstError('title') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">标题</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="Article[title]" type="text" class="form-control" style="width:300px;" value="<?=$model->title?>" autofocus="autofocus">
                            <label for="title" class="help-block"><?=$model->getFirstError('title')?></label>
                        </div>
                    </div>
                    <div class="form-group <?=$model->getFirstError('second_title') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">副标题</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="Article[second_title]" type="text" class="form-control" style="width:300px;" value="<?=$model->second_title?>" autofocus="autofocus">
                            <label for="second_title" class="help-block"><?=$model->getFirstError('second_title')?></label>
                        </div>
                    </div>
                     <div class="form-group <?=$model->getFirstError('keyword') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">关键词</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="Article[keyword]" type="text" class="form-control" style="width:300px;" value="<?=$model->keyword?>" autofocus="autofocus">
                            <label for="keyword" class="help-block"><?=$model->getFirstError('keyword')?></label>
                        </div>
                    </div>
                    <div class="form-group <?=$model->getFirstError('author_name') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">作者</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="Article[author_name]" type="text" class="form-control" style="width:300px;" value="<?=$model->author_name?>" autofocus="autofocus">
                            <label for="author_name" class="help-block"><?=$model->getFirstError('author_name')?></label>
                        </div>
                    </div>
                    <div class="form-group <?=$model->getFirstError('publish_time') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">发布时间</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="Article[publish_time]" onclick="WdatePicker()" type="text" class="form-control" style="width:150px;" value="<?=date('Y-m-d', $model->publish_time)?>" autofocus="autofocus">
                            <label for="publish_time" class="help-block"><?=$model->getFirstError('publish_time')?></label>
                        </div>
                    </div>


                    <div class="form-group <?=$model->getFirstError('menu_id') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">所属菜单</label>
                        <div class="col-lg-10 col-md-10">
                            <select class="form-control" style="width:auto;" name="Article[menu_id]">
                                <?=(new Menu)->getMenuOptions($menus, $model->menu_id)?>
                            </select>
                            <label for="menu_id" class="help-block"><?=$model->getFirstError('menu_id')?></label>
                        </div>
                    </div>

                    <div class="form-group <?=$model->getFirstError('content') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">内容</label>
                        <div class="col-lg-10 col-md-10">
                        <div id="editor"><?=$model->content?></div>
                            <label for="content" class="help-block"><?=$model->getFirstError('content')?></label>
                        </div>
                        <textarea id="ct" name="Article[content]" style="display:none;"><?=$model->content?></textarea>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2">
                            <button class="btn btn-default ml15" type="submit">修改</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
initSample();
$(document).ready(function(){
    $("#form").submit(function(){
        $("#ct").text(CKEDITOR.instances.editor.getData());
        $("#form").submit();
    });
});
</script>
