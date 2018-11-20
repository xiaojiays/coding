<?php
use yii\widgets\LinkPager;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default plain toggle panelClose panelRefresh" id="spr_0">
            <div class="panel-heading white-bg">
                <h4 class="panel-title">权限列表</h4>
                <div class="panel-controls panel-controls-hide" style="display: none;">
                    <a href="#" class="panel-refresh">
                        <i class="im-spinner6"></i>
                    </a>
                    <a href="#" class="toggle panel-minimize">
                        <i class="im-minus"></i>
                    </a>
                    <a href="#" class="panel-close">
                        <i class="im-close"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <?=Yii::$app->session->getFlash('flash_message') ? current(Yii::$app->session->getFlash('flash_message')) : ''?>
                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 100%; height: auto;">
                    <table class="table table-bordered" id="datatable" aria-describedby="datatable_info">
                        <thead>
                            <tr role="row">
                                <th>权限名称</th>
                                <th>权限描述</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>                
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                            <?php foreach ($data as $d) { ?>
                            <tr>
                                <td><?=$d->name?></td>
                                <td><?=$d->description?></td>
                                <td><?=date('Y-m-d H:i:s', $d->createdAt)?></td>
                                <td><a href="/permission/delete?name=<?=$d->name?>">删除</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
