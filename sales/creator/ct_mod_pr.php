<?php
    require_once "../autoload.php";
  
    $get_post = Array();

    $pass_hash =  password_hash($_REQUEST['passwd'], PASSWORD_DEFAULT); 
    $get_post[passwd] = $pass_hash;
    $ct_id = $_REQUEST[ct_id];
  
    $obj = new class_creator();

    //id redundancy check
    $update = $obj->updateCreator($get_post, $ct_id);

    if( gettype($update) == string){
        echo '<script type="text/javascript">                      
                window.location = "../common/svr_error.php?msg='.$update.'";
            </script>';
    }else {
        echo '<script type="text/javascript">                        
                window.location = "../creator/ct_mod.php";
            </script>';
    }
    
    
  