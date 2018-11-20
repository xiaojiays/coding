<?php
use yii\widgets\LinkPager;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default plain toggle panelClose panelRefresh" id="spr_0">
            <div class="panel-heading white-bg">
                <h4 class="panel-title">管理员列表</h4>
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
                                <th>姓名</th>
                                <th>角色</th>
                                <th>创建时间</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>                
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                            <?php foreach ($data as $d) { ?>
                            <tr>
                                <td><?=$d->name?></td>
                                <td><?=$d->getRoles()?></td>
                                <td><?=date('Y-m-d H:i:s', $d->createdAt)?></td>
                                <td><?=$d->getStatusName()?></td>
                                <td><a href="/user/role?id=<?=$d->id?>">角色管理</a> | <a href="/user/status?id=<?=$d->id?>"><?=$d->getOppositeStatusName()?></a> | <a href="/user/delete?id=<?=$d->id?>">删除</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="row-" style="text-align:center;">
                        <?php
                            echo LinkPager::widget([
                                'pagination' => $pages,
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
