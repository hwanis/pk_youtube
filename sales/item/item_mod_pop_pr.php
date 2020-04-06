<?php
    require_once "../autoload.php";


    $get_post = Array();

    $get_post[ct_id] = $_REQUEST[ct_id];
    $get_post[it_id] = $_REQUEST[it_id];
    $get_post[it_name] = $_REQUEST[it_name];
    $get_post[it_class] = $_REQUEST[it_class];
    $get_post[it_class_opt] = $_REQUEST[it_class_opt];
    $get_post[sal_pl] = $_REQUEST[sal_pl];

/*
echo $_REQUEST[ct_id];
*/

    $obj = new class_curd();

    $update = $obj->curdUpdate($get_post, $table = 'sal_item', $where = 'it_id = '.$_REQUEST[it_id]);

    if( gettype($update) == string){
    echo '<script type="text/javascript">                      
                window.location = "../common/svr_error.php?msg='.$update.'";
            </script>';
    }else {
    echo '<script type="text/javascript">                        
                 opener.parent.location.reload();                
                window.close();
            </script>';
    }

    
  