<?php
    // class_cron 사용 하기
    
    require_once "/opt/apache/htdocs/sales/class/class_db.php";
    require_once "/opt/apache/htdocs/sales/class/class_creator.php";
    require_once "/opt/apache/htdocs/sales/class/class_sales.php";
    require_once "/opt/apache/htdocs/sales/class/class_cron.php";
    require_once "/opt/apache/htdocs/sales/class/class_curd.php";

    $obj = new class_cron();      //real db
   
    $td_date = date("Y-m-d");    
   // $td_date = '2020-03-25';    
    // 신의 한수
    $it_id = "'1595421782', '1573177193', '1580192523', '1583711913', '1584495978','1584077837' ";  // 1573177193순1595421782오
    $arr_it_id = Array('1573177193', '1580192523', '1583711913', '1584077837',  '1584495978', '1595421782', '1585210863');    
    
    for($i=0; $i<count($arr_it_id); $i++){   
        $list_s = $obj->getDailyCrData_s($td_date, $arr_it_id[$i]); 

        $get_post = Array();
        $get_post[sal_date]    = $td_date;
        $get_post[ct_id]       = 'pk_tlsdmlgkstn';
        $get_post[it_id]        = $arr_it_id[$i];
        $get_post[d_tot_price] = $list_s[0][tot_price];
        $get_post[d_tot_qty]   = $list_s[0][tot_qty];
        $get_post[od_suc]      = $list_s[0][cnt];
        $get_post[od_cnc]      = 0;

        registDailySales($get_post);
        sleep(2);
    }
   // exit;
    
        /*
    // 신의 한 수 구전 녹용
    $list_s = $obj->getDailyCrData_s($td_date, '1595421782'); 

    $get_post = Array();
    $get_post[sal_date]    = $td_date;
    $get_post[ct_id]       = 'pk_tlsdmlgkstn';
    $get_post[it_id]        = '1595421782';
    $get_post[d_tot_price] = $list_s[0][tot_price];
    $get_post[d_tot_qty]   = $list_s[0][tot_qty];
    $get_post[od_suc]      = $list_s[0][cnt];
    $get_post[od_cnc]      = 0;

    sleep(2);
    
    // 신의 한 수 순

    registDailySales($get_post);

    $list_t = $obj->getDailyCrData_s($td_date, '1573177193'); 

    $get_post = Array();
    $get_post[sal_date]    = $td_date;
    $get_post[ct_id]       = 'pk_tlsdmlgkstn';
    $get_post[it_id]        = '1573177193';
    $get_post[d_tot_price] = $list_t[0][tot_price];
    $get_post[d_tot_qty]   = $list_t[0][tot_qty];
    $get_post[od_suc]      = $list_t[0][cnt];
    $get_post[od_cnc]      = 0;

    sleep(2);

    registDailySales($get_post);

    // 신의 한 수 금지옥엽
    $list_t = $obj->getDailyCrData_s($td_date, '1580192523'); 

    $get_post = Array();
    $get_post[sal_date]    = $td_date;
    $get_post[ct_id]       = 'pk_tlsdmlgkstn';
    $get_post[it_id]        = '1580192523';
    $get_post[d_tot_price] = $list_t[0][tot_price];
    $get_post[d_tot_qty]   = $list_t[0][tot_qty];
    $get_post[od_suc]      = $list_t[0][cnt];
    $get_post[od_cnc]      = 0;

    sleep(2);
    
    
    registDailySales($get_post);

    // 신의 한 수 복세편살
    $list_t = $obj->getDailyCrData_s($td_date, '1583711913'); 

    $get_post = Array();
    $get_post[sal_date]    = $td_date;
    $get_post[ct_id]       = 'pk_tlsdmlgkstn';
    $get_post[it_id]        = '1583711913';
    $get_post[d_tot_price] = $list_t[0][tot_price];
    $get_post[d_tot_qty]   = $list_t[0][tot_qty];
    $get_post[od_suc]      = $list_t[0][cnt];
    $get_post[od_cnc]      = 0;

    sleep(2);
    
    registDailySales($get_post);
            */
    //인터넷 판매 creator
    $obj_ct = new class_creator();  //dev db 
    $ct_list = $obj_ct->getCreator();
    
    for($i=0;$i<count($ct_list);$i++){     
        if($ct_list[$i][sal_pl] == 0 || $ct_list[$i][ct_auth] == 1 || $ct_list[$i][ct_use] == 1){    

            $list = $obj->getDailyCrData($td_date, $ct_list[$i][ct_id], $ct_list[$i][it_id]);

            $get_post[sal_date]     = $td_date;    
            $get_post[ct_id]        = $ct_list[$i][ct_id];
            $get_post[it_id]        = $ct_list[$i][it_id];
            $get_post[d_tot_price]  = $list[0][tot_price];
            $get_post[d_tot_qty]    = $list[0][tot_qty];
            $get_post[od_suc]       = $list[0][cnt];
            $get_post[od_cnc]       = 0;

            registDailySales($get_post);   
            sleep(2);
        }                
    }

    function registDailySales($get_post){

        $obj_curd = new class_curd();

        $insert = $obj_curd->curdInsert($get_post, $table = 'sal_daily_sales');

        if( gettype($insert) == string){
            echo '<script type="text/javascript">                      
                    window.location = "../common/svr_error.php?msg='.$insert.'";
                </script>';
        }
    }