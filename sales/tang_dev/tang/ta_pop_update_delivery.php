<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Form Elements - Ace Admin</title>

		<meta name="description" content="Common form elements and layouts" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="../assets/css/bootstrap.css" />
		<link rel="stylesheet" href="../assets/css/font-awesome.css" />

		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="../assets/css/jquery-ui.custom.css" />
		<link rel="stylesheet" href="../assets/css/chosen.css" />
		<link rel="stylesheet" href="../assets/css/datepicker.css" />
		<link rel="stylesheet" href="../assets/css/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="../assets/css/daterangepicker.css" />
		<link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.css" />
		<link rel="stylesheet" href="../assets/css/colorpicker.css" />

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

	<body class="no-skin">
		<!-- #section:basics/navbar.layout -->
		

		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">


			<!-- /section:basics/sidebar -->
			<div class="main-content">
				<div class="main-content-inner">
					<!-- #section:basics/content.breadcrumbs -->

					<!-- /section:basics/content.breadcrumbs -->
					<div class="page-content">


                                            잠시만 기다려 주세요...
                                            
                                            
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			

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

	



	</body>
</html>
<?php

    require_once "../autoload.php";
   
    $req_delivery = $_REQUEST[delivery];
    $req_st_date = $_REQUEST[st_date];
    $req_branch = $_REQUEST[branch];
    $req_tag = $_REQUEST[tag];
    
    switch($req_delivery){
        case 'cj': $cd_delivery = 11; break;
        case 'woo': $cd_delivery = 12; break;        
        case 'ems': $cd_delivery = 13; break;     
    }
    
    $get_post = Array();    
    
    $get_post[ta_delivery] = $cd_delivery;
   // $get_post[doc_date] = $req_st_date;   
           
    $obj = new class_shipTa();
    switch($req_tag){
        
        case 'l': $update = $obj->updateBatchDelivery($get_post, $req_st_date, $req_branch); break;
        case 's':$update = $obj->updateBatchSendDelivery($get_post, $req_st_date, $req_branch);  break;
        
    }
      
    
   if( gettype($update) == string){
        echo '<script type="text/javascript">                      
                window.location = "../common/svr_error.php?msg='.$insert.'";
            </script>';
    }else {
        echo '<script type="text/javascript">                      
                    
        
            setTimeout(function(){
                opener.parent.location.reload();
                window.close();
            }, 3000);
           
        </script>';
    }
   
 