<!DOCTYPE html>
<html lang="utf-8">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Login Page - Missyoon Admin</title>

        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="../assets/css/bootstrap.css" />
        <link rel="stylesheet" href="../assets/css/font-awesome.css" />

        <!-- text fonts -->
        <link rel="stylesheet" href="../assets/css/ace-fonts.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="../assets/css/ace.css" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="../assets/css/ace-part2.css" />
        <![endif]-->
        <link rel="stylesheet" href="../assets/css/ace-rtl.css" />

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="../assets/css/ace-ie.css" />
        <![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="../assets/js/html5shiv.js"></script>
        <script src="../assets/js/respond.js"></script>
        <![endif]-->
       
    </head>
   
<body class="login-layout  light-login">
    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="login-container">
                        <div class="center">
                            <h1>
                                <span class="red"></span>
                                <span class="white" id="id-text2"></span>
                            </h1>
                            <h4 class="blue" id="id-company-text"></h4>
                        </div>

                        <div class="space-6"></div>
                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main center">
                                            <h4 class="header blue lighter bigger">
                                                Creator Manager Login
                                            </h4>

                                            <div class="space-6"></div>
                                               
                                                <form name="login_form" action="login_pr.php"  class="form-horizontal" role="form" enctype="multipart/form-data" >
                                                    <fieldset>
                                                        <label class="block clearfix">
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" name="ct_id" class="form-control" placeholder="로그인 아이디" />
                                                                    <i class="ace-icon fa fa-user"></i>
                                                            </span>
                                                        </label>

                                                        <label class="block clearfix">
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="password" name="ct_pass" class="form-control" placeholder="비밀번호" />
                                                                <i class="ace-icon fa fa-lock"></i>
                                                            </span>
                                                        </label>

                                                            <div class="space"></div>
                                                                <div class="clearfix">
                                                                    <button type="button" class="width-35 pull-right btn btn-sm btn-primary"  onclick="javascript:SubmitLogin(this.form)">
                                                                        <i class="ace-icon fa fa-key"></i>
                                                                        <span class="bigger-110">Login</span>
                                                                    </button>                                                                     
                                                                </div>
 
                                                                <div class="space-4"></div>
                                                            </fieldset>
                                                    </form>
                                                </div><!-- /.widget-main -->
                                            </div><!-- /.widget-body -->
                                        </div><!-- /.login-box -->

                                       
                                    </div><!-- /.position-relative -->

                            </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.main-content -->
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
        
                 <!-- common js -->
        <script src="../js/common.js"></script>
        <!-- form check -->
        <script src="../js/form_check.js"></script>
        
        <script type="text/javascript">
            function SubmitLogin(form) {
              
                var str_ct_id = fn_str_trim(form.ct_id.value);
                var str_ct_pass = fn_str_trim(form.ct_pass.value);

                if (str_ct_id.length <2 || str_ct_id.length > 21){
                    alert("아이디를 정확히 입력 해주세요.");
                    form.ct_id.focus();
                    return;
                }
                
              //  alert(str_ct_pass.length);
                
                if (str_ct_pass.length < 2  || str_ct_pass.length > 21 ){
                    alert("비밀번호를 정확히 입력 해주세요.");        
                    form.ct_pass.focus();
                    return;
                } 

                form.submit();

            }
        </script>
        
        <script type="text/javascript">
                if('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
        </script>
        
        <!-- inline scripts related to this page -->
        <script type="text/javascript">
                jQuery(function($) {
                 $(document).on('click', '.toolbar a[data-target]', function(e) {
                        e.preventDefault();
                        var target = $(this).data('target');
                        $('.widget-box.visible').removeClass('visible');//hide others
                        $(target).addClass('visible');//show target
                 });
                });

                //you don't need this, just used for changing background
               jQuery(function($) {
               /*   $('#btn-login-dark').on('click', function(e) {
                        $('body').attr('class', 'login-layout');
                        $('#id-text2').attr('class', 'white');
                        $('#id-company-text').attr('class', 'blue');

                        e.preventDefault();
                 });
                 $('#btn-login-light').on('click', function(e) {
                        $('body').attr('class', 'login-layout light-login');
                        $('#id-text2').attr('class', 'grey');
                        $('#id-company-text').attr('class', 'blue');

                        e.preventDefault();
                 });
                 */
                 $('#btn-login-blur').on('click', function(e) {
                        $('body').attr('class', 'login-layout blur-login');
                        $('#id-text2').attr('class', 'white');
                        $('#id-company-text').attr('class', 'light-blue');

                        e.preventDefault();
                 });

                });
        </script>
    </body>
</html>
