<?php
    require_once "../autoload.php";
  
    $get_post = Array();

    $get_post[ct_id] = $_REQUEST[ct_id]; 
    $get_post[item_id] = $_REQUEST[it_id]; 
    $get_post[sal_from_date] = $_REQUEST[sal_from_date];
    $get_post[sal_to_date] = $_REQUEST[sal_to_date];
    $get_post[sal_rate] = $_REQUEST[rs_rate];
    $get_post[sal_rs] = $_REQUEST[sal_rs];
   //$get_post[login_cnt] = 'login_cnt + 1';
  
    //id redundancy check    
    $obj = new class_creator();

    //id redundancy check
//getCtRsDateDup($from_date, $to_date, $ct_id, $it_id)
    $list_cnt = $obj->getCtRsDateDup($_REQUEST[sal_from_date], $_REQUEST[sal_to_date], $_REQUEST[ct_id], $_REQUEST[it_id]);
 //   echo $list_cnt[cnt];
 //   exit;
    if($list_cnt[cnt] == 0){    
        $insert = $obj->registRsRate($get_post);
    }else{
         echo '<script type="text/javascript">              
                alert("날짜가 중복 되었습니다 \n 확인 해주시기 바랍니다.");                
            </script>';        
    }

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
    
    
  