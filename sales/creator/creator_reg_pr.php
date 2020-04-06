<?php
    require_once "../autoload.php";
  
    $get_post = Array();

    $get_post[ct_name] = $_REQUEST[ct_name];
    $get_post[ct_id] = $_REQUEST[ct_id];
    $pass_hash =  password_hash($_REQUEST['passwd'], PASSWORD_DEFAULT); 
    $get_post[passwd] = $pass_hash;
    $get_post[rs_rate] = $_REQUEST[rs_rate];
    $get_post[ct_url] = $_REQUEST[ct_url];
 
    $obj = new class_creator();

    //id redundancy check
    $insert = $obj->registCreator($get_post);

    if( gettype($insert) == string){
        echo '<script type="text/javascript">                      
                window.location = "../common/svr_error.php?msg='.$insert.'";
            </script>';
    }else {
        echo '<script type="text/javascript">                        
                window.location = "creator_list.php";
            </script>';
    }
    
    
  