<?php
    require_once "../autoload.php";
  
    $get_post = Array();
    
    $get_post[ct_id] = $_REQUEST[ct_id];
    $get_post[it_id] = $_REQUEST[it_id];   
    $get_post[it_class_opt] = $_REQUEST[it_class_opt];
    $get_post[act_url] = $_REQUEST[act_url];
    $get_post[st_date] = $_REQUEST[st_date];   
    $get_post[ed_date] = $_REQUEST[ed_date];
    
    $obj = new class_curd();
    
    $update = $obj->curdUpdate($get_post, $table = 'sal_schedule', $where = 'sal_no = '.$_REQUEST[sal_no]);

    if( gettype($update) == string){
        echo '<script type="text/javascript">                      
                window.location = "../common/svr_error.php?msg='.$proc.'";
            </script>';
        }else {
        echo '<script type="text/javascript">                        
                 opener.parent.location.reload();                
                window.close();
            </script>';
    }
