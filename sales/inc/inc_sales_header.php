<?php
    require_once '../autoload.php'; 
   require_once 'inc_auth.php';        
?>

<!DOCTYPE html>
<html lang="euc-kr">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>편강한방 연구소</title>

        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="../assets/css/bootstrap.css" />
        <link rel="stylesheet" href="../assets/css/font-awesome.css" />

        <!-- page specific plugin styles -->
      

        <!-- text fonts -->
        <link rel="stylesheet" href="../assets/css/ace-fonts.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="../assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="../assets/css/ace-part2.css" class="ace-main-stylesheet" />
        <![endif]-->

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="../assets/css/ace-ie.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src="../assets/js/ace-extra.js"></script>

        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src="../assets/js/html5shiv.js"></script>
        <script src="../assets/js/respond.js"></script>
        <![endif]-->
    </head>
    <?php
       $basename = basename($_SERVER["PHP_SELF"]);
       
       switch($basename){
           
           case 'ta_xls_upload.php'; $upload = "active"; $history = ""; $list = "";$reserve=""; $stats = ""; $cancel=""; break;
           case 'ta_history_list.php'; $upload = ""; $history = "active"; $list = ""; $reserve="";$stats = ""; $cancel=""; break;
           case 'ta_delivery_list.php'; $upload = ""; $history = ""; $list = "active"; $reserve="";$stats = ""; $cancel=""; break;
           case 'ta_reserve_list.php'; $upload = ""; $history = ""; $list = "";$reserve="active"; $stats = ""; $cancel=""; break;
           case 'ta_stats.php'; $upload = ""; $history = ""; $list = "";$reserve=""; $stats = "active"; $cancel=""; break;
           case 'ta_cancel_list.php'; $upload = ""; $history = ""; $list = "";$reserve=""; $stats = "";$cancel = "active"; break;
           
       }
    ?>

<body class="no-skin">
    <!-- #section:basics/navbar.layout -->
    <div id="navbar" class="navbar navbar-default">
        <script type="text/javascript">
            try{ace.settings.check('navbar' , 'fixed')}catch(e){}
        </script>

        <div class="navbar-container" id="navbar-container">
            <!-- #section:basics/sidebar.mobile.toggle -->
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                <span class="sr-only">Toggle sidebar</span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>
            </button>

            <!-- /section:basics/sidebar.mobile.toggle -->
            <div class="navbar-header pull-left">
                <!-- #section:basics/navbar.layout.brand -->
                <a href="#" class="navbar-brand">
                    <small>
                        <i class="fa fa-leaf"></i>
                        편강 한방 연구소
                    </small>
                </a>
            </div>

				<!-- #section:basics/navbar.dropdown -->
            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">

                    <!-- #section:basics/navbar.user_menu -->
                    <li class="light-blue">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                         <!--   <img class="nav-user-photo" src="../assets/avatars/user.jpg" alt="Jason's Photo" /> -->
                            <span class="user-info">
                                    <small>Login,</small>
                                    <?=$_SESSION[s_name]?>
                            </span>

                            <i class="ace-icon fa fa-caret-down"></i>
                        </a>

                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li>
                                <a href="../creator/ct_mod.php">
                                    <i class="ace-icon fa fa-cog"></i>
                                    정보수정
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="../login/login_out.php">
                                    <i class="ace-icon fa fa-power-off"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>

                <!-- /section:basics/navbar.user_menu -->
                </ul>
            </div>
	<!-- /section:basics/navbar.dropdown -->
        </div><!-- /.navbar-container -->
    </div>

		<!-- /section:basics/navbar.layout -->
    <div class="main-container" id="main-container">
        <script type="text/javascript">
                try{ace.settings.check('main-container' , 'fixed')}catch(e){}
        </script>

			<!-- #section:basics/sidebar -->
        <div id="sidebar" class="sidebar                  responsive">
            <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
            </script>

            <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                    <button class="btn btn-success">
                            <i class="ace-icon fa fa-signal"></i>
                    </button>
                    <button class="btn btn-info">
                            <i class="ace-icon fa fa-pencil"></i>
                    </button>
                    <!-- #section:basics/sidebar.layout.shortcuts -->
                    <button class="btn btn-warning">
                            <i class="ace-icon fa fa-users"></i>
                    </button>
                    <button class="btn btn-danger">
                            <i class="ace-icon fa fa-cogs"></i>
                    </button>
                    <!-- /section:basics/sidebar.layout.shortcuts -->
                </div>

                <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                    <span class="btn btn-success"></span>
                    <span class="btn btn-info"></span>
                    <span class="btn btn-warning"></span>
                    <span class="btn btn-danger"></span>
                </div>
            </div><!-- /.sidebar-shortcuts -->

            <ul class="nav nav-list">
                <li class="active open">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-pencil-square-o"></i>
                        <span class="menu-text"> 판매현황 </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        
                        <li class="<?=$list?>">
                            <a href="../sales/dashboard.php">
                                <i class="menu-icon fa fa-caret-right"></i>
                                판매 현황(실시간)
                            </a>

                            <b class="arrow"></b>
                        </li>                           
                     
                        <li class="<?=$history?>">
                            <a href="../sales/daily_sales.php">
                                <i class="menu-icon fa fa-caret-right"></i>
                                일별
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="<?=$history?>">
                            <a href="../sales/monthly_sales.php">
                                <i class="menu-icon fa fa-caret-right"></i>
                                월별
                            </a>
                            <b class="arrow"></b>
                        </li>
                       
                        <?php
                            if($_SESSION[s_auth] == 0){
                        ?>
                        <li class="<?=$history?>">
                            <a href="../report/sal_report.php">
                                <i class="menu-icon fa fa-caret-right"></i>
                                월간 REPORT
                            </a>
                            <b class="arrow"></b>
                        </li>   
                         <!--
                        <li class="">
                            <a href="#" class="dropdown-toggle">
                                <i class="menu-icon fa fa-caret-right"></i> 판매 수단별 통계<b class="arrow fa fa-angle-down"></b>
                            </a>
                            <b class="arrow"></b>
                            <ul class="submenu">                            
                                <li class="">
                                    <a href="../report/sal_stats.php?ct_id=pk_tlsdmlgkstn"><i class="menu-icon fa fa-caret-right"></i> 신의 한 수 </a>
                                    <b class="arrow"></b>
                                </li>
                                <li class="">
                                    <a href="../report/sal_stats.php?ct_id=pk_gong"><i class="menu-icon fa fa-caret-right"></i> 공병호 TV </a>
                                    <b class="arrow"></b>
                                </li>
                            </ul>
                        </li>
                                 -->                
                        <?php
                            }
                            if($_SESSION[s_auth] == 0){
                        ?> <!--
                       <li class="<?=$history?>">
                            <a href="../sales/index.php">
                                <i class="menu-icon fa fa-caret-right"></i>
                                판매 리스트
                            </a>
                            <b class="arrow"></b>
                        </li>
                    -->   
                            <?php } ?>
                          
                    </ul>
                </li>
                       
                <?php
                    if($_SESSION[s_auth] == 0){
                ?>
                 <li class="active open">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-desktop"></i>
                        <span class="menu-text">관리자</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="">
                            <a href="#" class="dropdown-toggle">
                                <i class="menu-icon fa fa-caret-right"></i> 크리에이터 관리<b class="arrow fa fa-angle-down"></b>
                            </a>
                            <b class="arrow"></b>
                            <ul class="submenu">                            
                                <li class="">
                                    <a href="../creator/creator_list.php"><i class="menu-icon fa fa-caret-right"></i>리스트 </a>
                                    <b class="arrow"></b>
                                </li>
                                <li class="">
                                    <a href="../creator/creator_reg.php"><i class="menu-icon fa fa-caret-right"></i>등록</a>
                                    <b class="arrow"></b>
                                </li>
                            </ul>
                        </li>
                        <!--
                        <li class="">
                            <a href="../creator/creator_rs.php"><i class="menu-icon fa fa-caret-right"></i>RS 유입량/전환</a>
                            <b class="arrow"></b>
                        </li>
                        -->
                        <li class="">
                            <a href="../creator/ct_rs_rate.php"><i class="menu-icon fa fa-caret-right"></i>RS RATE </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="">
                            <a href="../sales/sal_schedule.php"><i class="menu-icon fa fa-caret-right"></i>스케줄 관리</a>
                            <b class="arrow"></b>
                        </li>
                        <li class="">
                            <a href="../sales/stats_sales.php"><i class="menu-icon fa fa-caret-right"></i>판매통계 </a>
                            <b class="arrow"></b>
                        </li>
                        <!-- 수요일 오픈
                        <li class="">
                            <a href="../item/item_list.php"><i class="menu-icon fa fa-caret-right"></i>제품관리</a>
                            <b class="arrow"></b>
                        </li>                    
                        -->
                    </ul>
                </li>
                <?php
                    }
                ?>
               
            
            </ul><!-- /.nav-list -->
        <!-- #section:basics/sidebar.layout.minimize -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
      