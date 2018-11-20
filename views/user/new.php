<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default toggle" id="spr_0">
            <div class="panel-heading">
                <h3 class="panel-title">添加管理员</h3>
                <div class="panel-controls panel-controls-hide" style="display: none;">
                    <a href="#" class="toggle panel-minimize">
                        <i class="im-minus"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <form method="post" action="/user/create" class="form-horizontal group-border hover-stripped" role="form">
                    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                    <div class="form-group <?=$model->getFirstError('email') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">邮箱</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="CreateUserForm[email]" type="text" class="form-control" style="width:300px;" value="<?=$model->email?>" autofocus="autofocus">
                            <label for="email" class="help-block"><?=$model->getFirstError('email')?></label>
                        </div>
                    </div>
                    <div class="form-group <?=$model->getFirstError('name') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">姓名</label>
                        <div class="col-lg-10 col-md-10">
                        <input name="CreateUserForm[name]" type="text" class="form-control" style="width:200px;" value="<?=$model->name?>" autofocus="autofocus">
                            <label for="name" class="help-block"><?=$model->getFirstError('name')?></label>
                        </div>
                    </div>
                    <div class="form-group <?=$model->getFirstError('password') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">初始密码</label>
                        <div class="col-lg-10 col-md-10">
                            <input name="CreateUserForm[password]" type="password" class="form-control" style="width:300px;" autofocus="autofocus">
                            <label for="password" class="help-block"><?=$model->getFirstError('password')?></label>
                        </div>
                    </div>
                    <div class="form-group <?=$model->getFirstError('passwordConfirm') ? 'has-error' : ''?>">
                        <label class="col-lg-2 col-md-2 col-sm-12 control-label">初始密码确认</label>
                        <div class="col-lg-10 col-md-10">
                            <input name="CreateUserForm[passwordConfirm]" type="password" class="form-control" style="width:300px;" autofocus="autofocus">
                            <label for="passwordConfirm" class="help-block"><?=$model->getFirstError('passwordConfirm
')?></label>
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
