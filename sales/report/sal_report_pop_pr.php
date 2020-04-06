<?php
    require_once "../autoload.php";
  
    $obj = new class_curd();
    
    //count
    $table = " sal_traffic ";
    $where = " sal_date = '$_REQUEST[sal_date]' AND ct_id = '$_REQUEST[ct_id]'";
    
    $r_count = $obj->curdRecordCount($table, $where);
    
    if($r_count[r_count]>0){
        
        $get_post = Array();
    
        $get_post[cs_traffic] = $_REQUEST[cs_traffic];
        $get_post[web_traffic] = $_REQUEST[web_traffic];   
        $get_post[cart_qty] = $_REQUEST[cart_qty];
        
        $tr_proc = $obj->curdUpdate($get_post, $table = 'sal_traffic', $where = "sal_date = '$_REQUEST[sal_date]' AND ct_id='$_REQUEST[ct_id]'");
        
        /*
        $cn_array = Array();
        $cn_array[it_id] = $_REQUEST[it_id];
        $cn_array[od_id] = $_REQUEST[od_id];
        $cn_array[cn_qty] = $_REQUEST[cn_qty];
        $cn_array[cn_price] = $_REQUEST[cn_price];
        
        $cn_proc = $obj->curdUpdate($cn_array, $table = 'od_cancel', $where = "sal_date = '$_REQUEST[sal_date]' AND od_id='$_REQUEST[od_id]'");
        */
        //update od_cancel
        
    }else{
        
        $get_post = Array();
    
        $get_post[sal_date] = $_REQUEST[sal_date];
        $get_post[ct_id] = $_REQUEST[ct_id];        
        $get_post[ct_traffic] = $_REQUEST[ct_traffic];
        $get_post[cs_traffic] = $_REQUEST[cs_traffic];
        $get_post[web_traffic] = $_REQUEST[web_traffic];   
        $get_post[cart_qty] = $_REQUEST[cart_qty];
        
        $tr_proc = $obj->curdInsert($get_post, $table = 'sal_traffic');
        
        /*
        //insert od_cancel
        $cn_array = Array();
        $cn_array[sal_date] = $_REQUEST[sal_date];
        $cn_array[it_id] = $_REQUEST[it_id];
        $cn_array[od_id] = $_REQUEST[od_id];
        $cn_array[cn_qty] = $_REQUEST[cn_qty];
        $cn_array[cn_price] = $_REQUEST[cn_price];
        
        $cn_proc = $obj->curdInsert($cn_array, $table = 'od_cancel');
         * 
         */
        
    }
    
    if( gettype($tr_proc) == string){
        echo '<script type="text/javascript">                      
                window.location = "../common/svr_error.php?msg='.$tr_proc.'";
            </script>';
        }else {
        echo '<script type="text/javascript">                        
                 opener.parent.location.reload();                
                window.close();
            </script>';
    }
    /*
    if( gettype($cn_proc) == string){
        echo '<script type="text/javascript">                      
                window.location = "../common/svr_error.php?msg='.$tr_proc.'";
            </script>';
        }else {
        echo '<script type="text/javascript">                        
                 opener.parent.location.reload();                
                window.close();
            </script>';
    }
     * 
     */
