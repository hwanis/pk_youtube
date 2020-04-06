<?php
    
?>
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
                                Missyoon Admin
                        </small>
                </a>

                <!-- /section:basics/navbar.layout.brand -->

                <!-- #section:basics/navbar.toggle -->

                <!-- /section:basics/navbar.toggle -->
        </div>

            <!-- #section:basics/navbar.dropdown -->
        <div class="navbar-buttons navbar-header pull-right" role="navigation" >
            <ul class="nav ace-nav">

                <!-- #section:basics/navbar.user_menu -->
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">                                           
                        <span class="user-info">
                            <small></small>
                            <?=$_SESSION[m_name]?>(<?=$_SESSION[m_id]?>)
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li>
                                <a href="../member/user_view.php?m_id=<?=$_SESSION[m_id]?>">
                                        <i class="ace-icon fa fa-cog"></i>
                                        Settings
                                </a>
                            </li>                                          
                            <li class="divider"></li>

                            <li>
                                <?php                                               
                                    if($_SESSION[m_id] == ''){
                                ?>
                                <a href="../login/login.php">
                                    <i class="ace-icon fa fa-power-off"></i>
                                    로그인
                                </a>                                                 
                                <?php
                                    }else {
                                ?>
                                    <a href="../login/login_out.php">
                                    <i class="ace-icon fa fa-power-off"></i>  
                                    로그아웃
                                    </a>
                                <?php
                                    }
                                ?>
                            </li>
                    </ul>
                </li>

            </ul>
        </div>

            <!-- /section:basics/navbar.dropdown -->
    </div><!-- /.navbar-container -->
</div>