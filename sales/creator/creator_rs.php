<?php
    require_once '../inc/inc_sales_header.php';
  //  echo $basename = basename($_SERVER["PHP_SELF"]);
    
    $obj = new class_creator();
    $obj_creator = new class_creator();
    
    //get dropdown creator list
    $ct_dd_list =$obj_creator->getCreatorRsList();        
    $ct_infor = $obj_creator->getChkLoginId($_REQUEST[ct_id]);
    $traffice_list = $obj_creator->getTraffic($get_post, $_REQUEST[ct_id]);
    
    $ct_infor[rs_rate];
        
    $req_s_id = $_REQUEST[ct_id];    
    
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
    $where = " mb_level = '$req_s_id'  ";      
  //  $branch = $_SESSION[branch];
 
    $list =      $obj->getCreatorRs($page_no, $page_list_no, $where, $_REQUEST[ct_id], 'list');    
    $list_cnt =  $obj->getCreatorRs($page_no, $page_list_no, $where, $_REQUEST[ct_id], 'cnt');    
    $list_tot = count($list_cnt);
    //전체 페이지 갯수
    $page_tot = ceil($list_tot/$page_list_no);
    //전체 블록 갯수
    $block_tot = ceil($page_tot/$block_cnt);
    //현재 페이지 블록 번호
    $cur_block_no = ceil($page_no/$block_cnt);
                                   
    //전체
    $tot_daily_price = "";

    for($i=count($list_cnt);$i>-1;$i--){   
        isset($list_cnt[$i][d_tot_price])?$reg=$list_cnt[$i][d_tot_price]:$reg=0;

        if($i>0){
            $tot_daily_price = $tot_daily_price."['".$list_cnt[$i][sal_date]."',".$reg."],";
        }else{
            $tot_daily_price = $tot_daily_price."['".$list_cnt[$i][sal_date]."',".$reg."]";    
        }            
    //  echo $tot_daily_price;
    }

?>
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


    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
   
        function openChild(url, field) {

            var popupX = (window.screen.width / 2) - (600 / 2);
            var popupY= (window.screen.height /2) - (600 / 2);
            window.open(url, 'pop', 'status=no, scroll=yes height=350, width=900, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);

        }
        
    </script>
</div>

<!-- /section:basics/sidebar -->
<div class="main-content">
    <div class="main-content-inner">
         <?php require_once '../inc/inc_top_path.php'; ?>
        <!-- #section:basics/content.breadcrumbs -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                  
                        <!-- #section:elements.form -->									
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">        
                                 <form name="login_form" action="creator_rs.php"  class="form-horizontal" role="form" enctype="multipart/form-data" >       
                              <!--       <input type="text" name ="page_no" value="<?=$page_no?>">
                                     <input type="text" name ="page_list_no" value="<?=$page_list_no?>">
                                     <input type="text" name ="block_no" value="<?=$block_no?>">    -->                           
                                <table>
                                    <tr>
                                        <td>
                                             <button class="btn btn-message" type="button" name="btnSubmit" onclick="javascript:Submit(this.form)">                                                 
                                                <i class="ace-icon fa fa-check smaller-60"></i>Submit
                                             </button> 
                                        </td>
                                        <td>&nbsp; &nbsp; &nbsp;</td>
                                        <td style="width: 70%">  
                                              <select class="chosen-select form-control" id="form-field-select-4" name="ct_id" data-placeholder="Choose a Creator...">
                                                <?php                                                 
                                                    for($i=0;$i<count($ct_dd_list);$i++){
                                                ?>
                                                    <option value=""> </option>
                                                <?php
                                                    if($req_s_id == $ct_dd_list[$i][ct_id]){
                                                ?>
                                                    <option value="<?=$ct_dd_list[$i][ct_id]?>" selected><?=$ct_dd_list[$i][ct_name]?></option>                                                           
                                                <?php
                                                    }else{
                                                ?>
                                                    <option value="<?=$ct_dd_list[$i][ct_id]?>" ><?=$ct_dd_list[$i][ct_name]?></option>        
                                                <?php                                                        
                                                    }
                                                }
                                                ?>
                                            </select>                                                        
                                        </td>
                                    </tr>
                                </table>  
                                </form>
                            </div>
                        </div><!-- /.span -->                            
                    </div><!-- /.row -->
                    <div class="space-12"></div>                 

                </div><!-- /.col -->
            </div>
            <div class="col-xs-12" style="margin-bottom: 10px">
                <?php 
                    if($_SESSION[s_auth] == 0){
                ?>
                 <a href="creator_rs_exc.php?page_no=<?=$page_no?>&page_list_no=<?=$page_list_no?>&where=<?=$where?>&req_s_id=<?=$req_s_id?>&tag=cnt&s_auth=<?=$_SESSION[s_auth]?>" id="id-btn-dialog2" class="btn btn-info btn-sm">
                    엑셀 다운로드
                 </a> 
                <?php
                    }
                ?>
            </div>                                                       
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->    
        <div class="row">
            <div class="col-xs-12">
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                         
                            <th class="center"><label class="pos-rel"><span class="lbl">번호</span></label></th>
                            <th class="center">주문일자</th>
                            <th class="center">유입건수</th>
                            <th class="center">판매수</th>
                           <th class="hidden-480 center">전환</th>                            
                            <th class="center">매출액</th>
                            <th class="center">매출액 - RS</th>
                             <th class="center">RS</th>
                            <th class="center">유튜버 수수료 액(<?=$ct_infor[rs_rate]?>%)</th>
                            <!-- <th class="hidden-480 center">우편번호</th>                           
                            <th class="hidden-480 center">주소</th>-->
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    
                        $reverse = Array();
                        for($i=0;$i<count($list);$i++){
                    ?>
                        <tr>
                            <td class="center">
                                <button class="btn btn-xs btn-info"  onclick="openChild('ct_rs_pop.php?ct_id=<?=$req_s_id?>&sal_date=<?=$list[$i][sal_date]?>&sal_traffic=<?=$list[$i][sal_traffic]?>', this);">
                                    유입정보
                                </button>
                            </td>
                            <td class="center"><?=$list[$i][sal_date]?></td>
                            <td class="center">
                                <?php
                                if($list[$i][sal_traffic] == ''){
                                    echo 0;
                                }else{
                                    echo $list[$i][sal_traffic];
                                }
                                ?>                              
                            </td>
                            <td class="center"><?=number_format($list[$i][d_tot_qty])?></td>
                            <td style="text-align: right">
                                <?php                               
                                    echo round((int)$list[$i][d_tot_qty]/(int)$list[$i][sal_traffic],3).'%';                                
                                ?>
                            </td>
                            <td style="text-align: right"><?=number_format($list[$i][d_tot_price])?></td>
                            <td style="text-align: right"><?=number_format($list[$i][d_tot_price]-$list[$i][d_tot_price]*($ct_infor[rs_rate]/100))?></td>
                            <?php                                    
                                $obj_rs = new class_creator();
                                $rs = $obj_rs->getCtSalesRs($list[$i][ct_id], $list[$i][sal_date]);                                 
                            ?>
                            <td style="text-align: right"><?=$rs[sal_rs]?>%</td>
                            <td style="text-align: right">
                            <?php                            
                                echo number_format($list[$i][d_tot_price]*($rs[sal_rs]/100));                           
                            ?>                            
                            </td>
                        </tr>
                    <?php 
                        } 
                    ?>											
                    </tbody>
                </table>
            </div><!-- /.span -->
                           
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
                                            <a href="<?=$basename?>?page_no=<?=$i?>&block_no=<?=$cur_block_no?>&ct_id=<?=$req_s_id?>"><?=$i?></a>
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
                                         <a href="<?=$basename?>?page_no=<?=$block_cnt*$cur_block_no+1?>&block_no=<?=(int)$cur_block_no+1?>">
                                            <i class="ace-icon fa fa-angle-double-right"></i>
                                        </a>                                   
                                    </li>
                                        <?php } ?>
                                </ul>
                            </div>                                                                                                               
                        </div><!-- /.col -->      
                    </div><!-- /.row -->
                </div>
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
			
            
    <?php
        require_once '../inc/inc_sales_footer.php';
    ?>            
    
           <!-- common js -->
        <script src="../js/common.js"></script>
        <!-- form check -->
        <script src="../js/form_check.js"></script>
        
        <script type="text/javascript">
            function Submit(form) {
              
            //    var str_m_id = fn_str_trim(form.m_id.value);
            //    var str_m_pass = fn_str_trim(form.m_pass.value);
            
                var str_ct_id = form.ct_id.value;              
                
                if (str_ct_id === ''){
                    alert("이름을 정확히 입력 해주세요.");
                    form.ct_id .focus();
                    return;
                }

                form.submit(); 
                                
            }
        </script>
        
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>

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
		<script src="../assets/js/chosen.jquery.js"></script>
		<script src="../assets/js/fuelux/fuelux.spinner.js"></script>
		<script src="../assets/js/date-time/bootstrap-datepicker.js"></script>
		<script src="../assets/js/date-time/bootstrap-timepicker.js"></script>
		<script src="../assets/js/date-time/moment.js"></script>
		<script src="../assets/js/date-time/daterangepicker.js"></script>
		<script src="../assets/js/date-time/bootstrap-datetimepicker.js"></script>
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
				
				$('textarea[class*=autosize]').autosize({append: "\n"});
				$('textarea.limited').inputlimiter({
					remText: '%n character%s remaining...',
					limitText: 'max allowed : %n.'
				});
			
				$.mask.definitions['~']='[+-]';
				$('.input-mask-date').mask('99/99/9999');
				$('.input-mask-phone').mask('(999) 999-9999');
				$('.input-mask-eyescript').mask('~9.99 ~9.99 999');
				$(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
			
			
			
				$( "#input-size-slider" ).css('width','200px').slider({
					value:1,
					range: "min",
					min: 1,
					max: 8,
					step: 1,
					slide: function( event, ui ) {
						var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
						var val = parseInt(ui.value);
						$('#form-field-4').attr('class', sizing[val]).val('.'+sizing[val]);
					}
				});
			
				$( "#input-span-slider" ).slider({
					value:1,
					range: "min",
					min: 1,
					max: 12,
					step: 1,
					slide: function( event, ui ) {
						var val = parseInt(ui.value);
						$('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
					}
				});
			
			
				
				//"jQuery UI Slider"
				//range slider tooltip example
				$( "#slider-range" ).css('height','200px').slider({
					orientation: "vertical",
					range: true,
					min: 0,
					max: 100,
					values: [ 17, 67 ],
					slide: function( event, ui ) {
						var val = ui.values[$(ui.handle).index()-1] + "";
			
						if( !ui.handle.firstChild ) {
							$("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
							.prependTo(ui.handle);
						}
						$(ui.handle.firstChild).show().children().eq(1).text(val);
					}
				}).find('span.ui-slider-handle').on('blur', function(){
					$(this.firstChild).hide();
				});
				
				
				$( "#slider-range-max" ).slider({
					range: "max",
					min: 1,
					max: 10,
					value: 2
				});
				
				$( "#slider-eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
					// read initial values from markup and remove that
					var value = parseInt( $( this ).text(), 10 );
					$( this ).empty().slider({
						value: value,
						range: "min",
						animate: true
						
					});
				});
				
				$("#slider-eq > span.ui-slider-purple").slider('disable');//disable third item
			
				
				$('#id-input-file-1 , #id-input-file-2').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false //| true | large
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				});
				//pre-show a file name, for example a previously selected file
				//$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])
			
			
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
				
				
				//$('#id-input-file-3')
				//.ace_file_input('show_file_list', [
					//{type: 'image', name: 'name of image', path: 'http://path/to/image/for/preview'},
					//{type: 'file', name: 'hello.txt'}
				//]);
			
				
				
			
				//dynamically change allowed formats by changing allowExt && allowMime function
				$('#id-file-format').removeAttr('checked').on('change', function() {
					var whitelist_ext, whitelist_mime;
					var btn_choose
					var no_icon
					if(this.checked) {
						btn_choose = "Drop images here or click to choose";
						no_icon = "ace-icon fa fa-picture-o";
			
						whitelist_ext = ["jpeg", "jpg", "png", "gif" , "bmp"];
						whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
					}
					else {
						btn_choose = "Drop files here or click to choose";
						no_icon = "ace-icon fa fa-cloud-upload";
						
						whitelist_ext = null;//all extensions are acceptable
						whitelist_mime = null;//all mimes are acceptable
					}
					var file_input = $('#id-input-file-3');
					file_input
					.ace_file_input('update_settings',
					{
						'btn_choose': btn_choose,
						'no_icon': no_icon,
						'allowExt': whitelist_ext,
						'allowMime': whitelist_mime
					})
					file_input.ace_file_input('reset_input');
					
					file_input
					.off('file.error.ace')
					.on('file.error.ace', function(e, info) {
						//console.log(info.file_count);//number of selected files
						//console.log(info.invalid_count);//number of invalid files
						//console.log(info.error_list);//a list of errors in the following format
						
						//info.error_count['ext']
						//info.error_count['mime']
						//info.error_count['size']
						
						//info.error_list['ext']  = [list of file names with invalid extension]
						//info.error_list['mime'] = [list of file names with invalid mimetype]
						//info.error_list['size'] = [list of file names with invalid size]
						
						
						/**
						if( !info.dropped ) {
							//perhapse reset file field if files have been selected, and there are invalid files among them
							//when files are dropped, only valid files will be added to our file array
							e.preventDefault();//it will rest input
						}
						*/
						
						
						//if files have been selected (not dropped), you can choose to reset input
						//because browser keeps all selected files anyway and this cannot be changed
						//we can only reset file field to become empty again
						//on any case you still should check files with your server side script
						//because any arbitrary file can be uploaded by user and it's not safe to rely on browser-side measures
					});
				
				});
			
				$('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
				.closest('.ace-spinner')
				.on('changed.fu.spinbox', function(){
					//alert($('#spinner1').val())
				}); 
				$('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'ace-icon fa fa-caret-up bigger-110', icon_down:'ace-icon fa fa-caret-down bigger-110'});
				$('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
				$('#spinner4').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus', icon_down:'ace-icon fa fa-minus', btn_up_class:'btn-purple' , btn_down_class:'btn-purple'});
			
				//$('#spinner1').ace_spinner('disable').ace_spinner('value', 11);
				//or
				//$('#spinner1').closest('.ace-spinner').spinner('disable').spinner('enable').spinner('value', 11);//disable, enable or change value
				//$('#spinner1').closest('.ace-spinner').spinner('value', 0);//reset to 0
			
			
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
			
				//or change it into a date range picker
				$('.input-daterange').datepicker({autoclose:true});
			
			
				//to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
				$('input[name=date-range-picker]').daterangepicker({
					'applyClass' : 'btn-sm btn-success',
					'cancelClass' : 'btn-sm btn-default',
					locale: {
						applyLabel: 'Apply',
						cancelLabel: 'Cancel',
					}
				})
				.prev().on(ace.click_event, function(){
					$(this).next().focus();
				});
			
			
				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				$('#date-timepicker1').datetimepicker().next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
			
				$('#colorpicker1').colorpicker();
			
				$('#simple-colorpicker-1').ace_colorpicker();
				//$('#simple-colorpicker-1').ace_colorpicker('pick', 2);//select 2nd color
				//$('#simple-colorpicker-1').ace_colorpicker('pick', '#fbe983');//select #fbe983 color
				//var picker = $('#simple-colorpicker-1').data('ace_colorpicker')
				//picker.pick('red', true);//insert the color if it doesn't exist
			
			
				$(".knob").knob();
				
				
				var tag_input = $('#form-field-tags');
				try{
					tag_input.tag(
					  {
						placeholder:tag_input.attr('placeholder'),
						//enable typeahead by specifying the source array
						source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
						/**
						//or fetch data from database, fetch those that match "query"
						source: function(query, process) {
						  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
						  .done(function(result_items){
							process(result_items);
						  });
						}
						*/
					  }
					)
			
					//programmatically add a new
					var $tag_obj = $('#form-field-tags').data('tag');
					$tag_obj.add('Programmatically Added');
				}
				catch(e) {
					//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
					tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
					//$('#form-field-tags').autosize({append: "\n"});
				}
				
				
				/////////
				$('#modal-form input[type=file]').ace_file_input({
					style:'well',
					btn_choose:'Drop files here or click to choose',
					btn_change:null,
					no_icon:'ace-icon fa fa-cloud-upload',
					droppable:true,
					thumbnail:'large'
				})
				
				//chosen plugin inside a modal will have a zero width because the select element is originally hidden
				//and its width cannot be determined.
				//so we set the width after modal is show
				$('#modal-form').on('shown.bs.modal', function () {
					if(!ace.vars['touch']) {
						$(this).find('.chosen-container').each(function(){
							$(this).find('a:first-child').css('width' , '210px');
							$(this).find('.chosen-drop').css('width' , '210px');
							$(this).find('.chosen-search input').css('width' , '200px');
						});
					}
				})
				/**
				//or you can activate the chosen plugin after modal is shown
				//this way select element becomes visible with dimensions and chosen works as expected
				$('#modal-form').on('shown', function () {
					$(this).find('.modal-chosen').chosen();
				})
				*/
			
				
				
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
