<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>登录</title>
        <!-- Mobile specific metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- Force IE9 to render in normal mode -->
        <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
        <meta name="author" content="SuggeElson" />
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        <meta name="application-name" content="sprFlat admin template" />
        <!-- Import google fonts - Heading first/ text second -->
        <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:400,700|Droid+Sans:400,700' />
        <!--[if lt IE 9]>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" />
        <![endif]-->
        <!-- Css files -->
        <!-- Icons -->
        <link href="/assets/css/icons.css" rel="stylesheet" />
        <!-- jQueryUI -->
        <link href="/assets/css/sprflat-theme/jquery.ui.all.css" rel="stylesheet" />
        <!-- Bootstrap stylesheets (included template modifications) -->
        <link href="/assets/css/bootstrap.css" rel="stylesheet" />
        <!-- Plugins stylesheets (all plugin custom css) -->
        <link href="/assets/css/plugins.css" rel="stylesheet" />
        <!-- Main stylesheets (template main css file) -->
        <link href="/assets/css/main.css" rel="stylesheet" />
        <!-- Custom stylesheets ( Put your own changes here ) -->
        <link href="/assets/css/custom.css" rel="stylesheet" />
        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/img/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/img/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/img/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="/assets/img/ico/apple-touch-icon-57-precomposed.png">
        <link rel="icon" href="/assets/img/ico/favicon.ico" type="image/png">
        <!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->
        <meta name="msapplication-TileColor" content="#3399cc" />
    </head>
    <body class="login-page">
        <!-- Start #login -->
        <div id="login" class="animated bounceIn">
            <!-- Start .login-wrapper -->
            <div class="login-wrapper">
                <ul id="myTab" class="nav nav-tabs nav-justified bn">
                    <li>
                        <a href="#log-in" data-toggle="tab">登录</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content bn">
                    <div class="tab-pane fade active in" id="log-in">
                        <form class="form-horizontal mt10" action="/user/signin" id="login-form" method="post" role="form">
                            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                            <div class="form-group <?=$model->getErrors() ? 'has-error' : ''?>">
                                <div class="col-lg-12">
                                    <input type="text" name="email" id="email" value="<?=$model->email?>" class="form-control left-icon" placeholder="邮箱">
                                    <label for="email" class="help-block"><?=$model->getFirstError('email')?></label>
                                    <i class="ec-user s16 left-input-icon"></i>
                                </div>
                            </div>
                            <div class="form-group <?=$model->getErrors() ? 'has-error' : ''?>">
                                <div class="col-lg-12">
                                    <input type="password" name="password" id="password" class="form-control left-icon" placeholder="密码">
                                    <label for="password" class="help-block"><?=$model->getFirstError('password')?></label>
                                    <i class="ec-locked s16 left-input-icon"></i>
                                    <span class="help-block"><a href="#"><small>忘记密码 ?</small></a></span> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                                    <!-- col-lg-12 start here -->
                                    <label class="checkbox">
                                        <input type="checkbox" name="rememberMe" id="rememberMe" value="1">记住我 ?
                                    </label>
                                </div>
                                <!-- col-lg-12 end here -->
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-4">
                                    <!-- col-lg-12 start here -->
                                    <button class="btn btn-success pull-right" type="submit">登录</button>
                                </div>
                                <!-- col-lg-12 end here -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End #.login-wrapper -->
        </div>
        <!-- End #login -->
        <!-- Javascripts -->
        <!-- Load pace first -->
        <script src="/assets/plugins/core/pace/pace.min.js"></script>
        <!-- Important javascript libs(put in all pages) -->
        <script src="/assets/js/jquery-1.8.3.min.js"></script>
        <script>
        window.jQuery || document.write('<script src="/assets/js/libs/jquery-2.1.1.min.js">\x3C/script>')
        </script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script>
        window.jQuery || document.write('<script src="/assets/js/libs/jquery-ui-1.10.4.min.js">\x3C/script>')
        </script>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="/assets/js/libs/excanvas.min.js"></script>
        <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script type="text/javascript" src="/assets/js/libs/respond.min.js"></script>
        <![endif]-->
        <!-- Bootstrap plugins -->
        <script src="/assets/js/bootstrap/bootstrap.js"></script>
        <!-- Form plugins -->
        <script src="/assets/plugins/forms/icheck/jquery.icheck.js"></script>
        <script src="/assets/plugins/forms/validation/jquery.validate.js"></script>
        <script src="/assets/plugins/forms/validation/additional-methods.min.js"></script>
        <!-- Init plugins olny for this page -->
        <script src="/assets/js/pages/login.js"></script>
    </body>
</html>
