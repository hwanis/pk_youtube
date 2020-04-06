<?php
    require_once "../autoload.php";
  
    $get_post = Array();

    $ct_id = $_REQUEST[ct_id];
    $sal_date = $_REQUEST[sal_date];
    
    $get_post[sal_date] = $sal_date;
    $get_post[ct_id] = $ct_id;
    $get_post[ct_traffic] = $_REQUEST[sal_traffic];
    
    $up_post[ct_traffic] = $_REQUEST[sal_traffic];
    
    /*
    $up_post[ct_id] = $_REQUEST[ct_id];
    $up_post[sal_date] = $_REQUEST[sal_date];
    $up_post[ct_traffic] = $_REQUEST[sla_traffic];
    */
    $obj = new class_creator();
  
    //search - sal_date, ct_id   
    $list_cnt = $obj->trafficCount($sal_date, $ct_id);

    if($list_cnt[list_cnt] == 0){        
        //insert
        $insert = $obj->registTraffic($get_post);
        
        if( gettype($insert) == string){
            echo '<script type="text/javascript">                      
                    window.location = "../common/svr_error.php?msg='.$proc.'";
                </script>';
        }else {
            echo '<script type="text/javascript">                        
                     opener.parent.location.reload();                
                    window.close();
                </script>';
        }
        
    }else {
        //update
        $update = $obj->updateTraffic($up_post, $ct_id, $sal_date);
        
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
        
    }
    
     
    
    
    
  