<?php
    require_once '../inc/inc_sales_header.php';
  //  echo $basename = basename($_SERVER["PHP_SELF"]);
    /*
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
*/
    $req_s_id = $_SESSION[s_id];
     
    $obj = new class_stdata();
    
    //request 페이지 번호
    if(empty($_REQUEST[page_no])){
        $page_no = 1;
    }else{
        $page_no = $_REQUEST[page_no];
    }
    
    //request 블록 번호
    if(empty($_REQUEST[block_no])){
        $block_no = 1;
    }else{
        $block_no = $_REQUEST[block_no];
    }
    
    $page_list_no = 10; //한 페이지에 표시되는 최대 레코드 수
    $block_cnt = 15;     // 한페이지에 표시할 Page 갯수    
   // $where = " date_format(od_time, '%Y-%m') BETWEEN '$st_date' AND '$ed_date' ";      
  //  $branch = $_SESSION[branch];
  //   $where = " mb_level = '$req_s_id' ";
     switch($_SESSION[s_auth]){            
        case 0: $where = " ";break;
        case 1: $where = " WHERE ct_id = '$_SESSION[s_id]' "; break;            
    }
 
    $list =      $obj->getMohthlyList($page_no, $page_list_no, $where, $req_s_id, 'list', $_SESSION[s_auth]);    
    $list_cnt =  $obj->getMohthlyList($page_no, $page_list_no, $where, $req_s_id, 'cnt', $_SESSION[s_auth]);    
    $list_tot = count($list_cnt);
    //전체 페이지 갯수
    $page_tot = ceil($list_tot/$page_list_no);
    //전체 블록 갯수
    $block_tot = ceil($page_tot/$block_cnt);
    //현재 페이지 블록 번호
    $cur_block_no = ceil($page_no/$block_cnt);
                                   
    //총 합계, 총 판매 수량
    for($i=0;$i<count($list_cnt);$i++){        
        $bw_tot_price = $bw_tot_price + $list_cnt[$i][d_tot_price];
        $bw_tot_qty = $bw_tot_qty + $list_cnt[$i][d_tot_qty];        
    }

?>

    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>

<!-- /section:basics/sidebar -->
<div class="main-content">
    <div class="main-content-inner">
         <?php require_once '../inc/inc_top_path.php'; ?>          
    </div>
    
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->    

        <div class="row">
            <div class="col-xs-12">
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="center" style="width:33%"><label class="pos-rel"><span class="lbl">주문날짜</span></label></th>
                            <th class="center" style="width:33%">판매 금액</th>
                            <th class="center" style="width:33%">판매 수량(BOX)</th>
                                             
                        </tr>
                    </thead>
                    <tbody>                  
                        <tr>
                            <td class="center">
                                <label class="pos-rel">
                                    <?=$list[$i][sal_date]?>
                                </label>
                            </td>
                            <td class="center"><?=number_format($bw_tot_price)?></td>
                            <td class="center"><?=number_format($bw_tot_qty)?></td>                                     
                        </tr>	
                    </tbody>
                </table>
            </div><!-- /.span -->
        </div><!-- /.row -->
    </div>
                  
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->    

        <div class="row">
            <div class="col-xs-12">
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>  
                            <th class="center" style="width:33%">월</th>
                            <th class="center" style="width:33%">총 판매 금액</th>
                            <th class="center" style="width:33%">총 판매 수량(BOX)</th>                                               
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        for($i=0;$i<count($list);$i++){
                    ?>
                        <tr>
                            <td class="center">
                                <label class="pos-rel">
                                    <?=$list[$i][sal_date]?>
                                </label>
                            </td>
                            <td style="text-align: right"><?=number_format($list[$i][d_tot_price])?></td>
                            <td style="text-align: right"><?=number_format($list[$i][d_tot_qty])?></td>                                       
                        </tr>
                    <?php 
                        } 
                    ?>											
                    </tbody>
                </table>
            </div><!-- /.span -->
        </div><!-- /.row -->
    </div>
</div>
        <div class="hr hr32 hr-dotted"></div>
                
    <div class="col-xs-12">
        <!-- pagination -->
            <div class="center">
                <ul class="pagination">                                
                    <?php
                     
                    if($block_no == 1 ){
                    ?>
                    <li class="disabled">
                        <a href="#">
                            <i class="ace-icon fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    <?php                                
                        }else{                                        
                    ?>
                     <li>
                         <a href="<?=$basename?>?page_no=<?=($cur_block_no-2)*$block_cnt+1?>&block_no=<?=$cur_block_no-1?>&st_date=<?=$_REQUEST[st_date]?>&ed_date=<?=$_REQUEST[ed_date]?>">
                            <i class="ace-icon fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    <?php
                        }

                    //시작 페이지 번호
                    $start_page_no = ($cur_block_no-1)*$block_cnt+1;

                    //마지막 블록에는 페이지 갯수가 변동
                    if($cur_block_no != $block_tot ){
                        $end_page = $start_page_no+($block_cnt-1);
                    }else {
                        $end_page = $page_tot;
                    }                                    

                    //페이지 번호 출력
                    for($i=$start_page_no;$i<$end_page+1;$i++)
                    {                                        
                        if($page_no == $i){
                            $class_active = " class = 'active'";
                        }else{
                            $class_active = '';
                        }
                    ?>
                        <li <?=$class_active?>>
                            <a href="<?=$basename?>?page_no=<?=$i?>&block_no=<?=$cur_block_no?>&st_date=<?=$_REQUEST[st_date]?>&ed_date=<?=$_REQUEST[ed_date]?>"><?=$i?></a>
                        </li>
                    <?php
                    }                                    

                    if($cur_block_no == $block_tot){
                    ?>
                    <li class="disabled">                                    
                        <a href="#">
                            <i class="ace-icon fa fa-angle-double-right"></i>
                        </a>                                   
                    </li>
                     <?php
                        }else{
                        ?>
                    <li>                                    
                         <a href="<?=$basename?>?page_no=<?=$block_cnt*$cur_block_no+1?>&block_no=<?=(int)$cur_block_no+1?>&st_date=<?=$_REQUEST[st_date]?>&ed_date=<?=$_REQUEST[ed_date]?>">
                            <i class="ace-icon fa fa-angle-double-right"></i>
                        </a>                                   
                    </li>
                        <?php } ?>
                </ul>
            </div>                                                                                                               
        </div><!-- /.col -->      
    </div><!-- /.page-content -->
            
    <?php
        require_once '../inc/inc_sales_footer.php';
    ?>            
</div>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"><i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i></a>
    </div><!-- /.main-container -->

		<!-- basic scripts -->
                
                <script src="../js/pk_common.js"></script>
                <script>               
               // portfolio check
               function SubmitXls(form) {
                
                
                    var str_st_date = fn_str_trim(form.st_date.value);
                    var str_ed_date = fn_str_trim(form.ed_date.value);
                    
                    if(str_st_date.length < 2){             
                        alert("시작일을 선택 해주세요");
                        form.st_date.focus();
                        return;
                    }
                    
                    if(str_ed_date.length < 2){             
                        alert("종료일을 선택 해주세요");
                        form.ed_date.focus();
                        return;
                    }
 
                    // alert('등록 되었습니다');
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
                                    dateFormat: "yy-mm",
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
                                    dateFormat: "yy-mm",
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
