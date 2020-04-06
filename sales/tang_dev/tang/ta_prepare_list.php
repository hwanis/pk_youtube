<?php

    require_once '../inc/inc_ship_header.php';    
    
  //  echo 'st date :'.$_REQUEST[st_date].'<br>';
 //   echo 'tag :'.$_REQUEST[tag].'<br>';
 //   echo 'hsid :'.$_REQUEST[hsid].'<br>';
    //echo 'check box :'.$_REQUEST[chk_branch].'<br>';
    if(Empty($_REQUEST[st_date])){
        $st_date = date("Y-m-d");
    }else{
        $st_date = $_REQUEST[st_date];
    }
  
    //지점 request 처리해야 함
    //$branch = $_SESSION[branch];
    $branch = '11936860';
    $obj = new class_shipTa();
    $obj_ts = new class_TangSend();
     
    if($_REQUEST[tag] == 'del'){    
        $get_post = Array();    
        $get_post[ta_status] = 901;
        
        $del = $obj->delTangList($get_post, $_REQUEST[od_number]);       
    }
  
    //탕 전송 데이터 리스트       
    //$list = $obj->getDeliverySendList();    
    $list = $obj_ts->getPrePareList();
 
    //택배사별 개수
    $none_cnt = $obj->getSendDeliveryCount($st_date, 0, $branch, $ta_status = $_REQUEST[ta_status]);    
    $cj_cnt = $obj->getSendDeliveryCount($st_date, 11, $branch, $ta_status = $_REQUEST[ta_status]);
    $woo_cnt = $obj->getSendDeliveryCount($st_date, 12, $branch, $ta_status = $_REQUEST[ta_status]);
    $ems_cnt = $obj->getSendDeliveryCount($st_date, 13, $branch, $ta_status = $_REQUEST[ta_status]);
     
 //   echo '<br>start date :'.$st_date.'<br>';
 //   echo 'none:'.$none_cnt[list_count].'<br>';
 //   echo 'cj:'.$cj_cnt[list_count].'<br>';
 //   echo 'woo:'.$woo_cnt[list_count].'<br>';
 
?>
    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
    <!-- 택배 상태 변화 aja -->
    <script>
       
    function openChild(url, field) {
            
        var popupX = (window.screen.width / 2) - (600 / 2);
        var popupY= (window.screen.height /2) - (600 / 2);
        window.open(url, 'pop', 'status=no, scroll=yes height=750, width=1400, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);

    }
    
    function openHiddenChild(url, od_number) {
        
        alert(od_number);
              
        var result = confirm("삭제 하시겠습니까?");
        if(result){
            alert("삭제 되었습니다.");
        }else{
            alert("취소 되었습니다.");
            return false;
        }
        window.location.href='ta_reserve_list.php?st_date=&tag=del&od_number='+od_number;
    }    
    
    function fncUpdateDelivery(delivery, st_date, branch){
        
        //alert(delivery);
        //alert(st_date);
       // alert(branch);
      
        var deli_very = delivery;
        var today = st_date;
        
        var popupX = (window.screen.width / 2) - (450 / 2);
        var popupY= (window.screen.height /2) - (450 / 2);
              
        url = "ta_pop_update_delivery.php?delivery="+deli_very+"&st_date="+today+"&branch="+branch;        
        window.open(url, 'pop', 'status=no, scroll=yes height=250, width=450, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);        
        
    }    
   
    </script>
</div>

<!-- /section:basics/sidebar -->
<div class="main-content">
    <div class="main-content-inner">
        <!-- #section:basics/content.breadcrumbs -->
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>        
            
            <link rel="stylesheet" href="../assets/css/jquery-ui.custom.css" />
            <link rel="stylesheet" href="../assets/css/chosen.css" />	
            <link rel="stylesheet" href="../assets/css/jquery-ui.css" />                
            <!-- ace styles -->
            <link rel="stylesheet" href="../assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
                              
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#">Home</a>
                </li>
                <li>
                    <a href="#">Tables</a>
                </li>
                <li class="active">Simple &amp; Dynamic</li>
            </ul><!-- /.breadcrumb -->           
        </div>
        <!-- /section:basics/content.breadcrumbs -->                        
            <div class="page-content">
                <div id="delivery"></div>
                <!--
                <div class="page-header">
                    <h1>
                        Tables
                        <small>
                                <i class="ace-icon fa fa-angle-double-right"></i>
                                Static &amp; Dynamic Tables
                        </small>
                    </h1>
                </div>
        -->
               <div class="row">
                 <div class="col-xs-12">
                     <div >
                         <form name="reg_form"  action="ta_delivery_send_list.php"  class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                             <div>      
                             <table>
                                 <tr>
                                     <td>                                                  
                                         <button class="btn btn-message" type="button" name="btnSubmit" onclick="javascript:Submit(this.form)" style="margin: 5px">                                                 
                                            <i class="ace-icon fa fa-check smaller-60"></i>Submit
                                         </button> 
                                     </td>
                                     <td>                                                  
                                         <div class="input-group">                                                                                          
                                             <input type="text" id="st_date" name="st_date" value="<?=$st_date?>" class="form-control" readonly/>
                                             <span class="input-group-addon"><i class="ace-icon fa fa-calendar"></i></span>
                                         </div>                                                     
                                     </td>
                                     <td> ~ </td>
                                     <td>                                                  
                                         <div class="input-group">                                                                                          
                                             <input type="text" id="ed_date" name="ed_date" value="<?=$ed_date?>" class="form-control" readonly/>
                                             <span class="input-group-addon">
                                                 <i class="ace-icon fa fa-calendar"></i>
                                             </span>
                                         </div>                                            
                                    </td>                                       
                                </tr>
                           
                            </table>
                            </div>                                 
                         </form>
                     </div>                     
                 </div>
             </div>   
            <div class="row">
                <div class="col-xs-12">
                    <div>                            
                        <form name="reg_form"  action="ta_delivery_send_list.php"  class="form-horizontal" role="form" method="post" enctype="multipart/form-data">                             
                        <div>                                                              
                            <table>
                                <tr>
                                    <td>                                            
                                        <button class="btn btn-white btn-info btn-bold" id="btnUptWoo" type="button" onclick="javascript:fncUpdateDelivery('woo', '<?=$st_date?>', '<?=$branch?>');" >
                                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>                                     
                                            우체국 일괄적용
                                        </button>
                                        <button class="btn btn-white btn-info btn-bold" id="btnUptWoo" type="button" onclick="javascript:fncUpdateDelivery('ems', '<?=$st_date?>', '<?=$branch?>');" >
                                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>                                     
                                            우체국 EMS 일괄적용
                                        </button>
                                        <button class="btn btn-white btn-info btn-bold" id="btnUptWoo" type="button"  onclick="javascript:fncUpdateDelivery('cj', '<?=$st_date?>', '<?=$branch?>');" >
                                         <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>                                     
                                         CJ 일괄적용
                                       </button>        

                                        <a href="#" onclick="javascript:openChild('ta_pop_xls_down.php?branch=<?=$branch?>', this);" id="open_pop" class="btn btn-info btn-sm">엑셀 다운로드</a>
                                        <!-- 총 <?=count($list)?>개의 데이터 중  <div id="ta_list_count"></div>개 데이터에 택배사 선택이 되지 않았습니다. -->
                                    </td>
                                    <td>
                                        <!--

                                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=1001&delivery=12&st_date=<?=$st_date?>">[서초점] 우체국 다운로드</a>
                                           &nbsp;&nbsp;
                                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=1001&delivery=11&st_date=<?=$st_date?>">[서초점] CJ 다운로드</a>
                                     
                                           <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=1003&delivery=12&st_date=<?=$st_date?>">[안산점] 우체국 다운로드</a>
                                           &nbsp;&nbsp;
                                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=1003&delivery=11&st_date=<?=$st_date?>">[안산점] CJ 다운로드</a>

                                           <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=1004&delivery=12&st_date=<?=$st_date?>">[산본점] 우체국 다운로드</a>
                                           &nbsp;&nbsp;
                                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=1004&delivery=11&st_date=<?=$st_date?>">[산본점] CJ 다운로드</a>

                                           <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=1002&delivery=12&st_date=<?=$st_date?>">[명동점] 우체국 다운로드</a>
                                           &nbsp;&nbsp;
                                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=1002&delivery=11&st_date=<?=$st_date?>">[명동점] CJ 다운로드</a>

                                           <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=1005&delivery=12&st_date=<?=$st_date?>">[대구점] 우체국 다운로드</a>
                                           &nbsp;&nbsp;
                                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=1005&delivery=11&st_date=<?=$st_date?>">[대구점] CJ 다운로드</a>

                                           <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=1006&delivery=12&st_date=<?=$st_date?>">[부산점] 우체국 다운로드</a>
                                           &nbsp;&nbsp;
                                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=1006&delivery=11&st_date=<?=$st_date?>">[부산점] CJ 다운로드</a>

                                              <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=2001&delivery=12&st_date=<?=$st_date?>">[전지점] 우체국 다운로드</a>
                                           &nbsp;&nbsp;
                                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=2002&delivery=11&st_date=<?=$st_date?>">[전지점] CJ 다운로드</a>

                                            &nbsp;&nbsp;
                                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                           <a href="ta_delivery_excdw.php?branch=3001&delivery=20&st_date=<?=$st_date?>">[전지점]  다운로드</a>
                                           -->
                                    </td>
                                </tr>                                                
                            </table>                                                                                                   
                        </div>
                        </form>
                    </div>
                </div>
            </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">										
                                <div class="clearfix">
                                        <!-- <div class="pull-right tableTools-container"></div> -->
                                </div>
                                <div>
                                    <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                            <th class="center"></th>                                            
                                            <!-- <th>수정날자</th> -->
                                            <th>주문번호</th> 
                                            <th>성명</th><th>택배</th><th>진료날자</th><th>발송일자</th>
                                            <th>메모</th><th>연락처1</th><th>연락처2</th> <th>우편번호</th><th>주소</th>                                            
                                            <th>약처방</th><th>팩수</th><th>지점</th>
                                            
                                            </tr>                                                                                    
                                        </thead>

                                        <tbody>
                                        <?php
                                            for($i=0;$i<count($list);$i++){
                                                
                                                if($list[$i][tdate] != ''){
                                        ?>     
                                             <tr style="background-color: #C9E2EA">
                                            <?php
                                                }else{
                                            ?>
                                             <tr>
                                                <?php } ?>
                                           
                                                <td class="center">
                                                    <button class="btn btn-white btn-info btn-bold"  onclick="openChild('ta_delivery_send_popn.php?od_number=<?=$list[$i][od_number]?>', this);" >Edit</button>   
                                                    <button class="btn btn-white btn-info btn-bold"  onclick="openHiddenChild('ta_prepare_list.php', <?=$list[$i][od_number]?>)" >Del</button>
                                                   
                                                    <!-- <a href="ta_xls_upload_view.php?ta_id=<?=$list[$i][ta_id]?>">수정</a> -->                                           
                                                </td>         
                                                 <td><?=$list[$i][od_number]?></td>
                                                <td><?=$list[$i][cs_name]?></td>                                                  
                                                <td>                                           
                                                     <?php 
                                                    switch($list[$i][ta_delivery]){         
                                                        case 0: $no_selected = "selected";$cj_selected = ""; $woo_selected = ""; break;
                                                        case 11: $no_selected = "";$cj_selected = "selected"; $woo_selected = ""; break;
                                                        case 12: $no_selected = "";$cj_selected = ""; $woo_selected = "selected"; break;                                                
                                                        case 13: $no_selected = "";$ems_selected = ""; $ems_selected = "selected"; break;    
                                                        default: echo $list[$i][ta_delivery]; break;
                                                    }       

                                                    //ajax로 각 행마다 선택하면 저장하게 하는게 나은지
                                                    // 날짜와 택배 열에 변경 버튼을 넣고 혹은 선택하게 하면 팝업을 띄우고
                                                    // 값을 선택하면 부모창에 값이 대입되게 하고 나중에 일괄적으로 저장 하게 할것인가???      
                                                   
                                                ?>
                                                    <select name="delivery_<?=$i?>" style="width:100px;" onchange="delivery('<?=$st_date?>', this.value, <?=$list[$i][hsid]?>, '<?=$branch?>');"> 
                                                    <!--<select name="delivery_<?=$i?>" style="width:100px;" onchange="delivery('<?=$st_date?>', this.value, <?=$list[$i][hsid]?>, <?=$branch?>)"> -->
                                                        <!--<option value="0" <?=$no_selected?> >미선택</option>-->
                                                        <option value="11" <?=$cj_selected?> >CJ</option>
                                                        <option value="12" <?=$woo_selected?> >우체국</option>
                                                        <option value="13" <?=$ems_selected?> >우체국 EMS</option>
                                                    </select>
                                                </td>
                                                 <td><?=$list[$i][treat_date]?></td>
                                                <td><?=$list[$i][delivery_date]?></td>
                                                <td>                                               
                                                <?php
                                                    if(strlen($list[$i][tmemo])>60){
                                                        echo mb_substr($list[$i][tmemo],0,30,'UTF-8').'...';
                                                    }else{
                                                        echo $list[$i][tmemo];
                                                    }
                                                ?>                                                 
                                                </td>                                              
                                                <td><?=$list[$i][c_phone]?></td>
                                                <td><?=$list[$i][h_phone]?></td>
                                                <td><?=substr($list[$i][address],1,5)?></td>
                                                <td>
                                                <?php
                                                    if(strlen($list[$i][address])>60){
                                                        echo mb_substr($list[$i][address],0,30,'UTF-8').'...';
                                                    }else{
                                                        echo $list[$i][address];
                                                    }                                                    
                                                ?>
                                                </td>                                                
                                                <td><?=$list[$i][tname]?></td>
                                                <td><?=$list[$i][tpaek]?></td>                                              
                                              <!--  <td class="hidden-480"><?=$list[$i][reserve_date]?></td>    -->
                                                <td><?=$list[$i][br_code]?></td>                                                
                                            </tr>
                                            <?php } ?>	                       
                                        </tbody>
                                    </table>
                                    
                                     <!-- modal -->   
                                      <div class="col-sm-6">                                          
                                            <div id="dialog-confirm" class="hide">
                                                <div class="alert alert-info bigger-110">
                                                     <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                                       <a href="ta_delivery_excdw.php?branch=<?=$branch?>&delivery=12&st_date=<?=$st_date?>">[<?=$branch?>] 우체국 다운로드</a>
                                                </div>  
                                                <div class="alert alert-info bigger-110">
                                                      <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                                       <a href="ta_delivery_excdw.php?branch=<?=$branch?>&delivery=13&st_date=<?=$st_date?>">[<?=$branch?>] 우체국 EMS 다운로드</a>
                                                </div>
                                                <div class="alert alert-info bigger-110">
                                                      <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                                       <a href="ta_delivery_excdw.php?branch=<?=$branch?>&delivery=11&st_date=<?=$st_date?>">[<?=$branch?>] CJ 다운로드</a>
                                                </div>
                                            </div><!-- #dialog-confirm -->
                                    </div><!-- ./span -->    
                                    
                                    
                                    <!-- modal -->
                                    <!-- PAGE CONTENT ENDS -->                                    
                                </div>
                            </div>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->            
        </div>
    </div><!-- /.main-content -->
    
    <?php
       require_once '../inc/inc_ship_footer.php';
   ?>

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>
</div><!-- /.main-container -->

    <!-- basic scripts -->
    <script src="../js/pk_common.js"></script>
    <script>               
    // portfolio check
    function SubmitXls(form, list_count) {

         var str_st_date = fn_str_trim(form.st_date.value);
        
         if(str_st_date.length < 2){             
             alert("검색일을 선택 해주세요");
             form.st_date.focus();
             return;
         }
     
         form.submit();              
    }

   </script>

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
        <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="../assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
        <script src="../assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
        <script src="../assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
      
        <script src="../assets/js/jquery-ui.custom.js"></script>
        <script src="../assets/js/jquery.ui.touch-punch.js"></script>
        <script src="../assets/js/chosen.jquery.js"></script>
        <script src="../assets/js/fuelux/fuelux.spinner.js"></script>
        <script src="../assets/js/date-time/moment.js"></script>
        <script src="../assets/js/jquery.knob.js"></script>      
        <script src="../assets/js/jquery.maskedinput.js"></script>
        <script src="../assets/js/bootstrap-tag.js"></script>
        
        <script src="../assets/js/jquery-ui.js"></script>
        <script src="../assets/js/jquery.ui.touch-punch.js"></script>

        <!-- ace scripts -->
        <script src="../assets/js/ace/elements.scroller.js"></script>    
        <script src="../assets/js/ace/elements.typeahead.js"></script>       
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

                        //initiate dataTables plugin
                        var oTable1 = 
                        $('#dynamic-table')
                        //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
                        .dataTable( {
                                bAutoWidth: true,
                                "aoColumns": [
                              
                                  null, null,null, null, null,null,
                                 null, null,null, null, null,null, null, null,
                                ],
                                "aaSorting": [],

                                //,
                                //"sScrollY": "200px",
                                //"bPaginate": false,

                                "sScrollX": "100%",
                                "sScrollXInner": "140%",
                                "bScrollCollapse": true,
                                //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
                                //you may want to wrap the table inside a "div.dataTables_borderWrap" element

                                //"iDisplayLength": 50
                    } );
                        //oTable1.fnAdjustColumnSizing();

                        //TableTools settings
                        TableTools.classes.container = "btn-group btn-overlap";
                        TableTools.classes.print = {
                                "body": "DTTT_Print",
                                "info": "tableTools-alert gritter-item-wrapper gritter-info gritter-center white",
                                "message": "tableTools-print-navbar"
                        }

                        //initiate TableTools extension
                        var tableTools_obj = new $.fn.dataTable.TableTools( oTable1, {
                                "sSwfPath": "../assets/js/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf", //in Ace demo ../assets will be replaced by correct assets path

                                "sRowSelector": "td:not(:last-child)",
                                "sRowSelect": "multi",
                                "fnRowSelected": function(row) {
                                        //check checkbox when row is selected
                                        try { $(row).find('input[type=checkbox]').get(0).checked = true }
                                        catch(e) {}
                                },
                                "fnRowDeselected": function(row) {
                                        //uncheck checkbox
                                        try { $(row).find('input[type=checkbox]').get(0).checked = false }
                                        catch(e) {}
                                },

                                "sSelectedClass": "success",
                        "aButtons": [
                                        {
                                                "sExtends": "copy",
                                                "sToolTip": "Copy to clipboard",
                                                "sButtonClass": "btn btn-white btn-primary btn-bold",
                                                "sButtonText": "<i class='fa fa-copy bigger-110 pink'></i>",
                                                "fnComplete": function() {
                                                        this.fnInfo( '<h3 class="no-margin-top smaller">Table copied</h3>\
                                                                <p>Copied '+(oTable1.fnSettings().fnRecordsTotal())+' row(s) to the clipboard.</p>',
                                                                1500
                                                        );
                                                }
                                        },

                                        {
                                                "sExtends": "csv",
                                                "sToolTip": "Export to CSV",
                                                "sButtonClass": "btn btn-white btn-primary  btn-bold",
                                                "sButtonText": "<i class='fa fa-file-excel-o bigger-110 green'></i>"
                                        },

                                        {
                                                "sExtends": "pdf",
                                                "sToolTip": "Export to PDF",
                                                "sButtonClass": "btn btn-white btn-primary  btn-bold",
                                                "sButtonText": "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
                                        },

                                        {
                                                "sExtends": "print",
                                                "sToolTip": "Print view",
                                                "sButtonClass": "btn btn-white btn-primary  btn-bold",
                                                "sButtonText": "<i class='fa fa-print bigger-110 grey'></i>",

                                                "sMessage": "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small>Optional Navbar &amp; Text</small></a></div></div>",

                                                "sInfo": "<h3 class='no-margin-top'>Print view</h3>\
                                                                  <p>Please use your browser's print function to\
                                                                  print this table.\
                                                                  <br />Press <b>escape</b> when finished.</p>",
                                        }
                        ]
                    } );
                        //we put a container before our table and append TableTools element to it
                        $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));

                        //also add tooltips to table tools buttons
                        //addding tooltips directly to "A" buttons results in buttons disappearing (weired! don't know why!)
                        //so we add tooltips to the "DIV" child after it becomes inserted
                        //flash objects inside table tools buttons are inserted with some delay (100ms) (for some reason)
                        setTimeout(function() {
                                $(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function() {
                                        var div = $(this).find('> div');
                                        if(div.length > 0) div.tooltip({container: 'body'});
                                        else $(this).tooltip({container: 'body'});
                                });
                        }, 200);

                        //ColVis extension
                        var colvis = new $.fn.dataTable.ColVis( oTable1, {
                                "buttonText": "<i class='fa fa-search'></i>",
                                "aiExclude": [0, 6],
                                "bShowAll": true,
                                //"bRestore": true,
                                "sAlign": "right",
                                "fnLabel": function(i, title, th) {
                                        return $(th).text();//remove icons, etc
                                }

                        }); 

                        //style it
                        $(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-info btn-bold')

                        //and append it to our table tools btn-group, also add tooltip
                        $(colvis.button())
                        .prependTo('.tableTools-container .btn-group')
                        .attr('title', 'Show/hide columns').tooltip({container: 'body'});

                        //and make the list, buttons and checkboxed Ace-like
                        $(colvis.dom.collection)
                        .addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right')
                        .find('li').wrapInner('<a href="javascript:void(0)" />') //'A' tag is required for better styling
                        .find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');

                        /////////////////////////////////
                        //table checkboxes
                        $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

                        //select/deselect all rows according to table header checkbox
                        $('#dynamic-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
                                var th_checked = this.checked;//checkbox inside "TH" table header

                                $(this).closest('table').find('tbody > tr').each(function(){
                                        var row = this;
                                        if(th_checked) tableTools_obj.fnSelect(row);
                                        else tableTools_obj.fnDeselect(row);
                                });
                        });

                        //select/deselect a row when the checkbox is checked/unchecked
                        $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
                                var row = $(this).closest('tr').get(0);
                                if(!this.checked) tableTools_obj.fnSelect(row);
                                else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
                        });

                        $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
                                e.stopImmediatePropagation();
                                e.stopPropagation();
                                e.preventDefault();
                        });


                        //And for the first simple table, which doesn't have TableTools or dataTables
                        //select/deselect all rows according to table header checkbox
                        var active_class = 'active';
                        $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
                                var th_checked = this.checked;//checkbox inside "TH" table header

                                $(this).closest('table').find('tbody > tr').each(function(){
                                        var row = this;
                                        if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                                        else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
                                });
                        });

                        //select/deselect a row when the checkbox is checked/unchecked
                        $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
                                var $row = $(this).closest('tr');
                                if(this.checked) $row.addClass(active_class);
                                else $row.removeClass(active_class);
                        });

                        /********************************/
                        //add tooltip for small view action buttons in dropdown menu
                        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

                        //tooltip placement on right or left
                        function tooltip_placement(context, source) {
                                var $source = $(source);
                                var $parent = $source.closest('table')
                                var off1 = $parent.offset();
                                var w1 = $parent.width();

                                var off2 = $source.offset();
                                //var w2 = $source.width();

                                if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
                                return 'left';
                        }

                        //datepicker plugin
                        $('.date-picker').datepicker({
                                autoclose: true,
                                todayHighlight: true
                        })
                        //show datepicker when clicking on the icon
                        .next().on(ace.click_event, function(){
                                $(this).prev().focus();
                        });

                        $( "#st_date" ).datepicker({
					showOtherMonths: true,
					selectOtherMonths: false,
                                        dateFormat: "yy-mm-dd",
					//isRTL:true,
			
					
					
					changeMonth: true,
					changeYear: true,
					
					showButtonPanel: true,
					beforeShow: function() {
						//change button colors
						var datepicker = $(this).datepicker( "widget" );
						setTimeout(function(){
							var buttons = datepicker.find('.ui-datepicker-buttonpane')
							.find('button');
							buttons.eq(0).addClass('btn btn-xs');
							buttons.eq(1).addClass('btn btn-xs btn-success');
							buttons.wrapInner('<span class="bigger-110" />');
						}, 0);
					}
			
				});			

                        $( "#ed_date" ).datepicker({
                                    showOtherMonths: true,
                                    selectOtherMonths: false,
                                    format: 'yyyy-mm-dd', 
                                    //isRTL:true,
                                    changeMonth: true,
                                    changeYear: true,
                                    language: "kr"
                                    /*
                                    changeMonth: true,
                                    changeYear: true,

                                    showButtonPanel: true,
                                    beforeShow: function() {
                                            //change button colors
                                            var datepicker = $(this).datepicker( "widget" );
                                            setTimeout(function(){
                                                    var buttons = datepicker.find('.ui-datepicker-buttonpane')
                                                    .find('button');
                                                    buttons.eq(0).addClass('btn btn-xs');
                                                    buttons.eq(1).addClass('btn btn-xs btn-success');
                                                    buttons.wrapInner('<span class="bigger-110" />');
                                            }, 0);
                                    }
                    */
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
