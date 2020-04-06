<?php

    require_once "/opt/apache/htdocs/tang/class/class_db.php";
    require_once "/opt/apache/htdocs/tang/class/class_cron.php";

//    $week_array = array(0,1,2,3,4,5,6);

    $date= date("Y-m-d");
    //today week
    echo date('w',strtotime($date));
    
    $obj = new class_cron();  
    
    $post_array = Array();
    $post_array[ta_status] = 102;
    
    $update = $obj->updateCron($post_array, $table = 'tang_order', $where = 'ta_status = 201');
    
    //UPDATE pyeongang SET ta_status = 201 WHERE ta_status = 101;

?>