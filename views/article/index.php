<?php
use yii\widgets\LinkPager;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default plain toggle panelClose panelRefresh" id="spr_0">
            <div class="panel-heading white-bg">
                <h4 class="panel-title">文章列表</h4>
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
                                <th>标题</th>
                                <th>副标题</th>
                                <th>所属菜单</th>
                                <th>关键词</th>
                                <th>发布时间</th>
                                <th>创建时间</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>                
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                            <?php foreach ($data as $d) { ?>
                            <tr>
                                <td><?=$d->title?></td>
                                <td><?=$d->second_title?></td>
                                <td><?=$d->getMenuName($menus)?></td>
                                <td><?=$d->keyword?></td>
                                <td><?=date('Y-m-d', $d->publish_time)?></td>
                                <td><?=date('Y-m-d H:i:s', $d->createdAt)?></td>
                                <td><?=$d->getStatusName()?></td>
                                <td><a href="/article/status?id=<?=$d->id?>"><?=$d->getOppositeStatusName()?></a> | <a href="/article/edit?id=<?=$d->id?>">编辑</a> | <a href="/article/delete?id=<?=$d->id?>">删除</a></td>
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
