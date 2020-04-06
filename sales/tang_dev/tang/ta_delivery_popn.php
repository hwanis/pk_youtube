<?php
    session_start();
    require_once '../autoload.php'; 
    
    $emp_id = $_SESSION['emp_id'];
    $emp_name = $_SESSION['emp_name'];
    //request 블록 번호
    if(empty($_REQUEST[hsid])){
       // 잘못된 접근
    }
    
    $obj = new class_shipTa();   
    $crud = new class_curd();
    // tang list  
    $view = $obj->getTangView($_REQUEST[hsid], $_REQUEST[dr_id]);     
    $view_file = $crud->curdList($table = 'attatch_file', $where = ' od_number ='.$view[od_number]);
    // 지정일 list    
    //$res = $obj->getReserveList($_REQUEST[hsid], $_REQUEST[dr_id]);    
    
    //상품 발송일 가져오기
    $prepare_date = $crud->curdRecord($table = 'sch_delivery', $where = "d_packing = '$view[jakupdate]'");
    
    //택배
    switch($view[ta_delivery]){
        case 0: $chk_no = "checked"; $chk_cj = ""; $chk_woo = "";break;
        case 11: $chk_no = ""; $chk_cj = "checked"; $chk_woo = ""; break;
        case 12: $chk_woo = "checked"; $chk_cj = ""; break;
     //   case 13: $chk_ems = "checked"; $chk_cj = ""; break;
    }
    
    //발송일 가져오기
    
    if($_REQUEST[tag]){
        $tag = $_REQUEST[tag];
    }else{
        $tag = '';
    }
    
    //qrp 처리
    //echo $qrp_s = explode('\r\n', $view[qrp_c]) ;
    $qrp_s = preg_replace('/\r\n|\r|\n/', ';', $view[qrp_c]);
    $qrp_arr = explode(';', $qrp_s);
    $pres_array = Array();
   //echo count($qrp_arr);
    
    for($i=0;$i<count($qrp_arr);$i++){        
        $qrp_arr_str = explode('|', $qrp_arr[$i]);   
      //  if($qrp_arr_str[1] != ''){
        $pres_array[$qrp_arr_str[0]] = $qrp_arr_str[1];
     //   }
    //    $pres_array[$qrp_arr_str[0]][0] = $qrp_arr_str[1];
     //   $pres_array[$qrp_arr_str[0]][0] = $qrp_arr_str[1];     
    }
    
    foreach($pres_array as $k=>$v){
        
        echo $k.'=>'.$v.'<br>';
        
    }
    
    $pres_dt_array = Array();
    
    foreach($pres_array as $k=>$v){
        
        if($pres_array[B_NAME.$i] != ''){
            
            echo $pres_array[B_NAME.$i].$pres_array[J_G.$i].'<br>';
            
            $pres_dt_array[$i][B_NAME.$i] = $pres_array[B_NAME.$i];
            $pres_dt_array[$i][J_G.$i]    = $pres_array[J_G.$i];
            
        }        
    }
    
    echo 'count : '.count($pres_dt_array);
    
    foreach($pres_dt_array as $k => $v){
        
        echo $k.'=>'.$v.'<br>';
        
    }

     //약재명 가져오기
    //getStuffInventory
    $obj_stuff = new class_curd();
    $stuff_list = $obj_stuff->curdList($table = 'stuff_inventory', $where = '')
    
    //$time_stamp = strtotime($view[jakupdate]);
    //$reserve_date = date("Y-m-d",strtotime("+1 days"));
    //echo strtotime("2020-04-02 13:12:12");
    
?>

 <?php
    //   $stuff_count = 0;
       for($i=1;$i<31;$i++){
           if($pres_array[B_NAME.$i]!=''){
    ?>

           <select id="st_no" size="1"  name="st_no_<?=$i?>" data-placeholder="제품을 선택해 주세요..." >
               <?php                                                 
                   for($j=0;$j<=count($stuff_list);$j++){
               ?>
                 
               <?php
                   if($pres_array[B_NAME.$i] == $stuff_list[$j][st_name]){
               ?>
                   <option value="<?=$stuff_list[$j][st_no]?>" selected><?=$stuff_list[$j][st_name]?></option>                                                           
               <?php
                   }else{
               ?>
                   <option value="<?=$stuff_list[$j][st_no]?>" ><?=$stuff_list[$j][st_name]?></option>        
               <?php                                                        
                   }
               }
               ?>
           </select>    
      <input type="hidden" name="tot_packs_<?=$i?>" style="width:100%" value="<?=$pres_array[J_G.$i]?>">

   <!--        <td style="width:25%"><input type="text" name="packs_quantity_<?=$i?>" style="width:100%" value="<?=$pres_array[O_G.$i]?>"></td> -->
 <!--      <td style="width:25%"><input type="text" name="pres_memo_<?=$i?>" style="width:100%" value="<?=$pres_array[M_G.$i]?>"></td> -->

    <?php
           $stuff_count = $stuff_count + 1;                                                                                 
       }                                                                                
    }    

   ?>
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
<body class="no-skin" onload="init('<?=$view[tname]?>');">
<!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default">
    <script type="text/javascript">
            try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container" style="padding:10px">

    </div><!-- /.navbar-container -->
</div>
      
<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>

    <div class="main-content">
        <div class="main-content-inner">                        
            <div class="page-content">
                <div class="row">
                    <div class="col-xs-6">
                        <!-- PAGE CONTENT BEGINS -->                                
                        <div class="row">
                            <div class="col-sm-12 col-sm-offset-0">
                                <!-- #section:pages/invoice -->
                                <div class="widget-box transparent">
                                    <!--
                                    <div class="widget-header widget-header-large">
                                        <h3 class="widget-title grey lighter">
                                            <i class="ace-icon fa fa-leaf green"></i>
                                            Customer Invoice
                                        </h3>

                                        <div class="widget-toolbar no-border invoice-info">
                                            <span class="invoice-info-label">Invoice:</span>
                                                    <span class="red">#121212</span>

                                                    <br />
                                                    <span class="invoice-info-label">Date:</span>
                                                    <span class="blue">04/04/2014</span>
                                                </div>

                                                <div class="widget-toolbar hidden-480">
                                                    <a href="#">
                                                            <i class="ace-icon fa fa-print"></i>
                                                    </a>
                                                </div>
                                               
                                            </div>
                                            -->
                                            <div class="widget-body">
                                                <div class="widget-main padding-1">     
                                                   
                                             
                                                  <div class="col-sm-12 col-sm-offset-0" style="padding-bottom: 10px" >기본 정보</div>
                                                    <div>     
                                                        <form name="reg_form"  action="ta_delivery_popn_pr.php"  class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                                        
                                                        <input type="hidden" name="ta_delivery" value="<?=$view[ta_delivery]?>"> 
                                                        <input type="hidden" name="od_number" value="<?=$view[od_number]?>"> 
                                                        <input type="hidden" name="hsid" value="<?=$view[hsid]?>">
                                                        <input type="hidden" name="hsid_sub" value="<?=$view[hsid_sub]?>">
                                                        <input type="hidden" name="yynumber" value="<?=$view[yynumber]?>">    
                                                        <input type="hidden" name="yyname" value="<?=$view[yyname]?>">    
                                                        <input type="hidden" name="name" value="<?=$view[name]?>">    
                                                        <input type="hidden" name="jakupdate" value="<?=$view[jakupdate]?>"> 
                                                        <input type="hidden" name="memo" value="<?=$view[memo]?>"> 
                                                        <input type="hidden" name="register" value="<?=$_SESSION[emp_id]?>"> 
                                                        <input type="hidden" name="tname" value="<?=$view[tname]?>">    
                                                        <input type="hidden" name="jumin" value="<?=$view[jumin]?>">
                                                        <input type="hidden" name="ta_status" value="<?=$view[ta_status]?>">    
                                                        <input type="hidden" name="prepare_date" value="<?=$prepare_date[d_prepare]?>">           
                                                        <input type="hidden" name="send_date" value="<?=$prepare_date[d_send]?>">  
                                                       
                                                  <!--    <input type="hidden" name="hsid" value="<?=$view[hsid]?>">    
                                                    <input type="hidden" name="yynumber" value="<?=$view[yynumber]?>">    
                                                    <input type="hidden" name="yyname" value="<?=$view[yyname]?>">    
                                                    <input type="hidden" name="name" value="<?=$view[name]?>">    
                                                   <input type="hidden" name="jakupdate" value="<?=$view[jakupdate]?>">    
                                                    
                                                    <input type="hidden" name="od_number" value="<?=$view[od_number]?>"> 
                                                      <input type="hidden" name="address" value="<?=$view[address]?>">                                                                                                   
                                                    <input type="hidden" name="tel" value="<?=$view[tel]?>">    
                                                    <input type="hidden" name="handphone" value="<?=$view[handphone]?>">    
                                                    <input type="hidden" name="oyx" value="<?=$view[oyx]?>">    
                                                    <input type="hidden" name="recvdate" value="<?=$view[recvdate]?>">    
                                                    <input type="hidden" name="senddate" value="<?=$view[senddate]?>">    
                                                    <input type="hidden" name="snumber" value="<?=$view[snumber]?>">    
                                                    <input type="hidden" name="tmemo" value="<?=$view[tmemo]?>">    
                                                    <input type="hidden" name="jsoendid" value="<?=$view[jsoendid]?>">    
                                                    <input type="hidden" name="tname" value="<?=$view[tname]?>">    
                                                    <input type="hidden" name="tpaek" value="<?=$view[tpaek]?>">    
                                                    <input type="hidden" name="tdang" value="<?=$view[tdang]?>">                                                        
                                                    <input type="hidden" name="tdate" value="<?=$view[tdate]?>">    
                                                    <input type="hidden" name="tmemo" value="<?=$view[tmemo]?>">    
                                                    <input type="hidden" name="edtime" value="<?=$view[edtime]?>">    
                                                    <input type="hidden" name="delivery_date" value="<?=$view[delivery_date]?>">    
                                                    <input type="hidden" name="ta_delivery" value="<?=$view[ta_delivery]?>">    
                                                    <input type="hidden" name="trans_yn" value="<?=$view[trans_yn]?>">    
                                                    
                                                    <input type="hidden" name="modfy_date" value="<?=$view[modfy_date]?>">    
                                                    <input type="hidden" name="mod_cnt" value="<?=$view[mod_cnt]?>">    
                                                    <input type="hidden" name="register" value="<?=$view[register]?>">    
                                                    <input type="hidden" name="delivery_num" value="<?=$view[delivery_num]?>">                                                      
                                                  -->
                                                        <table class="table table-striped table-bordered">
                                                            <tbody>
                                                                <tr>                                                                                       
                                                                    <td style="width:12%"> 일련 번호 </td>
                                                                    <td style="width:38%">
                                                                        <?=$view[hsid]?> 
                                                                    </td>
                                                                 <!--   <td style="width:10%"> 연결 번호 </td>
                                                                    <td style="width:23%"><?=$view[hsid_sub]?> </td>
                                                                 -->
                                                                    <td style="width:12%"> 주문 번호 </td>
                                                                    <td style="width:38%"><?=$view[od_number]?> </td>
                                                                </tr>
                                                                <tr>
                                                                   <!-- <td>한의원 명</td>
                                                                    <td class="hidden-xs"><?=$view[yyname]?></td> -->
                                                                    <td class="hidden-480"> 성명 </td>
                                                                    <td colspan="3"> 
                                                                        <?=$view[name]?>                                                                           
                                                                    </td>
                                                                </tr>                                                               
                                                                <tr>
                                                                    <td>연락처1</td>
                                                                    <td>
                                                                        <?php
                                                                            $split_tel = explode('-', $view[tel]);
                                                                        ?>
                                                                        <input type="text" style="width:25%" name="tel_1" value="<?=$split_tel[0]?>" maxlength="3" onKeyUp="return numkeyCheck(event);"> -
                                                                        <input type="text" style="width:30%" name="tel_2" value="<?=$split_tel[1]?>" maxlength="4" onKeyUp="return numkeyCheck(event);">-
                                                                        <input type="text"  style="width:30%" name="tel_3" value="<?=$split_tel[2]?>" maxlength="4" onKeyUp="return numkeyCheck(event);">     
                                                                    </td>
                                                                    <td>연락처2</td>
                                                                    <td>
                                                                        <?php
                                                                            $split_hp = explode('-', $view[handphone]);
                                                                        ?>
                                                                        <input type="text" style="width:25%" name="hp_1" value="<?=$split_hp[0]?>" maxlength="3" onKeyUp="return numkeyCheck(event);"> - 
                                                                        <input type="text" style="width:30%" name="hp_2" value="<?=$split_hp[1]?>" maxlength="4" onKeyUp="return numkeyCheck(event);"> - 
                                                                        <input type="text" style="width:30%" name="hp_3" value="<?=$split_hp[2]?>" maxlength="4" onKeyUp="return numkeyCheck(event);">                                                                           
                                                                    </td>
                                                                </tr>
                                                                 <tr>
                                                                     <td class="hidden-xs">     주소</td>
                                                                    <td colspan="3"><input type="text" style="width:100%" name="address" value="<?=$view[address]?>"></td>
                                                                </tr>
                                                                    
                                                                <tr>    
                                                                    <td>처방일</td>                                                                   
                                                                    <td>                                                                   
                                                                       <div class="input-group">
                                                                            <?=$view[jakupdate]?>
                                                                        </div>
                                                                    </td>
                                                                    <td>발송일</td>
                                                                    <td class="hidden-xs">  
                                                                        <div class="input-group">
                                                                        <input class="form-control date-picker" id="reserve_date_1" type="text" name="reserve_date_1" data-date-format="yyyy-mm-dd" value="<?=$prepare_date[d_send]?>" readonly />
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-calendar bigger-110"></i>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                <!--    <td class="hidden-480">  박스 </td>
                                                                    <td>
                                                                        <input type="text" name="ta_box" value="<?=$view[ta_box]?>" class="col-xs-6" maxlength="3"> 
                                                                    </td>
                                                                -->
                                                                </tr> 
                                                                 <tr>                                                                                     
                                                                   
                                                                </tr> 
                                                           
                                                               
                                                                     <tr>
                                                                    <td>
                                                                         메모
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <table style="width:100%;padding:15px" >
                                                                            <tr>
                                                                                <td style="width:100%;padding-bottom:15px">
                                                                                    <?=$view[tmemo]?> 
                                                                                </td>
                                                                            </tr>                                                                          
                                                                        </table>                                                                        
                                                                    </td>                         
                                                                </tr>
                                                                <tr>
                                                                    <td>첨부파일</td>
                                                                    <td colspan="3">
                                                                        <?php
                                                                            for($i=0;$i<count($view_file);$i++){
                                                                                
                                                                                echo $view_file[$i][file_o_name];
                                                                                
                                                                            }                                                                        
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        첨부파일
                                                                    </td>
                                                                    
                                                                    <td colspan="3">                                                                        
                                                                        <input multiple="" type="file" id="id-input-file-3" name="attach_file[]" multiple='multiple' />
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                               
                                                       
                                                   
                                                    </div>
                                                </div>
                                            </div>
                                <!-- /section:pages/invoice -->
                                </div>
                            </div>
                <!-- PAGE CONTENT ENDS -->
                        </div><!-- /.col -->
                    
                        
                         <div class="col-xs-6">
                                <!-- PAGE CONTENT BEGINS -->
                                <div class="space-2"></div>
                             
                                <div class="row">
                                    <div class="col-sm-12 col-sm-offset-0">
                                        <!-- #section:pages/invoice -->
                                       
                                            <div class="widget-body">
                                                <div class="widget-main padding-1">     
                                                    
                                                    <div class="col-sm-12 col-sm-offset-0" style="padding-bottom: 10px" >처방 정보</div>
                                                    
                                                    <div>                                                       
                                                        <table class="table table-striped table-bordered">
                                                            <tbody>
                                                                                                                             
                                                                <tr>
                                                                    <td>약처방( 처방명:  <?=$pres_array[G_KNAME]?> / 팩수: <?=$view[tpaek]?>)
                                                                        <!--<input type="Button" value="추가" onclick="addForm()">
                                                                        <input type="Button" value="삭제" onclick="delForm()">
                                                                        <input type="hidden" name="count" value="0" >    
                                                                        -->
                                                                        총첩수 <?=$pres_array[G_JUB]?> / <input type="hidden" name="take_date" value="<?=$pres_array[G_JUB]?>">       
                                                                        총량  <?=$pres_array[J_G1]?>g  / <input type="hidden" name="packs_quantity" value="<?=$pres_array[J_G1]?>">       
                                                                        첩당량 총량 <?=$pres_array[O_G1]?>g  <input type="hidden" name="tot_packs" value="<?=$pres_array[O_G1]?>">    
                                                                        <input type="hidden" name="pre_name" value="<?=$pres_array[G_KNAME]?>"> 
                                                                        <input type="hidden" class="col-xs-5" name="tpaek" value="<?=$view[tpaek]?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5">
                                                                       
                                                                        <table  class="table table-striped table-bordered" >     
                                                                          
                                                                            <!--    <td>처방 명</td> <td> <?=$pres_array[G_KNAME]?></td>-->  
                                                                                    
                                                                            <?php
                                                                             //   $stuff_count = 0;
                                                                                for($i=1;$i<31;$i++){
                                                                                    if($pres_array[B_NAME.$i]!=''){
                                                                             ?>
                                                                                                                                                        
                                                                                    <select id="st_no" size="1"  name="st_no_<?=$i?>" data-placeholder="제품을 선택해 주세요..." >
                                                                                        <?php                                                 
                                                                                            for($j=0;$j<count($stuff_list);$j++){
                                                                                        ?>
                                                                                            <option value=""> </option>
                                                                                        <?php
                                                                                            if($pres_array[B_NAME.$i] == $stuff_list[$j][st_name]){
                                                                                        ?>
                                                                                            <option value="<?=$stuff_list[$j][st_no]?>" selected><?=$stuff_list[$j][st_name]?></option>                                                           
                                                                                        <?php
                                                                                            }else{
                                                                                        ?>
                                                                                            <option value="<?=$stuff_list[$j][st_no]?>" ><?=$stuff_list[$j][st_name]?></option>        
                                                                                        <?php                                                        
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </select>    
                                                                               <input type="hidden" name="tot_packs_<?=$i?>" style="width:100%" value="<?=$pres_array[J_G.$i]?>">
                                                                               
                                                                            <!--        <td style="width:25%"><input type="text" name="packs_quantity_<?=$i?>" style="width:100%" value="<?=$pres_array[O_G.$i]?>"></td> -->
                                                                          <!--      <td style="width:25%"><input type="text" name="pres_memo_<?=$i?>" style="width:100%" value="<?=$pres_array[M_G.$i]?>"></td> -->
                                                                         
                                                                             <?php
                                                                                    $stuff_count = $stuff_count + 1;                                                                                 
                                                                                }                                                                                
                                                                             }    
                                                                                                                                                          
                                                                            ?>
                                                                            <input type="hidden" name="stuff_count" value="<?=$stuff_count?>">
                                                                            <input type="hidden" name="dc_name" value="<?=$pres_array[P_HNAME2]?>">
                                                                            <input type="hidden" name="pr_name" value="<?=$pres_array[P_HNAME4]?>">
                                                                            <input type="hidden" name="stuff_array[]" value="<?=$pres_array?>">
                                                                                
                                                                                <?php
                                                                                 
                                                                                $pre_name_arry = explode('/', preg_replace("/\s+/","",$pres_array[G_KNAME]));
                                                                                                                                                            
                                                                                for($i=1;$i<=$stuff_count;$i++){
                                                                                    
                                                                                     switch($pres_array[B_NAME.$i]){
                                                                                        case '편강탕': $pre_name_pg = $pres_array[J_G.$i];  break;
                                                                                        case '편강환': 
                                                                                            
                                                                                           $c_j_g_m = intval($pres_array[J_G.$i]/30);
                                                                                            $c_j_g_n = ($pres_array[J_G.$i]%30)/15;                                                                                 
                                                                                        break;
                                                                                        case '보중환': $pre_name_bo = $pres_array[J_G.$i]; break;
                                                                                        case '편강탕가미': $pre_name_ga = $pres_array[J_G.$i]; break;
                                                                                    }                                                                                    
                                                                                }                                                                                
                                                                                ?>
                                                                           <!--     <td colspan="4">
                                                                                    총첩수 <?=$pres_array[G_JUB]?> <input type="hidden" name="take_date" value="<?=$pres_array[G_JUB]?>">       
                                                                                    총량  <?=$pres_array[J_G1]?>g <input type="hidden" name="packs_quantity" value="<?=$pres_array[J_G1]?>">       
                                                                                    첩당량 총량 <?=$pres_array[O_G1]?>g  <input type="hidden" name="tot_packs" value="<?=$pres_array[O_G1]?>">                                                                                       
                                                                                </td>
                                                                           -->
                                                                            
                                                                           
                                                                       
                                                                        <tr>
                                                                            <td>편강탕</td><td><input type="text" name="pre_name_pg" value="<?=$pre_name_pg?>" id="spinner1" /></td>
                                                                            <td>보중환</td><td><input type="text" name="pre_name_bo" value="<?=$pre_name_bo?>" id="spinner2" /></td>
                                                                            <td>편강탕 가미</td><td><input type="text" name="pre_name_ga"  value="<?=$pre_name_ga?>" id="spinner5" /></td>
                                                                            
                                                                        </tr>
                                                                      
                                                                        <tr>
                                                                            <td>편강환(15)</td><td><input type="text" name="pre_name_h15"  value="<?=$c_j_g_n?>" id="spinner3" /></td>
                                                                            <td>편강환(30)</td><td><input type="text" name="pre_name_h30"  value="<?=$c_j_g_m?>" id="spinner4" /></td>                                                                       
                                                                            <td>첩약</td><td><input type="text" name="pre_name_ch"  value="<?=$pre_name_ch?>" id="spinner6" /></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="6">상세처방</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="6">
                                                                                <table  class="table table-striped table-bordered" >  
                                                                                    
                                                                                    
                                                                                    
                                                                                </table>
                                                        
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                        </table>                                                                          
                                                                    </td>
                                                                                                                     
                                                                </tr>
                                                                                                                  
                                                               
                                                                </tbody>
                                                            </table>
                                                        
                                                        </div>
                                               
                                                       
                                                  
                                                    </div>
                                                </div>
                                            </div>
                                <!-- /section:pages/invoice -->
                                </div>
                            </div>
                         <div>
                        <div class="col-sm-12 col-sm-offset-5">
                            <!--
                            <button class="btn btn-info" type="button" name="btnSubmit" value="u" onclick="javascript:SubmitXls(this.form)">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Submit
                            </button>    
                            -->
                            <button class="btn" type="button" onclick="javascript:window.close()">
                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                Cancel
                            </button>
                            <button class="btn btn-danger" type="button" name="btnSubmit" value="i" onclick="javascript:SubmitTrans(this.form)" >
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                <font size="2.5pt">전 &nbsp;&nbsp;송 &nbsp;&nbsp;</font>
                            </button>
                            <!--
                            <button class="btn btn-success" type="button" name="btnSubmit" onclick="">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                분할하기
                            </button>
                            -->
                        </div>
                   
                    </div>
                        
                </form>
                <!-- PAGE CONTENT ENDS -->
                        </div><!-- /.col -->
                        
                        </div><!-- /.row -->
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
                <script src="../js/pk_common.js"></script>
                <script>                 
                    function init(tname)
                    {                       
                     //  if(tname === '편강탕' ||tname === '편강환' ||tname === '보중환' )
                     //  reg_form.tname_ex.disabled = true; 
                    }
                    function radioEnable(form, tag){                       
                    //    if(tag === 4){                            
                    //        form.tname_ex.disabled = false;                            
                     //   }else{
                    //        form.tname_ex.disabled = true;                           
                     //   }                        
                    }
                    
                    function SubmitTrans(form){
                     
                      form.action = "ta_delivery_popn_pr.php?tag=i";
                      form.submit();
                        
                    }
                                   
                    function SubmitXls(form) {                    
                        
                      //form.btnSubmit.action = "ta_delivery_popn_pr.php?tag=u";
                        form.action = "ta_delivery_popn_pr.php?tag=u";
                        form.submit();

                //        var str_reserve_date_1 = fn_str_trim(form.reserve_date_1.value);
                 //       var str_reserve_date_2 = fn_str_trim(form.reserve_date_2.value);
                   //     var str_reserve_date_3 = fn_str_trim(form.reserve_date_3.value);
                        
                 //      var date = new Date();
                //        var toDate = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+(date.getDate());
                        
                //        if(str_reserve_date_1 === '' && str_reserve_date_2 === ''  && str_reserve_date_3 === '' ){                         
                //            alert('지정일을 하나는 선택하셔야 합니다.');
                //            form.reserve_date_1.focus(); 
                //            return false;                         
                //        }
                        
                 //       if(str_reserve_date_1 === ''){
                      /*      
                            if(str_reserve_date_2 != '' || str_reserve_date_3 != ''){
                                
                                alert('처음부터 선택하셔야 합니다.');
                                form.reserve_date_2.value = ''; 
                                form.reserve_date_3.value = ''; 
                                form.reserve_date_1.focus(); 
                                return false;
                                
                            }
                            
                         }else{
                            
                             //예약일은 내일 부터 선택 가능
                            if(toDate <= str_reserve_date_1 ){
                                alert('날짜를 정확하게 선택해주세요');
                                form.reserve_date_1.focus(); 
                                 return false;
                            }
                            
                            if(str_reserve_date_2 === ''){
                                
                                if(str_reserve_date_3 != ''){                                
                                    alert('차례대로 선택하셔야 합니다.');
                                    form.reserve_date_2.focus(); 
                                    return false;                                
                                }                               
                            }else{                                                                
                                
                                if(toDate <= str_reserve_date_2 ){
                                    alert('날짜를 정확하게 선택해주세요');
                                    form.reserve_date_2.focus(); 
                                     return false;
                                }
                                 if(str_reserve_date_3 != ''){                                
                                    if(toDate <= str_reserve_date_2 ){
                                        alert('날짜를 정확하게 선택해주세요');
                                        form.reserve_date_2.focus(); 
                                         return false;
                                    }
                                }
                            }
                        }   
                        
                        */
                     //   form.submit();                        
                    }
                /*
             
                    var count = 0;
                    var count_f = 0;
                                        
                    function addForm(){

                        var addedFormDiv = document.getElementById("addedFormDiv");
                        var str = "";
                        str+= "<div class='input-group'>";                    
                    
                        
                        str+= "<table  class='table table-striped table-bordered'> "; 
                        str+= "<tr> <td class='hidden-xs' colspan='41>  주소 <input type='text'  style='width:93%' name='address_"+count+"' value='<?=$view[address]?>'></td></tr>" ; 
                        str+= "<tr><td>편강탕</td><td><input type='text' name = 'pyeon_"+count+"' id='spinner1' /></td><td>보중환</td><td><input type='text' id='spinner2' name = 'bo_"+count+"' /></td></tr> "; 
                        str+= "<tr><td>편강환(15)</td><td><input type='text' name = 'hwanh_"+count+"' id='spinner3' /></td><td>편강환(30)</td><td><input type='text' id='spinner4' name='hwanf_"+count+"' /></td></tr> "; 
                        str+= "<tr><td>편강탕 가미</td><td><input type='text' name = 'gami_"+count+"' id='spinner5' /></td><td>상세처방</td><td></td></tr> " ; 
                        str+= "<tr><td>첩약</td><td><input type='text' id='spinner6' name = 'chup_"+count+"' /></td><td>상세처방</td><td></td></tr> " ; 
                        str+= "</table> "; 
                        
                          // 추가할 폼(에 들어갈 HTML)
                        var addedDiv = document.createElement("div"); // 폼 생성
                        addedDiv.id = "added_"+count; // 폼 Div에 ID 부여 (삭제를 위해)
                        addedDiv.innerHTML  = str; // 폼 Div안에 HTML삽입
                        addedFormDiv.appendChild(addedDiv); // 삽입할 DIV에 생성한 폼 삽입
                    
                        count++;                    
                        document.reg_form.count.value=count;
                        // 다음 페이지에 몇개의 폼을 넘기는지 전달하기 위해 히든 폼에 카운트 저장
                }

                function delForm(){

                    var addedFormDiv = document.getElementById("addedFormDiv");
                    if(count >1){ // 현재 폼이 두개 이상이면

                        var addedDiv = document.getElementById("added_"+(--count));
                        // 마지막으로 생성된 폼의 ID를 통해 Div객체를 가져옴
                        addedFormDiv.removeChild(addedDiv); // 폼 삭제 
                     
                        document.reg_form.count.value=count;

                    }else{ // 마지막 폼만 남아있다면
                       var addedDiv = document.getElementById("added_"+(--count));
                       // document.reg_form.reset(); // 폼 내용 삭제
                        addedFormDiv.removeChild(addedDiv); // 폼 삭제 
                        document.reg_form.count.value = 0;
                    }

                }
                
             
                function addFile(){
                        //<input type="file" id="id-input-file-2" />
                        var addedFormDiv = document.getElementById("addedFileDiv");
                        var str = "";

                        str+= "<hr>"; 
                        str+= "<label class='col-sm-2 control-label no-padding-left' for='form-field-1'> 이미지 업로드 </label>";
                        str+= "<br> <input type='file' name='img_"+count_f+"' class='col-xs-10 col-sm-6' style='scrollbar-highlight-color:#3b3b3b;scrollbar-shadow-color:#3b3b3b;scrollbar-arrow-color:#EEEEEE;scrollbar-face-color:black;scrollbar-3dlight-color:black;scrollbar-darkshadow-color:black;scrollbar-track-color:#3B3B3B;' ><br><br>";
                        str+= "<label class='col-sm-2 control-label no-padding-left' for='form-field-1'> 이미지 Title</label>";
                        str+="<input type='text' name='img_title_"+count_f+"' id= 'form-field-1'  class='col-xs-10 col-sm-4' ><br><br>";
                        str+= "<hr>";                  
                          // 추가할 폼(에 들어갈 HTML)
                        var addedDiv = document.createElement("div"); // 폼 생성
                        addedDiv.id = "added_"+count_f; // 폼 Div에 ID 부여 (삭제를 위해)
                        addedDiv.innerHTML  = str; // 폼 Div안에 HTML삽입
                        addedFormDiv.appendChild(addedDiv); // 삽입할 DIV에 생성한 폼 삽입
                        
                        count_f++;

                        document.reg_form.count_f.value=count_f;
                        // 다음 페이지에 몇개의 폼을 넘기는지 전달하기 위해 히든 폼에 카운트 저장
                }

                function delFile(){

                    var addedFormDiv = document.getElementById("addedFileDiv");
                    if(count_f >1){ // 현재 폼이 두개 이상이면

                        var addedDiv = document.getElementById("added_"+(--count_f));
                        // 마지막으로 생성된 폼의 ID를 통해 Div객체를 가져옴
                        addedFormDiv.removeChild(addedDiv); // 폼 삭제 
                        document.reg_form.count_f.value=count_f;

                    }else{ // 마지막 폼만 남아있다면
                         var addedDiv = document.getElementById("added_"+(--count_f));
                        // 마지막으로 생성된 폼의 ID를 통해 Div객체를 가져옴
                        addedFormDiv.removeChild(addedDiv); // 폼 삭제 
                         document.reg_form.count_f.value = 0;
                    }

                }
 
              */
               </script>
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
		<script src="../assets/js/chosen.jquery.js"></script>
		<script src="../assets/js/fuelux/fuelux.spinner.js"></script>
		<script src="../assets/js/date-time/bootstrap-datepicker.js"></script>
		
		<script src="../assets/js/date-time/moment.js"></script>
		
		
		<script src="../assets/js/bootstrap-colorpicker.js"></script>
		<script src="../assets/js/jquery.knob.js"></script>
		<script src="../assets/js/jquery.autosize.js"></script>
		<script src="../assets/js/jquery.inputlimiter.1.3.1.js"></script>
		<script src="../assets/js/jquery.maskedinput.js"></script>
		<script src="../assets/js/bootstrap-tag.js"></script>

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
                    
                    $('#id-input-file-3').ace_file_input({
                            style:'well',
                            btn_choose:'Drop files here or click to choose',
                            btn_change:null,
                            no_icon:'ace-icon fa fa-cloud-upload',
                            droppable:true,
                            thumbnail:'small'//large | fit
                            //,icon_remove:null//set null, to hide remove/reset button
                            /**,before_change:function(files, dropped) {
                                    //Check an example below
                                    //or examples/file-upload.html
                                    return true;
                            }*/
                            /**,before_remove : function() {
                                    return true;
                            }*/
                            ,
                            preview_error : function(filename, error_code) {
                                    //name of the file that failed
                                    //error_code values
                                    //1 = 'FILE_LOAD_FAILED',
                                    //2 = 'IMAGE_LOAD_FAILED',
                                    //3 = 'THUMBNAIL_FAILED'
                                    //alert(error_code);
                            }

                        }).on('change', function(){
                                //console.log($(this).data('ace_input_files'));
                                //console.log($(this).data('ace_input_method'));
                        });
                    
                    $('#id-disable-check').on('click', function() {
                            var inp = $('#form-input-readonly').get(0);
                            if(inp.hasAttribute('disabled')) {
                                    inp.setAttribute('readonly' , 'true');
                                    inp.removeAttribute('disabled');
                                    inp.value="This text field is readonly!";
                            }
                            else {
                                    inp.setAttribute('disabled' , 'disabled');
                                    inp.removeAttribute('readonly');
                                    inp.value="This text field is disabled!";
                            }
                    });

                    if(!ace.vars['touch']) {
                            $('.chosen-select').chosen({allow_single_deselect:true}); 
                            //resize the chosen on window resize

                            $(window)
                            .off('resize.chosen')
                            .on('resize.chosen', function() {
                                    $('.chosen-select').each(function() {
                                             var $this = $(this);
                                             $this.next().css({'width': $this.parent().width()});
                                    })
                            }).trigger('resize.chosen');
                            //resize chosen on sidebar collapse/expand
                            $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
                                    if(event_name != 'sidebar_collapsed') return;
                                    $('.chosen-select').each(function() {
                                             var $this = $(this);
                                             $this.next().css({'width': $this.parent().width()});
                                    })
                            });


                            $('#chosen-multiple-style .btn').on('click', function(e){
                                    var target = $(this).find('input[type=radio]');
                                    var which = parseInt(target.val());
                                    if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
                                     else $('#form-field-select-4').removeClass('tag-input-style');
                            });
                    }

                    $('[data-rel=tooltip]').tooltip({container:'body'});
                    $('[data-rel=popover]').popover({container:'body'});

                    $.mask.definitions['~']='[+-]';
                    $('.input-mask-date').mask('99/99/9999');
                    $('.input-mask-phone').mask('(999) 999-9999');
                    $('.input-mask-postno').mask('(99999)');
                    $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
                    $(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});//postno

                    //spinner
                    $('#spinner1').ace_spinner({value:0,min:0,max:999,step:5, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
                    $('#spinner2').ace_spinner({value:0,min:0,max:100,step:1, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
                    $('#spinner3').ace_spinner({value:0,min:0,max:100,step:1, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
                    $('#spinner4').ace_spinner({value:0,min:0,max:100,step:1, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
                    $('#spinner5').ace_spinner({value:0,min:0,max:999,step:5, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
                    $('#spinner6').ace_spinner({value:0,min:0,max:999,step:5, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
                    //datepicker plugin
                    //link
                    $('.date-picker').datepicker({
                            autoclose: true,
                            todayHighlight: true
                    })
                    //show datepicker when clicking on the icon
                    .next().on(ace.click_event, function(){
                            $(this).prev().focus();
                    });

                    $(".knob").knob();

                    /////////
                    
                   $('#reserve_date_1').datetimepicker().next().on(ace.click_event, function(){
                            $(this).prev().focus();
                    });
                    
                    $('#reserve_date_2').datetimepicker().next().on(ace.click_event, function(){
                            $(this).prev().focus();
                    });
                 
                   
                    $(document).one('ajaxloadstart.page', function(e) {
                            $('textarea[class*=autosize]').trigger('autosize.destroy');
                            $('.limiterBox,.autosizejs').remove();
                            $('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
                    });

                });
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
