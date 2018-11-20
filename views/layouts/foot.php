        <!-- Javascripts -->
        <!-- Load pace first -->
        <script src="/assets/plugins/core/pace/pace.min.js"></script>
        <!-- Important javascript libs(put in all pages) -->
        <script src="/assets/js/jquery-1.8.3.min.js"></script>
        <script>
        window.jQuery || document.write('<script src="/assets/js/libs/jquery-2.1.1.min.js">\x3C/script>')
        </script>
        <script src="/assets/js/jquery-ui.js"></script>
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
        <!-- Core plugins ( not remove ever) -->
        <!-- Handle responsive view functions -->
        <script src="/assets/js/jRespond.min.js"></script>
        <!-- Custom scroll for sidebars,tables and etc. -->
        <script src="/assets/plugins/core/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="/assets/plugins/core/slimscroll/jquery.slimscroll.horizontal.min.js"></script>
        <!-- Resize text area in most pages -->
        <script src="/assets/plugins/forms/autosize/jquery.autosize.js"></script>
        <!-- Proivde quick search for many widgets -->
        <script src="/assets/plugins/core/quicksearch/jquery.quicksearch.js"></script>
        <!-- Bootbox confirm dialog for reset postion on panels -->
        <script src="/assets/plugins/ui/bootbox/bootbox.js"></script>
        <!-- Other plugins ( load only nessesary plugins for every page) -->
        <script src="/assets/plugins/charts/flot/jquery.flot.js"></script>
        <script src="/assets/plugins/charts/flot/jquery.flot.pie.js"></script>
        <script src="/assets/plugins/charts/flot/jquery.flot.resize.js"></script>
        <script src="/assets/plugins/charts/flot/jquery.flot.time.js"></script>
        <script src="/assets/plugins/charts/flot/jquery.flot.growraf.js"></script>
        <script src="/assets/plugins/charts/flot/jquery.flot.categories.js"></script>
        <script src="/assets/plugins/charts/flot/jquery.flot.stack.js"></script>
        <script src="/assets/plugins/charts/flot/jquery.flot.tooltip.min.js"></script>
        <script src="/assets/plugins/charts/flot/date.js"></script>
        <script src="/assets/plugins/charts/sparklines/jquery.sparkline.js"></script>
        <script src="/assets/plugins/charts/pie-chart/jquery.easy-pie-chart.js"></script>
        <script src="/assets/plugins/forms/icheck/jquery.icheck.js"></script>
        <script src="/assets/plugins/forms/tags/jquery.tagsinput.min.js"></script>
        <script src="/assets/plugins/forms/tinymce/tinymce.min.js"></script>
        <script src="/assets/plugins/misc/highlight/highlight.pack.js"></script>
        <script src="/assets/plugins/misc/countTo/jquery.countTo.js"></script>
        <script src="/assets/plugins/ui/weather/skyicons.js"></script>
        <script src="/assets/plugins/ui/notify/jquery.gritter.js"></script>
        <script src="/assets/plugins/ui/calendar/fullcalendar.js"></script>
        <script src="/assets/js/jquery.sprFlat.js"></script>
        <script src="/assets/js/app.js"></script>
        <script src="/assets/js/pages/dashboard.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                var url = "/<?=Yii::$app->request->pathinfo?>";
                var find = false;
                var count = 0;
                $("#sideNav").find("a").each(function() {
                    if ($(this).attr("href") == url) {
                        find = true;
                        $(this).addClass("active");
                        $(this).parent().parent().prev().removeClass().addClass("active-state expand");
                        $(this).parent().parent().removeClass().addClass("nav sub show");
                    }
                });

                if (!find && count == 0) {
                    count++;
                    if (url.length > 0) {
                        var arr = url.split("/");
                        if (arr.length > 2) {
                            arr[2] = "index";
                        }
                    }
                    url = arr.join("/");
                    $("#sideNav").find("a").each(function() {
                        if ($(this).attr("href") == url) {
                            find = true;
                            $(this).addClass("active");
                            $(this).parent().parent().prev().removeClass().addClass("active-state expand");
                            $(this).parent().parent().removeClass().addClass("nav sub show");
                        }
                    });
                }
            });
        </script>
