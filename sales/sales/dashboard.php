<?php
    require_once '../inc/inc_sales_header.php';
  //  echo $basename = basename($_SERVER["PHP_SELF"]);

  // test 20.04.14 git test 1234
  
    $req_s_id = $_SESSION[s_id];
    $to_date = date('Y-m-d');
    $ed_date = date("Y-m-d", strtotime("-10 days"));
    
    $obj = new class_sales();       //real db
    $obj_s = new class_stdata();    //sales db
    
   //item id 가져오기
    switch($_SESSION[s_auth]){  
        case 0: $where_item = ""; break;
        case 1: $where_item = " WHERE  ct_id = '$req_s_id' "; break;
    }

    $item_list = $obj_s->getCreatorItem($where_item);
    
    for($i=0;$i<count($item_list);$i++){        
        $item_list_id = $item_list_id.','.$item_list[$i][it_id];    
    }
    
    $arr_item_list_id = explode(',', $item_list_id);
    
    for($i=0; $i<count($arr_item_list_id);$i++){
        if($i==1){
            $str_it_id = "'".$arr_item_list_id[$i]."'";
        }else{
             $str_it_id = $str_it_id.','. "'".$arr_item_list_id[$i]."'";
        }        
    }
   
    switch($_SESSION[s_auth]){            
        case 0: 
            $where = " a.sal_date BETWEEN '$ed_date' AND '$to_date' ";    //주간
            $where_m = "";  //월간
            $where_r = " "; //실시간 데이터          
            break;
        case 1: 
            $where = " ct_id = '$req_s_id' AND a.sal_date BETWEEN '$ed_date' AND '$to_date' "; 
            $where_m = " WHERE  ct_id = '$_SESSION[s_id]'";
            $where_r = " ";
            /*
            if($req_s_id == 'pk_tlsdmlgkstn'){                
                $where_r = "WHERE it_id IN ('1573177193','1595421782','1580192523') ";
            }else{
                $where_r = "WHERE mb_level = '$req_s_id' ";
            }      
            */
            break;            
    }
        
    //실시간 데이터 가져오기
  

    $to_tot = $obj->getOrderTot( $to_date, $where_r, $_SESSION[s_id] );       
    $to_sin_tot = $obj->getOrderTot( $to_date, $where_r, 'pk_tlsdmlgkstn' ); 
    $to_pro_tot = $obj->getOrderTot( $to_date, $where_r, 'pk_vmfhdusdn' );
    $to_kevin_tot = $obj->getOrderTot( $to_date, $where_r, 'pk_kevin' );   
 
    //일간 판매 현황
    
    //신의 한수 실시간
    $to_sin_c_tot = $obj->getSinOrderTot( $to_date, 'c' );
    $to_sin_w_tot = $obj->getSinOrderTot( $to_date, 'w' );
        
    //  $where = " ct_id = '$req_s_id' AND sal_date BETWEEN '$ed_date' AND '$to_date' ";
    $daily_list = $obj_s->getDailyList($page_no = '', $page_list_no = '', $where, $req_s_id, 'dashboard', $_SESSION[s_auth]); 

    //월간 판매 현황
    switch($_SESSION[s_auth]){            
//        case 0: $where = " ";break;
 //       case 1: $where = " WHERE ct_id = '$_SESSION[s_id]' "; break;
    }
 
    $month_list =  $obj_s->getMohthlyList($page_no = '', $page_list_no = '', $where_m, $req_s_id, 'dashboard', $_SESSION[s_auth]);     
    //총 판매현황
    $tot_list =  $obj_s->getTotSales($req_s_id, $_SESSION[s_auth]);   
    
    //일반 유저
    $ct_tot = $obj->getUserOrderTot( $to_date, $_SESSION[s_id] );

?>
    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>

<!-- /section:basics/sidebar -->
<div class="main-content">
    <div class="main-content-inner">
         <?php require_once '../inc/inc_top_path.php';  ?> 현재 시간: <?=date("Y-m-d H:m:s")?>
        <!-- #section:basics/content.breadcrumbs -->
        
        <?php
            
        ?>
        
        <!-- left web, right call -->
        
        
     
      
        <!-- left web, right call -->
      
        
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <!-- /section:custom/extra.hr -->
                                        
                    <?php                       
                        if($_SESSION[s_auth] == 0){                     
                    ?>
                    <div class="col-sm-6">
                        <div class="widget-box transparent">
                             <h4 class="widget-title lighter"><i class="ace-icon fa fa-star orange"></i> 신의 한수(콜) </h4>
                            <div class="widget-body">
                                <div class="widget-main no-padding">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thin-border-bottom">
                                            <tr>                                               
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>품목</th>                                               
                                                <th class="hidden-480  center"><i class="ace-icon fa fa-caret-right blue"></i>판매수량</th>    
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>매출금액</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($i=0;$i<count($to_sin_c_tot);$i++){
                                            ?>
                                            <tr>
                                                <td style="text-align: left"> <?=$to_sin_c_tot[$i][it_name]?> </td>                                                
                                                <td  style="text-align: right"><?=$to_sin_c_tot[$i][tot_qty]?></td>
                                                <td style="text-align: right"><?= number_format($to_sin_c_tot[$i][tot_price])?></td>
                                            </tr>
                                            <?php
                                                    $tot_c_sin_price = $tot_c_sin_price + $to_sin_c_tot[$i][tot_price];
                                                    $tot_c_sin_qty = $tot_c_sin_qty + $to_sin_c_tot[$i][tot_qty];
                                                 }
                                            ?>                              
                                             <tr>
                                                <td  style="text-align: left"> 총 합계</td>                                               
                                                <td style="text-align: right"><b class="green"><?=$tot_c_sin_qty?></b></td>       
                                                <td style="text-align: right"><b class="green"><?=number_format($tot_c_sin_price)?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col --><!-- /.row -->                    
                   
                   <div class="col-sm-6">
                        <div class="widget-box transparent">
                             <h4 class="widget-title lighter"><i class="ace-icon fa fa-star orange"></i> 신의 한수(웹)</h4>
                            <div class="widget-body">
                                <div class="widget-main no-padding">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thin-border-bottom">
                                            <tr>                                               
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>품목</th>                                                
                                                <th class="hidden-480  center"><i class="ace-icon fa fa-caret-right blue"></i>판매수량</th>    
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>매출금액</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($i=0;$i<count($to_sin_w_tot);$i++){
                                            ?>
                                            <tr>
                                                <td style="text-align: left"> <?=$to_sin_w_tot[$i][it_name]?> </td>
                                               
                                                <td  style="text-align: right"><?=$to_sin_w_tot[$i][tot_qty]?></td>
                                                 <td style="text-align: right"><?= number_format($to_sin_w_tot[$i][tot_price])?></td>
                                            </tr>
                                            <?php
                                                    $tot_w_pro_price = $tot_w_pro_price + $to_sin_w_tot[$i][tot_price];
                                                    $tot_w_pro_qty = $tot_w_pro_qty + $to_sin_w_tot[$i][tot_qty];
                                                 }
                                            ?>                              
                                             <tr>
                                                <td  style="text-align: left"> 총 합계</td>                                                
                                                <td style="text-align: right"><b class="green"><?=$tot_w_pro_qty?></b></td>     
                                                <td style="text-align: right"><b class="green"><?=number_format($tot_w_pro_price)?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div>
                </div>
            </div>
            <div class="space-32"></div>
            
            
            
            <div class="hr hr-1 hr-dotted"></div>
                <div class="row">
                  <div class="col-xs-12">                      
                      <div class="col-sm-6">
                        <div class="widget-box transparent">
                             <h4 class="widget-title lighter"><i class="ace-icon fa fa-star orange"></i> 프로연우</h4>
                            <div class="widget-body">
                                <div class="widget-main no-padding">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thin-border-bottom">
                                            <tr>
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>품목</th>                                                
                                                <th class="hidden-480  center"><i class="ace-icon fa fa-caret-right blue"></i>판매수량</th>    
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>매출금액</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($i=0;$i<count($to_pro_tot);$i++){
                                            ?>
                                            <tr>
                                                <td style="text-align: left"> <?=$to_pro_tot[$i][it_name]?> </td>
                                                <td style="text-align: right"><?= number_format($to_pro_tot[$i][tot_price])?></td>
                                                <td  style="text-align: right"><?=$to_pro_tot[$i][tot_qty]?></td>
                                            </tr>
                                            <?php
                                                    $tot_pro_price = $tot_pro_price + $to_pro_tot[$i][tot_price];
                                                    $tot_pro_qty = $tot_pro_qty + $to_pro_tot[$i][tot_qty];
                                                 }
                                            ?>                              
                                             <tr>
                                                <td  style="text-align: left"> 총 합계</td>                                                
                                                <td style="text-align: right"><b class="green"><?=$tot_pro_qty?></b></td>     
                                                <td style="text-align: right"><b class="green"><?=number_format($tot_pro_price)?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div>
                     <div class="col-sm-6">
                        <div class="widget-box transparent">
                             <h4 class="widget-title lighter"><i class="ace-icon fa fa-star orange"></i> 케빈</h4>
                            <div class="widget-body">
                                <div class="widget-main no-padding">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thin-border-bottom">
                                            <tr>                                               
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>품목</th>                                               
                                                <th class="hidden-480  center"><i class="ace-icon fa fa-caret-right blue"></i>판매수량</th>    
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>매출금액</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($i=0;$i<count($to_kevin_tot);$i++){
                                            ?>
                                            <tr>
                                                <td style="text-align: left"> <?=$to_kevin_tot[$i][it_name]?> </td>
                                              
                                                <td  style="text-align: right"><?=$to_kevin_tot[$i][tot_qty]?></td>
                                                  <td style="text-align: right"><?= number_format($to_kevin_tot[$i][tot_price])?></td>
                                            </tr>
                                            <?php
                                                    $tot_kevin_price = $tot_kevin_price + $to_kevin_tot[$i][tot_price];
                                                    $tot_kevin_qty = $tot_kevin_qty + $to_kevin_tot[$i][tot_qty];
                                                 }
                                            ?>                              
                                             <tr>
                                                <td  style="text-align: left"> 총 합계</td>                                               
                                                <td style="text-align: right"><b class="green"><?=$tot_kevin_qty?></b></td>       
                                                <td style="text-align: right"><b class="green"><?=number_format($tot_kevin_price)?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col --><!-- /.row -->                    
                   
                    <?php
                        }else{
                            if($_SESSION[s_id] == 'pk_tlsdmlgkstn'){
                    ?>
                    
                    
                    
                    <div class="col-sm-6">
                        <div class="widget-box transparent">
                             <h4 class="widget-title lighter"><i class="ace-icon fa fa-star orange"></i> 신의 한수(콜) </h4>
                            <div class="widget-body">
                                <div class="widget-main no-padding">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thin-border-bottom">
                                            <tr>                                               
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>품목</th>                                               
                                                <th class="hidden-480  center"><i class="ace-icon fa fa-caret-right blue"></i>판매수량</th>    
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>매출금액</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($i=0;$i<count($to_sin_c_tot);$i++){
                                            ?>
                                            <tr>
                                                <td style="text-align: left"> <?=$to_sin_c_tot[$i][it_name]?> </td>                                                
                                                <td  style="text-align: right"><?=$to_sin_c_tot[$i][tot_qty]?></td>
                                                <td style="text-align: right"><?= number_format($to_sin_c_tot[$i][tot_price])?></td>
                                            </tr>
                                            <?php
                                                    $tot_c_sin_price = $tot_c_sin_price + $to_sin_c_tot[$i][tot_price];
                                                    $tot_c_sin_qty = $tot_c_sin_qty + $to_sin_c_tot[$i][tot_qty];
                                                 }
                                            ?>                              
                                             <tr>
                                                <td  style="text-align: left"> 총 합계</td>                                               
                                                <td style="text-align: right"><b class="green"><?=$tot_c_sin_qty?></b></td>       
                                                <td style="text-align: right"><b class="green"><?=number_format($tot_c_sin_price)?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col --><!-- /.row -->     
                    <div class="col-sm-6">
                        <div class="widget-box transparent">
                             <h4 class="widget-title lighter"><i class="ace-icon fa fa-star orange"></i> 신의 한수(웹) </h4>
                            <div class="widget-body">
                                <div class="widget-main no-padding">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thin-border-bottom">
                                            <tr>                                               
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>품목</th>                                               
                                                <th class="hidden-480  center"><i class="ace-icon fa fa-caret-right blue"></i>판매수량</th>    
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>매출금액</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($i=0;$i<count($to_sin_w_tot);$i++){
                                            ?>
                                            <tr>
                                                <td style="text-align: left"> <?=$to_sin_w_tot[$i][it_name]?> </td>                                                
                                                <td  style="text-align: right"><?=$to_sin_w_tot[$i][tot_qty]?></td>
                                                <td style="text-align: right"><?= number_format($to_sin_w_tot[$i][tot_price])?></td>
                                            </tr>
                                            <?php
                                                    $tot_w_sin_price = $tot_w_sin_price + $to_sin_w_tot[$i][tot_price];
                                                    $tot_w_sin_qty = $tot_w_sin_qty + $to_sin_w_tot[$i][tot_qty];
                                                 }
                                            ?>                              
                                             <tr>
                                                <td  style="text-align: left"> 총 합계</td>                                               
                                                <td style="text-align: right"><b class="green"><?=$tot_w_sin_qty?></b></td>       
                                                <td style="text-align: right"><b class="green"><?=number_format($tot_w_sin_price)?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col --><!-- /.row -->     

                    <?php                                
                            }else{
                    ?>
                    
                      <div class="col-sm-6">
                        <div class="widget-box transparent">
                             <h4 class="widget-title lighter"><i class="ace-icon fa fa-star orange"></i> 실시간 판매 현황()</h4>
                            <div class="widget-body">
                                <div class="widget-main no-padding">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thin-border-bottom">
                                            <tr>                                               
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>품목</th>
                                                <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>매출금액</th>
                                                <th class="hidden-480  center"><i class="ace-icon fa fa-caret-right blue"></i>판매수량</th>                                                    
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($i=0;$i<count($to_tot);$i++){
                                            ?>
                                            <tr>
                                                <td style="text-align: left"> <?=$to_tot[$i][it_name]?> </td>
                                                <td style="text-align: right"><?= number_format($to_tot[$i][tot_price])?></td>
                                                <td  style="text-align: right"><?=$to_tot[$i][tot_qty]?></td>
                                            </tr>
                                            <?php
                                                    $tot_price = $tot_price + $to_tot[$i][tot_price];
                                                    $tot_qty = $tot_qty + $to_tot[$i][tot_qty];
                                                 }
                                            ?>                              
                                             <tr>
                                                <td  style="text-align: left"> 총 합계</td>
                                                <td style="text-align: right"><b class="green"><?=number_format($tot_price)?></b></td>
                                                <td style="text-align: right"><b class="green"><?=$tot_qty?></b></td>                                                   
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col --><!-- /.row -->
                    
                    
                    <?php
                                
                            }
                    ?>                        
                  
                    <?php
                        }
                    ?>
                        
                    
                    
                    
                    
                    
                    
                    </div><!-- /.col -->
                </div>
            <div class="space-32"></div>
            <div class="hr hr-1 hr-dotted"></div>
            <div class="space-32"></div>
            <div class="row">
                <div class="col-xs-12">                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="widget-box transparent">
                                <div class="widget-header widget-header-flat">
                                    <h4 class="widget-title lighter"><i class="ace-icon fa fa-star orange"></i>일간 판매 현황</h4>
                                    <div class="widget-toolbar"> <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a></div>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                         <table class="table table-bordered table-striped">
                                            <thead class="thin-border-bottom">
                                                <tr>                                               
                                                    <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>날짜</th>
                                                    <th class="hidden-480  center"><i class="ace-icon fa fa-caret-right blue"></i>판매수량</th>    
                                                    <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>매출금액</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                              
                                                <?php
                                                     for($i=0;$i<count($daily_list);$i++){
                                                ?>
                                                <tr>                                                 
                                                    <td style="text-align: center"> <?=$daily_list[$i][sal_date]?> </td>                                                   
                                                    <td  style="text-align: right"><?=number_format($daily_list[$i][d_tot_qty])?></td>
                                                    <td style="text-align: right"><?=number_format($daily_list[$i][d_tot_price])?></td>
                                                </tr>
                                                <?php                                                       
                                                     }
                                                ?>  
                                              
                                            </tbody>
                                        </table>
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div><!-- /.col -->
                         <div class="col-sm-6">
                            <div class="widget-box transparent">
                                <div class="widget-header widget-header-flat">
                                    <h4 class="widget-title lighter"><i class="ace-icon fa fa-star orange"></i>월간 판매 현황</h4>
                                    <div class="widget-toolbar"> <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a></div>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                         <table class="table table-bordered table-striped">
                                            <thead class="thin-border-bottom">
                                                <tr>                                               
                                                    <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>연월</th>                                                   
                                                    <th class="hidden-480  center"><i class="ace-icon fa fa-caret-right blue"></i>판매수량</th>     
                                                     <th class="center"><i class="ace-icon fa fa-caret-right blue center"></i>매출금액</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                             
                                                <?php
                                                     for($i=0;$i<count($month_list);$i++){
                                                ?>
                                                <tr>                                                 
                                                    <td style="text-align: center"> <?=$month_list[$i][sal_date]?> </td>                                                    
                                                    <td  style="text-align: right"><?=number_format($month_list[$i][d_tot_qty])?></td>
                                                    <td style="text-align: right"><?=number_format($month_list[$i][d_tot_price])?></td>
                                                </tr>
                                                <?php                                                       
                                                     }
                                                ?>                              
                                            
                                            </tbody>
                                        </table>
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div>
                    </div>	
                </div>
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<?php
    require_once '../inc/inc_sales_footer.php';
?> 

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"><i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i></a>
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

		<!--[if lte IE 8]>
		  <script src="../assets/js/excanvas.js"></script>
		<![endif]-->
		<script src="../assets/js/jquery-ui.custom.js"></script>
		<script src="../assets/js/jquery.ui.touch-punch.js"></script>
		<script src="../assets/js/jquery.easypiechart.js"></script>
		<script src="../assets/js/jquery.sparkline.js"></script>
		<script src="../assets/js/flot/jquery.flot.js"></script>
		<script src="../assets/js/flot/jquery.flot.pie.js"></script>
		<script src="../assets/js/flot/jquery.flot.resize.js"></script>

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
		<script type="text/javascript">
			jQuery(function($) {
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
						size: size
					});
				})
			
				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html',
									 {
										tagValuesAttribute:'data-values',
										type: 'bar',
										barColor: barColor ,
										chartRangeMin:$(this).data('min') || 0
									 });
				});
			
			
			  //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
			  //but sometimes it brings up errors with normal resize event handlers
			  $.resize.throttleWindow = false;
			
			  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
			  var data = [
				{ label: "social networks",  data: 38.7, color: "#68BC31"},
				{ label: "search engines",  data: 24.5, color: "#2091CF"},
				{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
				{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
				{ label: "other",  data: 10, color: "#FEE074"}
			  ]
			  function drawPieChart(placeholder, data, position) {
			 	  $.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt:0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne", 
						labelBoxBorderColor: null,
						margin:[-30,15]
					}
					,
					grid: {
						hoverable: true,
						clickable: true
					}
				 })
			 }
			 drawPieChart(placeholder, data);
			
			 /**
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 */
			 placeholder.data('chart', data);
			 placeholder.data('draw', drawPieChart);
			
			
			  //pie chart tooltip example
			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;
			
			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}
				
			 });
			
				/////////////////////////////////////
				$(document).one('ajaxloadstart.page', function(e) {
					$tooltip.remove();
				});
			
			
			
			
				var d1 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d1.push([i, Math.sin(i)]);
				}
			
				var d2 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d2.push([i, Math.cos(i)]);
				}
			
				var d3 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.2) {
					d3.push([i, Math.tan(i)]);
				}
				
			
				var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
				$.plot("#sales-charts", [
					{ label: "Domains", data: d1 },
					{ label: "Hosting", data: d2 },
					{ label: "Services", data: d3 }
				], {
					hoverable: true,
					shadowSize: 0,
					series: {
						lines: { show: true },
						points: { show: true }
					},
					xaxis: {
						tickLength: 0
					},
					yaxis: {
						ticks: 10,
						min: -2,
						max: 2,
						tickDecimals: 3
					},
					grid: {
						backgroundColor: { colors: [ "#fff", "#fff" ] },
						borderWidth: 1,
						borderColor:'#555'
					}
				});
			
			
				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			
				$('.dialogs,.comments').ace_scroll({
					size: 300
			    });
				
				
				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				});
			
				$('#tasks').sortable({
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'draggable-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer',
					stop: function( event, ui ) {
						//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
						$(ui.item).css('z-index', 'auto');
					}
					}
				);
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
			
			
				//show the dropdowns on top or bottom depending on window height and menu position
				$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
					var offset = $(this).offset();
			
					var $w = $(window)
					if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
						$(this).addClass('dropup');
					else $(this).removeClass('dropup');
				});
			
			})
		</script>

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
