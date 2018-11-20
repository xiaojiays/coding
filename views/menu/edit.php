<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default toggle" id="spr_0">
            <div class="panel-heading">
                <h3 class="panel-title">修改菜单</h3>
                <div class="panel-controls panel-controls-hide" style="display: none;">
                    <a href="#" class="toggle panel-minimize">
                        <i class="im-minus"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <form method="post" action="/menu/update?id=<?=$model->id?>" class="form-horizontal group-border hover-stripped" role="form" enctype="multipart/form-data">
                    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                    <div class="form-group <?=$model->getFirstError('name') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">菜单名称</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="Menu[name]" type="text" class="form-control" style="width:300px;" value="<?=$model->name?>" autofocus="autofocus">
                            <label for="name" class="help-block"><?=$model->getFirstError('name')?></label>
                        </div>
                    </div>
                    <div class="form-group <?=$model->getFirstError('uname') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">链接名称</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="Menu[uname]" type="text" class="form-control" style="width:300px;" value="<?=$model->uname?>" autofocus="autofocus">
                            <label for="uname" class="help-block"><?=$model->getFirstError('uname')?></label>
                        </div>
                    </div>

                    <div class="form-group <?=$model->getFirstError('pid') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">上级菜单</label>
                        <div class="col-lg-10 col-md-10">
                            <select class="form-control" style="width:auto;" name="Menu[pid]">
                                <?=$model->getMenuOptions($menus, $model->pid)?>
                            </select>
                            <label for="pid" class="help-block"><?=$model->getFirstError('pid')?></label>
                        </div>
                    </div>
                    <div class="form-group <?=$model->getFirstError('type') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">类型</label>
                        <div class="col-lg-10 col-md-10">
                            <select class="form-control" style="width:auto;" name="Menu[type]">
                                <option value="0">类型1</option>
                                <option value="1" <?=$model->type==1 ? 'selected':''?>>类型2</option>
                                <option value="2" <?=$model->type==3 ? 'selected':''?>>类型3</option>
                            </select>
                            <label for="type" class="help-block"><?=$model->getFirstError('type')?></label>
                        </div>
                    </div>



                    <div class="form-group <?=$model->getFirstError('icon') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">图标</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="Menu[icon]" type="file" class="form-control" style="width:300px;" value="" autofocus="autofocus">
                        <label for="icon" class="help-block"><?=$model->getFirstError('icon')?></label>
                        </div>
                    </div>
                    <div class="form-group <?=$model->getFirstError('keywords') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">关键词</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="Menu[keywords]" type="text" class="form-control" style="width:300px;" value="<?=$model->keywords ?>" autofocus="autofocus">
                            <label for="keywords" class="help-block"><?=$model->getFirstError('keywords')?></label>
                        </div>
                    </div>

                    <div class="form-group <?=$model->getFirstError('desc') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">描述</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="Menu[desc]" type="text" class="form-control" style="width:300px;" value="<?=$model->desc ?>" autofocus="autofocus">
                            <label for="desc" class="help-block"><?=$model->getFirstError('desc')?></label>
                        </div>
                    </div>

                    <div class="form-group <?=$model->getFirstError('sortNo') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">排序数</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="Menu[sortNo]" type="text" class="form-control" style="width:300px;" value="<?=$model->sortNo ? $model->sortNo : 0 ?>" autofocus="autofocus">
                            <label for="sortNo" class="help-block"><?=$model->getFirstError('sortNo')?></label>
                        </div>
                    </div>
                    <div class="form-group <?=$model->getFirstError('status') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">状态</label>
                        <div class="col-lg-10 col-md-10">
                            <select class="form-control" style="width:auto;" name="Menu[status]">
                                <?=$model->getStatusOptions()?>
                            </select>
                            <label for="status" class="help-block"><?=$model->getFirstError('status')?></label>
                        </div>
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
