<?php
    require_once "../autoload.php";


    $get_post = Array();

    $get_post[ct_id] = $_REQUEST[item_ct_id];
    $get_post[it_id] = $_REQUEST[item_it_id];
    $get_post[it_name] = $_REQUEST[item_it_name];
    $get_post[it_class] = $_REQUEST[item_it_class];
    $get_post[it_class_opt] = $_REQUEST[item_it_class_opt];
    $get_post[sal_pl] = $_REQUEST[item_sal_pl];
   //$get_post[login_cnt] = 'login_cnt + 1';


    //id redundancy check
    $obj = new class_creator();


    //id redundancy check
//getCtRsDateDup($from_date, $to_date, $ct_id, $it_id)
    $list_cnt = $obj->registItem($get_post);
 //   echo $list_cnt[cnt];
 //   exit;


    if( gettype($list_cnt) == string){
        echo '<script type="text/javascript">                      
                window.location = "../common/svr_error.php?msg='.$list_cnt.'";
            </script>';
    }else {
        echo '<script type="text/javascript">              
                opener.parent.location.reload();                
                window.close();
                
            </script>';
    }



