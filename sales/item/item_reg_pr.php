<?php
    require_once "../autoload.php";
  
    $get_post = Array();
    
    $get_post[ct_id] = $_REQUEST[ct_id];
    $get_post[it_id] = $_REQUEST[it_id];   
    $get_post[it_opt] = $_REQUEST[it_class_opt];
    
    $arr_it_name = explode('(', $_REQUEST[it_name]);

    switch($arr_it_name[0]){
        
        case '구전녹용':  $get_post[it_name] = '구전녹용'; $get_post[it_class] = 100; break;
        case '구전녹용 순':  $get_post[it_name] = '구전녹용 순'; $get_post[it_class] = 200; break;
        case '금지옥엽':  $get_post[it_name] = '금지옥엽'; $get_post[it_class] = 300; break;
        case '당금아기':  $get_post[it_name] = '당금아기'; $get_post[it_class] = 400; break;
        case '복세편살':  $get_post[it_name] = '복세편살'; $get_post[it_class] = 500; break;    
        case '구전녹용 진':  $get_post[it_name] = '구전녹용 진'; $get_post[it_class] = 600; break;
    
    }       
    
    $get_post[it_class_opt] = $_REQUEST[it_class_opt];
    $get_post[sal_pl] = $_REQUEST[sal_pl];


    $obj = new class_curd();
    
    $insert = $obj->curdInsert($get_post, $table = 'sal_item');    

    if( gettype($insert) == string){
        echo '<script type="text/javascript">                      
                window.location = "../common/svr_error.php?msg='.$insert.'";
            </script>';
    }else {
        echo '<script type="text/javascript">                        
                window.location = "item_list.php";
            </script>';
    }
 