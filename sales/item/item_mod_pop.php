<?php
    require_once '../autoload.php'; 
    //request 블록 번호
    if(empty($_REQUEST[it_id])){
       // 잘못된 접근
    }
    
    $obj = new class_creator();
    $view = $obj->getItemMod($_REQUEST[it_id]);
    $ct_dd_list = $obj->getCreatorRsList();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title></title>

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
           
            <!-- /section:basics/sidebar -->
<div class="main-content">
    <div class="main-content-inner">
         <?php require_once '../inc/inc_top_path.php'; ?>
        <!-- #section:basics/content.breadcrumbs -->
        
        <div class="page-content">
         
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <form name="login_form" action="item_mod_pop_pr.php"  class="form-horizontal" role="form" enctype="multipart/form-data" >
                        <input type="hidden" name="rate_id" value="<?=$view[it_id]?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 아이디 </label>
                            <div class="col-sm-9">
                                <select name="ct_id" class="chosen-select" id="form-field-select-4">
                                    <?php
                                    for($i=0;$i<count($ct_dd_list);$i++){
                                        ?>
                                        <option value=""> </option>
                                        <?php
                                        if($ct_dd_list[$i][ct_id]){
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
                            </div>
                        </div>
                        <!-- /section:elements.form -->
                        
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 제품번호 </label>
                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" name="it_id" placeholder="" class="col-xs-10 col-sm-5" value="<?=$view[it_id]?>"  maxlength="20"  readonly/>
                            </div>
                        </div>
                          <div class="space-4"></div>
                          
                       <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 제품명 </label>
                             <div class="col-sm-9">
                                 <input type="text" id="form-field-1" name="it_name" placeholder="" class="col-xs-10 col-sm-5" value="<?=$view[it_name]?>"  maxlength="20"   />
                             </div>
                        </div>

                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 제품구분 </label>
                            <div class="col-sm-9">
                                <select class="chosen-select" id="it_class" name="it_class" data-placeholder="제품선택">
                                    <option value="100">구전녹용</option>
                                    <option value="200">구전녹용 순</option>
                                    <option value="300">금지옥엽</option>
                                    <option value="400">당금아기</option>
                                    <option value="500">복세편살</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 옵션 </label>
                            <div class="col-sm-9">
                                <select class="chosen-select" id="it_class_opt" name="it_class_opt" data-placeholder="옵션선택">
                                    <option value="10">10팩</option>
                                    <option value="30">30팩</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 웹/cs </label>
                            <div class="col-sm-9">
                                <select class="chosen-select" id="sal_pl" name="sal_pl" data-placeholder="웹 과 cs">
                                    <option value="0">웹</option>
                                    <option value="1">CS</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="space-4"></div>
                        <div class="clearfix form-actions center">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="button" onclick="SubmitReg(this.form)"><i class="ace-icon fa fa-check bigger-110"></i> Submit</button> &nbsp; &nbsp; &nbsp;
                                <button class="btn" type="reset"> <i class="ace-icon fa fa-undo bigger-110"></i> Reset </button>
                            </div>
                        </div>                        
                    </form>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
         
            
            <div class="row">
                 <div class="col-xs-12">
                     <div >
                         <form name="reg_form"  action="daily_sales.php"  class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                                                      
                         </form>
                     </div>                     
                 </div>
             </div>            
         </div>
                  
    
</div>
    <div class="hr hr32 hr-dotted"></div>
                
    
    </div><!-- /.page-content -->
       
</div>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"><i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i></a>
    </div><!-- /.main-container -->

		<!-- basic scripts -->
                
                <script src="../js/pk_common.js"></script>
                <script>               
               // portfolio check
               function SubmitReg(form) {                   
                  
                    var str_ct_id = form.ct_id.value;
                    var str_it_id = form.it_id.value;
                    var str_it_name = form.it_name.value;
                    var str_it_class = form.it_class.value;
                    var str_it_class_opt = form.it_class_opt.value;
                    var str_sal_pl = form.sal_pl.value;


                   if(str_ct_id === ''){
                       alert("아이디를 선택 해주세요");
                       form.ct_id.focus();
                       return;
                   }

                                        
                    if(str_it_id === ''){
                        alert("제품번호를 입력해주세요");
                        form.it_id.focus();
                        return;
                    }
                    
                    if(str_it_name === ''){
                        alert("제품명을 입력해주세요");
                        form.it_name.focus();
                        return;
                    }
                                        
                    if(str_it_class === ''){
                        alert("제품구분을 선택 해주세요");
                        form.it_class.focus();
                        return;
                    }
                    
                    if(str_it_class_opt === ''){
                        alert("옵션을 선택 해주세요");
                        form.it_class_opt.focus();
                        return;
                    }
                    
                    if(str_sal_pl === ''){
                        alert("구분을 선택해주세요");
                        form.sal_pl.focus();
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
                            
                            $('#spinner1').ace_spinner({value:0,min:0,max:35,step:5, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
				.closest('.ace-spinner')
				.on('changed.fu.spinbox', function(){
					//alert($('#spinner1').val())
				}); 
                             $('#spinner2').ace_spinner({value:0,min:0,max:35,step:5, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
				.closest('.ace-spinner')
				.on('changed.fu.spinbox', function(){
					//alert($('#spinner1').val())
				}); 

                            //$('#spinner1').ace_spinner('disable').ace_spinner('value', 11);
                            //or
                            //$('#spinner1').closest('.ace-spinner').spinner('disable').spinner('enable').spinner('value', 11);//disable, enable or change value
                            //$('#spinner1').closest('.ace-spinner').spinner('value', 0);//reset to 0
                                
                                
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
