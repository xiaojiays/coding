<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default plain toggle panelClose panelRefresh" id="spr_0">
            <div class="panel-heading white-bg">
            <h4 class="panel-title"><?=$role->description?> - 权限管理</h4>
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
                <form method="post" action="/role/update?name=<?=$role->name?>" class="form-horizontal group-border hover-stripped" role="form">
                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 100%; height: auto;">
                    <table class="table table-bordered" id="datatable" aria-describedby="datatable_info">
                        <tbody role="alert" aria-live="polite" aria-relevant="all">

                        <?php
                            $i = 0;
                            $pre = '';
                            foreach ($permissions as $k=>$v) {
                                $arr = explode(':', $k);
                                if ($arr[0] != $pre) {
                                    if ($pre != '') {
                                        echo '</tr><tr><td colspan=4></td></tr><tr>';  
                                    }  
                                    $pre = $arr[0];
                                }
                                $s = '';    
                                if ($i%4 === 0) {
                                    $s = '<tr>';
                                }
                                $checked = isset($rolePermissions[$k]) ? 'checked' : '';
                                $s .= '<td><input name="permission[]" type="checkbox" value="'. $k .'"' . $checked . '/>' . $v->description . '</td>';
                                if ($i%4 === 0 && substr($s, 0, 4) != '<tr>') {
                                    $s .= '</tr>';
                                } 
                                echo $s;
                                $i++;
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2">
                            <button class="btn btn-default ml15" type="submit">更新</button> <a href="javascript:selectAll()">全选</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function selectAll() {
        var select = false;
        $("input[type=checkbox]").each(function(){
            if($(this).attr('checked') == "checked") {
                select = true;
            }
        });
        $("input[type=checkbox]").each(function(){
            if (select) {
                $(this).attr("checked", false);
                $(this).parent().removeClass("checked");  
            } else {
                $(this).attr("checked", "checked");
                $(this).parent().addClass("checked");
            }
        });
    }            
</script>
