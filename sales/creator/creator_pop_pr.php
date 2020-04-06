<?php
    require_once "../autoload.php";
  
    $get_post = Array();

    $get_post[ct_id] = $_REQUEST[ct_id]; 
    $get_post[ct_name] = $_REQUEST[ct_name]; 
    $get_post[rs_rate] = $_REQUEST[rs_rate];
    $get_post[ct_url] = $_REQUEST[ct_url];
   //$get_post[login_cnt] = 'login_cnt + 1';
  
    //id redundancy check

    $obj = new class_creator();

    //id redundancy check

    $insert = $obj->updateLoginInfo($get_post);

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
    
    
  