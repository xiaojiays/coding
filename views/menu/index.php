<?php
use yii\widgets\LinkPager;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default plain toggle panelClose panelRefresh" id="spr_0">
            <div class="panel-heading white-bg">
                <h4 class="panel-title">菜单列表</h4>
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
                                <th>菜单名称</th>
                                <th>图标</th>
                                <th>链接名称</th>
                                <th>上级菜单</th>
                                <th>排序数</th>
                                <th>创建时间</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                            <?php foreach ($data as $d) { ?>
                            <tr>
                                <td><?=$d->name?></td>
                                <td><?php if ($d->icon) {?><img width="20" height="20" src="/uploads/<?=$d->icon?>" /><?php } ?></td>
                                <td><?=$d->uname?></td>
                                <td><?=$d->getParentName($menus)?></td>
                                <td><?=$d->sortNo?></td>
                                <td><?=date('Y-m-d H:i:s', $d->createdAt)?></td>
                                <td><?=$d->getStatusName()?></td>
                                <td><a href="/menu/status?id=<?=$d->id?>"><?=$d->getOppositeStatusName()?></a> | <a href="/menu/edit?id=<?=$d->id?>">编辑</a> <?php if ($d->pid) { ?>| <a target="_blank" href="/menu/grab?u=<?=$d->uname?>&t=<?=$d->type?>">抓取</a><?php } else {?> |
                                <a target="_blank" href="/menu/img?id=<?=$d->id?>">1</a>
                                <a target="_blank" href="/menu/link?id=<?=$d->id?>">2</a>
                                <a target="_blank" href="/menu/url?id=<?=$d->id?>">3</a>
                                <a target="_blank" href="/menu/clear?id=<?=$d->id?>">4</a>
 <?php } ?>| <a href="/menu/delete?id=<?=$d->id?>">删除</a></td>
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
