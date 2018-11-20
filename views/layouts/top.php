        <div id="header" class="header-fixed">
            <div class="container-fluid">
                <div class="navbar">
                    <div class="navbar-header">
                    </div>
                    <nav class="top-nav" role="navigation">
                        <ul class="nav navbar-nav pull-right">
                            <li>
                                <a href="#" data-toggle="dropdown">你好，<?=Yii::$app->user->identity->name?></a>
                            </li>
                            <li><a href="/user/logout">退出</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div> 
