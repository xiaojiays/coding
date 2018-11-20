<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default toggle" id="spr_0">
            <div class="panel-heading">
                <h3 class="panel-title">添加角色</h3>
                <div class="panel-controls panel-controls-hide" style="display: none;">
                    <a href="#" class="toggle panel-minimize">
                        <i class="im-minus"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <?=Yii::$app->session->getFlash('flash_message') ? current(Yii::$app->session->getFlash('flash_message')) : ''?>
                <form method="post" action="/role/create" class="form-horizontal group-border hover-stripped" role="form">
                    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                    <div class="form-group">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">角色名称</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="name" type="text" value="<?=$name?>" placeholder="author" class="form-control" style="width:300px;" autofocus="autofocus">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">角色描述</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="desc" type="text" value="<?=$desc?>"  placeholder="作者" class="form-control" style="width:300px;" autofocus="autofocus">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2">
                            <button class="btn btn-default ml15" type="submit">添加</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
