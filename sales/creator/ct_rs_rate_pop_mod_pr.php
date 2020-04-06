<?php
    require_once "../autoload.php";
  
    $get_post = Array();

    $get_post[ct_id] = $_REQUEST[ct_id]; 
    $get_post[item_id] = $_REQUEST[item_id]; 
    $get_post[sal_from_date] = $_REQUEST[sal_from_date];
    $get_post[sal_to_date] = $_REQUEST[sal_to_date];
    $get_post[sal_rate] = $_REQUEST[rs_rate];
    $get_post[sal_rs] = $_REQUEST[sal_rs];

    $obj = new class_creator();

    $insert = $obj->updateCtRsRatePopMod($get_post, $_REQUEST[rate_id]);

    if( gettype($insert) == string){
        echo '<script type="text/javascript">                      
                window.location = "../common/svr_error.php?msg='.$insert.'";
            </script>';
    }else {
        echo '<script type="text/javascript">              
                opener.parent.location.reload();                
                window.close();
                
            </script>';
    }
    
    
  