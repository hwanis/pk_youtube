<?php
    require_once '../inc/inc_sales_header.php';
  //  echo $basename = basename($_SERVER["PHP_SELF"]);
    if(Empty($_REQUEST[st_date])){
        $st_date = '2019-11-01';
    }else{
        $st_date = $_REQUEST[st_date];
    }

    if(Empty($_REQUEST[ed_date])){
        $ed_date = date("Y-m-d");
    }else{
        $ed_date = $_REQUEST[ed_date];
    }

    $req_s_id = $_SESSION[s_id];    
    
    $obj_st = new class_stats();  
   
    //total
  
    $tot_list = $obj_st->getStatsTotSales($st_date, $ed_date, $ct_id = '');
  
    // 신의 한수 cs 집계
    $sin_list = $obj_st ->getStatsDailySales($ct_id = 'pk_tlsdmlgkstn', $it_id, $st_date, $ed_date, 'cs');
    $sin_w_list = $obj_st ->getStatsDailySales($ct_id = 'pk_tlsdmlgkstn', $it_id, $st_date, $ed_date, 'web');
   
    //WEB  매출 집계
    $daily_sales_list = $obj_st->getDailyStats($st_date, $ed_date);
    $sal_item_list = $obj_st->getSalItem();   
   
    $sal_w_item_list = $obj_st->getWebCtSalItem($ct_id);
?>
    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>


<div class="main-content">
    <div class="main-content-inner">
         <?php require_once '../inc/inc_top_path.php'; ?>
        <form class="form-horizontal" name="frmStDaily" id="frmStDaily" role="form" action="stats_sales.php" enctype="multipart/form-dat"> 
            <div class="row">
                <div class="col-sm-6">
                    <table>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;기 &nbsp;&nbsp;&nbsp;간&nbsp;&nbsp;&nbsp;</td>
                            <td>                                
                                <div class="input-group input-group-sm">                                
                                    <input type="text" id="st_date" name="st_date" class="form-control" value="<?=$st_date?>" maxlength="8" readonly="true" />
                                    <span class="input-group-addon">
                                        <i class="ace-icon fa fa-calendar"></i>
                                    </span>                                
                                </div>                      
                            </td>
                            <td>&nbsp;&nbsp;~&nbsp;&nbsp;</td>
                            <td>
                                <div class="input-group input-group-sm">                                
                                    <input type="text" id="ed_date" name="ed_date"  class="form-control" value="<?=$ed_date?>"  maxlength="8" readonly="true"  />
                                    <span class="input-group-addon">
                                            <i class="ace-icon fa fa-calendar"></i>
                                    </span>                   
                                </div>                                
                            </td>
                            <td style="margin-left: 10px">
                                &nbsp;&nbsp;&nbsp;
                                <button id="btn_save" onclick="javascript:searchDates(frmStDaily);">
                                    <i class="ace-icon fa fa-search icon-on-right smaller-90"></i> Search
                                </button>
                            </td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                    </table>                       
                </div><!-- ./span -->
            </div>
        </form>
        
        
        <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->                   
                    <div class="col-xs-12">
                        <div class="tabbable">                         
                        <ul class="nav nav-tabs" id="myTab">
                           <!-- <li class="active">
                                <a data-toggle="tab" href="#dashboard">
                                   <i class="green ace-icon fa fa-search bigger-120"></i>
                                    DashBoard
                                    <span class="badge badge-danger"></span>
                                </a>
                            </li>
                           -->                           
                            <li class="active">
                                <a data-toggle="tab" href="#tot">
                                   <i class="green ace-icon fa fa-search bigger-120"></i>
                                    전체
                                    <span class="badge badge-danger"></span>
                                </a>
                            </li>
                            
                            
                            <li>
                                <a data-toggle="tab" href="#sin">
                                    <i class="green ace-icon fa fa-search bigger-120"></i>
                                    신의한수(CS)
                                    <span class="badge badge-danger"></span>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#sin_web">
                                    <i class="green ace-icon fa fa-search bigger-120"></i>
                                    신의한수(WEB)
                                    <span class="badge badge-danger"></span>
                                </a>
                            </li>
                            
                            <?php
                                for($i=0;$i<count($sal_item_list);$i++){
                            ?>
                            <li>
                                <a data-toggle="tab" href="#<?=$i?>">
                                    <i class="green ace-icon fa fa-search bigger-120"></i>
                                    <?=$sal_item_list[$i][ct_name]?>(WEB)
                                    <span class="badge badge-danger"></span>
                                </a>
                            </li>
                            
                            <?php
                                }
                            ?>
                           
                        </ul>
                            <!-- dashboard -->
                        <div class="tab-content">  
                        <!--
                            <div id="dashboard" class="tab-pane fade in active">                    
                                <div></div> 
                            </div>
                        -->
                        
                        
                        <div id="tot"  class="tab-pane fade in active">                                                       
                                <div class="table-header">&nbsp;</div>                                                                    
                                    <div style="width: 100%; height: 600px; overflow: auto">
                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="center" rowspan="3">주문일</th>
                                                <th class="center" colspan="2" rowspan="2">합계</th>
                                                <th class="center" colspan="4">구전녹용</th>
                                                <th class="center" colspan="4">순</th>                                            
                                                <th class="center" colspan="4">금지옥엽</th> 
                                                <th class="center" colspan="4">당금아기</th>  
                                                <th class="center" colspan="4">복세편살</th>
                                            </tr>
                                            <tr>                                         
                                                <th class="center" colspan="2">10포</th>
                                                <th class="center" colspan="2">30포</th>                                            
                                                <th class="center" colspan="2">10포</th>
                                                <th class="center" colspan="2">30포</th>
                                                <th class="center" colspan="2">10포</th>
                                                <th class="center" colspan="2">30포</th>
                                                <th class="center" colspan="2">10포</th>
                                                <th class="center" colspan="2">30포</th>   
                                                <th class="center" colspan="2">10포</th>                                               
                                            </tr>
                                            <tr>                                              
                                                <th class="center" >수량</th>
                                                <th class="center" >매출</th> 
                                                <th class="center" >수량</th>
                                                <th class="center" >매출</th> 
                                                <th class="center" >수량</th>
                                                <th class="center" >매출</th>   
                                                <th class="center" >수량</th>
                                                <th class="center" >매출</th> 
                                                <th class="center" >수량</th>
                                                <th class="center" >매출</th>   
                                                <th class="center" >수량</th>
                                                <th class="center" >매출</th>    
                                                <th class="center" >수량</th>
                                                <th class="center" >매출</th> 
                                                <th class="center" >수량</th>
                                                <th class="center" >매출</th>  
                                                <th class="center" >수량</th>
                                                <th class="center" >매출</th>  
                                                 <th class="center" >수량</th>
                                                <th class="center" >매출</th>                                               
                                            </tr> 
                                        </thead>
                                <tbody>
                                    <?php
                                    for($i=0;$i<count($tot_list);$i++){                                      
                                    ?>
                                        <tr >   
                                            <td style="text-align: right"><?=$tot_list[$i][sal_date]?></td>                                               
                                            <td style="text-align: right">
                                            <?php 
                                                echo $tot_qty = 
                                             $tot_list[$i][org_10_qty]+$tot_list[$i][sun_10_qty]+$tot_list[$i][ji_10_qty]+$tot_list[$i][dang_10_qty]+$tot_list[$i][bok_10_qty]
                                            +$tot_list[$i][org_30_qty]+$tot_list[$i][sun_30_qty]+$tot_list[$i][ji_30_qty]+$tot_list[$i][dang_30_qty]+$tot_list[$i][bok_30_qty];
                                                
                                             ?>
                                            </td>
                                            <td style="text-align: right"><?php 
                                             $tot_price = 
                                                     $tot_list[$i][org_10_price]+$tot_list[$i][sun_10_price]+$tot_list[$i][ji_10_price]+$tot_list[$i][dang_10_price]+$tot_list[$i][bok_10_price]
                                            +$tot_list[$i][org_30_price]+$tot_list[$i][sun_30_price]+$tot_list[$i][ji_30_price]+$tot_list[$i][dang_30_price]+$tot_list[$i][bok_30_price]
                                           ;
                                             echo number_format($tot_price);
                                            ?></td>                                          
                                             
                                            <td style="text-align: right"><?=number_format($tot_list[$i][org_10_qty])?></td>
                                            <td style="text-align: right"><?=number_format($tot_list[$i][org_10_price])?></td>                                                                                   
                                            
                                            <td style="text-align: right"><?=number_format($tot_list[$i][org_30_qty])?></td>
                                            <td style="text-align: right"><?=number_format($tot_list[$i][org_30_price])?></td>                                          
                                          
                                            <td style="text-align: right"><?=number_format($tot_list[$i][sun_10_qty])?></td>
                                            <td style="text-align: right"><?=number_format($tot_list[$i][sun_10_price])?></td>                                                                                                                
                                            
                                            <td style="text-align: right"><?=number_format($tot_list[$i][sun_30_qty])?></td>
                                            <td style="text-align: right"><?=number_format($tot_list[$i][sun_30_price])?></td>                                                                                                                        
                                            
                                             <td style="text-align: right"><?=number_format($tot_list[$i][ji_10_qty])?></td>
                                            <td style="text-align: right"><?=number_format($tot_list[$i][ji_10_price])?></td>                                                                                   
                                            
                                            <td style="text-align: right"><?=number_format($tot_list[$i][ji_30_qty])?></td>
                                            <td style="text-align: right"><?=number_format($tot_list[$i][ji_30_price])?></td>                                          
                                          
                                            <td style="text-align: right"><?=number_format($tot_list[$i][dang_10_qty])?></td>
                                            <td style="text-align: right"><?=number_format($tot_list[$i][dang_10_price])?></td>                                                                                                                
                                            
                                            <td style="text-align: right"><?=number_format($tot_list[$i][dang_30_qty])?></td>
                                            <td style="text-align: right"><?=number_format($tot_list[$i][dang_30_price])?></td>           
                                            
                                             <td style="text-align: right"><?=number_format($tot_list[$i][bok_10_qty])?></td>
                                            <td style="text-align: right"><?=number_format($tot_list[$i][bok_10_price])?></td> 
                                        </tr>   
                                    <?php                                     
                                    }
                                    ?>
                                </tbody>
                                </table>
                            </div> 
                            </div>
                         
                            <!--- 신의한수 -->
                           <div id="sin"  class="tab-pane">                                                       
                            <div class="table-header">&nbsp;</div>                                            
                           <div style="width: 100%; height: 600px; overflow: auto">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="center" rowspan="2">주문일</th>
                                            <th class="center"  colspan="2">합계</th>
                                            <th class="center"  colspan="2">구전녹용 순</th>
                                            <th class="center"  colspan="2">구전녹용</th>                                            
                                            <th class="center"  colspan="2">금지옥엽</th>   
                                             <th class="center"  colspan="2">복세편살</th>
                                        </tr>
                                        <tr>                                              
                                            <th class="center" >수량</th>
                                            <th class="center" >총매출</th>
                                         
                                            <th class="center" >수량</th>
                                            <th class="center" >매출</th> 
                                           
                                            <th class="center" >수량</th>
                                            <th class="center" >매출</th> 
                                         
                                            <th class="center" >수량</th>
                                            <th class="center" >매출</th>                  
                                            
                                            <th class="center" >수량</th>
                                            <th class="center" >매출</th>   
                                        </tr> 
                                    </thead>
                                     <tbody>
                                        <?php 
                                            for($i=0;$i<count($sin_list);$i++){
                                        ?>
                                       
                                            <tr>   
                                                <td style="text-align: right"><?=$sin_list[$i][sal_date]?></td>                                                 
                                                <td style="text-align: right"><?=number_format($sin_list[$i][sun_price]+$sin_list[$i][org_price]+$sin_list[$i][ji_price]+$sin_list[$i][bok_price])?></td>
                                                <td style="text-align: right"><?=number_format($sin_list[$i][sun_qty]+$sin_list[$i][org_qty]+$sin_list[$i][ji_qty]+$sin_list[$i][bok_qty])?></td>
                                                <td style="text-align: right"><?=number_format($sin_list[$i][sun_price])?></td>
                                                <td style="text-align: right"><?=number_format($sin_list[$i][sun_qty])?></td>
                                                <td style="text-align: right"><?=number_format($sin_list[$i][org_price])?></td>
                                                <td style="text-align: right"><?=number_format($sin_list[$i][org_qty])?></td>
                                                 <td style="text-align: right"><?=number_format($sin_list[$i][ji_price])?></td>
                                                <td style="text-align: right"><?=number_format($sin_list[$i][ji_qty])?></td>
                                                 <td style="text-align: right"><?=number_format($sin_list[$i][bok_price])?></td>
                                                <td style="text-align: right"><?=number_format($sin_list[$i][bok_qty])?></td>
                                            </tr>   
                                            
                                      <?php
                                            }
                                        ?>
                                  </tbody>
                                    </table>
                                </div> 
                            </div>
                            
                            <!-- 신의 한 수 web -->
                              <div id="sin_web"  class="tab-pane">                                                       
                            <div class="table-header">&nbsp;</div>                                            
                           <div style="width: 100%; height: 600px; overflow: auto">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="center" rowspan="2">주문일</th>
                                            <th class="center"  colspan="2">합계</th>
                                            <th class="center"  colspan="2">구전녹용 순</th>
                                            <th class="center"  colspan="2">구전녹용</th>                                                                                       
                                             <th class="center"  colspan="2">복세편살</th>
                                        </tr>
                                        <tr>                                              
                                            <th class="center" >수량</th>
                                            <th class="center" >총매출</th>
                                         
                                            <th class="center" >수량</th>
                                            <th class="center" >매출</th> 
                                           
                                            <th class="center" >수량</th>
                                            <th class="center" >매출</th> 
                                         
                                            <th class="center" >수량</th>
                                            <th class="center" >매출</th>   
                                        </tr> 
                                    </thead>
                                     <tbody>
                                        <?php 
                                            for($i=0;$i<count($sin_w_list);$i++){
                                        ?>
                                       
                                            <tr>   
                                                <td style="text-align: right"><?=$sin_w_list[$i][sal_date]?></td>                                                 
                                                <td style="text-align: right"><?=number_format($sin_w_list[$i][sun_price]+$sin_w_list[$i][org_price]+$sin_w_list[$i][bok_price])?></td>
                                                <td style="text-align: right"><?=number_format($sin_w_list[$i][sun_qty]+$sin_w_list[$i][org_qty]+$sin_w_list[$i][bok_qty])?></td>
                                                <td style="text-align: right"><?=number_format($sin_w_list[$i][sun_price])?></td>
                                                <td style="text-align: right"><?=number_format($sin_w_list[$i][sun_qty])?></td>
                                                <td style="text-align: right"><?=number_format($sin_w_list[$i][org_price])?></td>
                                                <td style="text-align: right"><?=number_format($sin_w_list[$i][org_qty])?></td>                                               
                                                 <td style="text-align: right"><?=number_format($sin_w_list[$i][bok_price])?></td>
                                                <td style="text-align: right"><?=number_format($sin_w_list[$i][bok_qty])?></td>
                                            </tr>   
                                            
                                      <?php
                                            }
                                        ?>
                                  </tbody>
                                    </table>
                                </div> 
                            </div>
                            
                            
                            
                            
                            
                            
                            
                            
                            <!---- end ---->
                          <!-- web 매출 -->
                        <?php                           
                            for($i=0;$i<count($sal_item_list);$i++){
                        ?>
                        <div id="<?=$i?>"  class="tab-pane">
                        <div class="table-header">&nbsp;</div>                                            
                           <div style="width: 100%; height: 600px; overflow: auto">
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                     
                                    <thead>
                                        <tr>
                                            <th class="center" rowspan="2">주문일</th>
                                            <th class="center"  colspan="2">합계</th>
                                            <th class="center"  colspan="2"><?=$sal_item_list[$i][it_name]?>(<?=$sal_item_list[$i][it_class_opt]?>)</th>                                         
                                        </tr>
                                        <tr>                                              
                                            <th class="center" >수량</th>
                                            <th class="center" >총매출</th>                                            
                                            <th class="center" >수량</th>
                                            <th class="center" >매출</th>                                             
                                        </tr> 
                                    </thead>
                                     <tbody> 
                                        <tr>  
                                             <?php
                                            for($j=0;$j<count($daily_sales_list);$j++){     
                                                if($daily_sales_list[$j][ct_id] == $sal_item_list[$i][ct_id]){
                                        ?>
                                         
                                        
                                            <td style="text-align: right"><?=$daily_sales_list[$j][sal_date]?></td>                                                 
                                            <td style="text-align: right"><?=number_format($daily_sales_list[$j][d_tot_qty])?></td>
                                            <td style="text-align: right"><?=number_format($daily_sales_list[$j][d_tot_price])?></td>
                                            
                                            
                                            
                                            
                                            <td style="text-align: right"><?=number_format($daily_sales_list[$j][d_tot_qty])?></td>
                                            <td style="text-align: right"><?=number_format($daily_sales_list[$j][d_tot_price])?></td>
                                            
                                            
                                            
                                            
                                        </tr>   
                                      
                                  
                                      <?php
                                                }
                                            }
                                        ?>
                                          </tbody>
                                    </table>
                                </div> 
                            </div>
                          <?php
                            }
                            ?>
                          
                                </div>                    
                            </div>
                        </div>    
                    </div><!-- /.col -->
                </div><!-- /.row -->        
            </div><!-- /.page-content -->
        </div>
    </div>
<?php
    require_once '../inc/inc_sales_footer.php';
?>
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"><i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i></a>
</div><!-- /.main-container -->

    <!-- basic scripts -->                
    <script src="../js/pk_common.js"></script>
    <script>               
   // portfolio check
   function Submit(form) {                   

        var str_st_date = form.st_date.value;
        var str_ed_date = form.ed_date.value;

        if(str_st_date.length < 10){             
            alert("시작일을 선택 해주세요");
            form.st_date.focus();
            return;
        }

        if(str_ed_date.length < 10){             
            alert("종료일을 선택 해주세요");
            form.ed_date.focus();
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
        <script src="../assets/js/ace/elements.spinner.js"></script>		
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


                        //datepicker plugin
                        //link
                    //link
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
