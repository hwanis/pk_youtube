<?php
       require_once '../autoload.php'; 
  //  echo $basename = basename($_SERVER["PHP_SELF"]);

    if($req_sal_no){ 
        $req_sal_no = $_REQUEST[sal_no];        
    }else{          
        
    }
            
    $obj_creator = new class_creator();        
    $ct_dd_list =$obj_creator->getCreatorRsList();        
    
    $obj_pkmall = new class_sales();
    $ct_it_list = $obj_pkmall->getCtItemList();    
    
    //get schedule
    $obj_curd = new class_curd();
    
    $li_id = $_REQUEST[sal_no];
    $table = 'sal_schedule';
    $where = 'sal_no = '.$_REQUEST[sal_no];
    
    $get_sch = $obj_curd ->curdRecord($table, $where);

    $it_list = $obj_creator->getCreatorItemList($req_s_id = '');    
  
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
    <script src="../js/jquery-1.9.1.min.js"></script>
            <script type="text/javascript" src="../js/jquery-ui-1.9.2.min.js"></script>
    <script type="text/javascript">

        function get_item( ct_id )
        {            
           if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            
            xmlhttp.onreadystatechange = function() {
              
                if(xmlhttp.readyState == 4 && xmlhttp.status == 200){                    
                     document.getElementById("div_item").innerHTML = xmlhttp.responseText;
                 }
            }

            xmlhttp.open("GET","../ajax/item.ajax.php?ct_id="+ct_id, true);
            xmlhttp.send();
        }

    </script>
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
                    <form name="login_form" action="sal_report_pop_pr.php"  class="form-horizontal" role="form" enctype="multipart/form-data" >
                        <input type="hidden" name="sal_date" value="<?=$_REQUEST[sal_date]?>" >
                        <input type="hidden" name="ct_id" value="<?=$_REQUEST[ct_id]?>" >
                        <!-- #section:elements.form -->
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 인인콜 </label>
                            <div class="col-sm-5">
                                <input type="text" id="form-field-1" name="cs_traffic" placeholder="인입콜을 입력 하세요" class="col-xs-10 col-sm-12"  maxlength="50"  value="<?=$_REQUEST[cs_traffic]?>"  />
                            </div>                           
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 링크인입 </label>
                            <div class="col-sm-5">
                                <input type="text" id="form-field-1" name="web_traffic" placeholder="링크인인을 입력 하세요" class="col-xs-10 col-sm-12"  maxlength="50"  value="<?=$_REQUEST[web_traffic]?>"  />
                            </div>                           
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 장바구니 </label>
                            <div class="col-sm-5">
                                <input type="text" id="form-field-1" name="cart_qty" placeholder="장바구니를 입력 하세요" class="col-xs-10 col-sm-12"  maxlength="50"  value="<?=$_REQUEST[cart_qty]?>"  />
                            </div>                           
                        </div>
                       <!--
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 제품 </label>
                            <div class="col-sm-5">
                                <select class="chosen-select form-control" id="form-field-select-3" name="it_id" data-placeholder="Choose a Creator...">
                                    <?php                                                 
                                        for($i=0;$i<count($it_list);$i++){
                                            
                                            switch($it_list[$i][sal_pl]){
                                                case 0: $cs_w = 'WEB'; break;
                                                case 1: $cs_w = 'CS'; break;
                                            }                                            
                                    ?>
                                        <option value=""> </option>
                                    <?php
                                        if($r_ct_id == $it_list[$i][it_id]){
                                    ?>
                                        <option value="<?=$it_list[$i][it_id]?>" selected><?=$it_list[$i][it_name]?></option>                                                           
                                    <?php
                                        }else{
                                    ?>
                                        <option value="<?=$it_list[$i][it_id]?>" >
                                            <?=$it_list[$i][it_name]?>(<?=$it_list[$i][ct_id]?>/<?=$it_list[$i][it_class_opt]?>/<?=$cs_w?>)
                                        </option>        
                                    <?php                                                        
                                        }
                                    }
                                    ?>
                                </select> 
                            </div>                           
                        </div>
                        -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 주문번호 </label>
                            <div class="col-sm-5">
                                <input type="text" id="form-field-1" name="od_id" placeholder="주문번호를 입력 하세요" class="col-xs-10 col-sm-12"  maxlength="50"  value="<?=$_REQUEST[cart_qty]?>"  />
                            </div>                           
                        </div>
                       <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 취소 수량 </label>
                            <div class="col-sm-5">
                                <input type="text" id="form-field-1" name="cn_qty" placeholder="취소 수량을 입력 하세요" class="col-xs-10 col-sm-12"  maxlength="50"  value="<?=$_REQUEST[cart_qty]?>"  />
                            </div>                           
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 취소 금액 </label>
                            <div class="col-sm-5">
                                <input type="text" id="form-field-1" name="cn_price" placeholder="취소 금액을 입력 하세요" class="col-xs-10 col-sm-12"  maxlength="50"  value="<?=$_REQUEST[cart_qty]?>"  />
                            </div>                           
                        </div>
                        
                        <div class="space-4"></div>                        
                        <div class="clearfix form-actions">
                            <div style="text-align: center" >
                                 <button class="btn btn-message" type="button" name="btnSubmit" onclick="javascript:SubmitReg(this.form)">                                                 
                                    <i class="ace-icon fa fa-check smaller-60"></i>Submit
                                </button> 
                                <button class="btn btn-message" type="reset"> <i class="ace-icon fa fa-undo bigger-110"></i> Reset </button>
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

        var str_cs_traffic = form.cs_traffic.value;
        var str_web_traffic = form.web_traffic.value;                
        var str_cart_qty = form.cart_qty.value;
/*

        if (str_cs_traffic === ''){
            alert("인입콜을 입력 해주세요.");
            form.cs_traffic.focus();
            return;
        }

        if (str_web_traffic === ''){
            alert("링크인입을 입력 해주세요.");
            form.web_traffic.focus();
            return;
        } 

        if (str_cart_qty === ''){
             alert("장바구니를 입력해 해주세요.");
            form.cart_qty.focus();
            return;
        }
*/
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

                          $('#date-timepicker1').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss'});
                            $('#date-timepicker2').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss'});

                            $('#date-timepicker1').datetimepicker().next().on(ace.click_event, function(){

                                    $(this).prev().focus();
                            });
                            $('#date-timepicker2').datetimepicker().next().on(ace.click_event, function(){
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
