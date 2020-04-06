<?php
    require_once '../inc/inc_sales_header.php';
  
    $err_msg = $_REQUEST[msg];
?>
    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>
<!-- /section:basics/sidebar -->
<div class="main-content">
    <div class="main-content-inner">
        <!-- #section:basics/content.breadcrumbs -->
        <?php require_once '../inc/inc_top_path.php'; ?>
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <!-- #section:pages/error -->
                    <div class="error-container">
                        <div class="well">
                            <h1 class="grey lighter smaller">
                                <span class="blue bigger-125"> <i class="ace-icon fa fa-random"></i> 500 </span> Something Went Wrong
                            </h1>
                            <hr />
                            <h3 class="lighter smaller">
                                But we are working
                                <i class="ace-icon fa fa-wrench icon-animated-wrench bigger-125"></i>
                                on it!
                            </h3>

                            <div class="space"></div>
                            <div>
                                <h4 class="lighter smaller">Meanwhile, try one of the following:</h4>
                                <ul class="list-unstyled spaced inline bigger-110 margin-15">
                                    <li>
                                        <i class="ace-icon fa fa-hand-o-right blue"></i>
                                        <?=$err_msg?>
                                    </li>
                                </ul>
                            </div>

                            <hr />
                            <div class="space"></div>
                            <div class="center">
                                <a href="javascript:history.back()" class="btn btn-grey"><i class="ace-icon fa fa-arrow-left"></i> Go Back</a>
                                <a href="http://sales.pkmall.co.kr/sales/dashboard.php" class="btn btn-primary">
                                        <i class="ace-icon fa fa-tachometer"></i> Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<?php
    require_once '../inc/inc_sales_footer.php';
?>     
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>
</div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script type="text/javascript">
                window.jQuery || document.write("<script src='../assets/js/jquery.js'>"+"<"+"/script>");
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
        <script type="text/javascript">
                if('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
        </script>
        <script src="../assets/js/bootstrap.js"></script>

        <!-- page specific plugin scripts -->

        <!-- ace scripts -->
        <script src="../assets/js/ace/elements.scroller.js"></script>
        <script src="../assets/js/ace/elements.colorpicker.js"></script>
        <script src="../assets/js/ace/elements.fileinput.js"></script>
        <script src="../assets/js/ace/elements.typeahead.js"></script>
        <script src="../assets/js/ace/elements.wysiwyg.js"></script>
        <script src="../assets/js/ace/elements.spinner.js"></script>
        <script src="../assets/js/ace/elements.treeview.js"></script>
        <script src="../assets/js/ace/elements.wizard.js"></script>
        <script src="../assets/js/ace/elements.aside.js"></script>
        <script src="../assets/js/ace/ace.js"></script>
        <script src="../assets/js/ace/ace.ajax-content.js"></script>
        <script src="../assets/js/ace/ace.touch-drag.js"></script>
        <script src="../assets/js/ace/ace.sidebar.js"></script>
        <script src="../assets/js/ace/ace.sidebar-scroll-1.js"></script>
        <script src="../assets/js/ace/ace.submenu-hover.js"></script>
        <script src="../assets/js/ace/ace.widget-box.js"></script>
        <script src="../assets/js/ace/ace.settings.js"></script>
        <script src="../assets/js/ace/ace.settings-rtl.js"></script>
        <script src="../assets/js/ace/ace.settings-skin.js"></script>
        <script src="../assets/js/ace/ace.widget-on-reload.js"></script>
        <script src="../assets/js/ace/ace.searchbox-autocomplete.js"></script>

        <!-- inline scripts related to this page -->

        <!-- the following scripts are used in demo only for onpage help and you don't need them -->
        <link rel="stylesheet" href="../assets/css/ace.onpage-help.css" />
        <link rel="stylesheet" href="../docs/assets/js/themes/sunburst.css" />

        <script type="text/javascript"> ace.vars['base'] = '..'; </script>
        <script src="../assets/js/ace/elements.onpage-help.js"></script>
        <script src="../assets/js/ace/ace.onpage-help.js"></script>
        <script src="../docs/assets/js/rainbow.js"></script>
        <script src="../docs/assets/js/language/generic.js"></script>
        <script src="../docs/assets/js/language/html.js"></script>
        <script src="../docs/assets/js/language/css.js"></script>
        <script src="../docs/assets/js/language/javascript.js"></script>
    </body>
</html>
