<?php

    //ta_status = 101 --> update pyeongang table   
    require_once "../autoload.php";
    require_once '../function/fnc_ship.php';
    
    $basename=basename($_SERVER["PHP_SELF"]);
    $reg_date = date("Y-m-d H:i:s");
    
    switch($_REQUEST[tag]){
        
        case 'u': 
            $res = UpdatePyeongang($_REQUEST);
            if( gettype($res) == string){
                echo '<script type="text/javascript">                      
                    window.location = "../common/svr_error.php?msg='.$res.'/'.$basename.'";
                </script>';
            }else {
                echo '<script type="text/javascript">             
                        alert("전송 되었습니다.");   
                        window.close();
                        opener.location.reload();
                    </script>';
            }   
            break;
        case 'i': 
            RegistTangOrder($_REQUEST); 
            RegistPrescription($_REQUEST);
            RegistPreScriptionDetail($_REQUEST);
            break;
        default: echo '9999'; break;
        
    }
    
   
   function UpdatePyeongang($req_array){
       
       $py_array = Array();

        $order_array = Array();
 
    //    $order_array[od_number] = $_REQUEST[od_number];
    //    $order_array[hsid] = $_REQUEST[hsid];
    //    $order_array[hsid_sub] = $_REQUEST[hsid_sub];
   //     $order_array[br_code] = $_REQUEST[yynumber];
    //    $order_array[cs_name] = $_REQUEST[name];
    //    $order_array[cs_jumin] = $_REQUEST[jumin];
       
        $order_array[c_phone] = $_REQUEST[tel_1].'-'.$_REQUEST[tel_2].'-'.substr($_REQUEST[tel_3], 0,4);  
        $order_array[h_phone] = $_REQUEST[hp_1].'-'.$_REQUEST[hp_2].'-'.substr($_REQUEST[hp_3], 0,4);
        $order_array[address] = $_REQUEST[address];
    //    $order_array[tname] = $_REQUEST[tname];
    //    $order_array[tpaek] = $_REQUEST[tpaek];
        //$post_array[tdang] = $_REQUEST[tdang];
    //    $order_array[tmemo] = $_REQUEST[tmemo];  
        $order_array[delivery_date] = $_REQUEST[reserve_date_1];
    //    $order_array[ta_status] = 102;
     //   $order_array[modify_date] = $reg_date;
     //   $order_array[ta_delivery] = $_REQUEST[ta_delivery];
    //    $order_array[treat_date] = $_REQUEST[jakupdate];
     //   $order_array[delivery_date] = $_REQUEST[reserve_date_1];
    
        //상품 발송일 가져오기        
        $prepare_date = GetRecord($table = 'sch_delivery', $where = " d_send = '$_REQUEST[reserve_date_1]' ");         
        $order_array[prepare_date] = $prepare_date[d_prepare];
        
         //발송일에 대한 준비일
        $order_array[prepare_date] = $prepare_date[d_prepare];        
        
        //처방일의 기본 발송일과 넘어온 발송일이 다르면 예약
        //처방일의 기본 발송일: $_REQUEST[send_date]
         //request된 발송일 $_REQUEST[reserve_date_1]
        if($_REQUEST[send_date] == $_REQUEST[reserve_date_1]){
             $order_array[ta_status] = 102;
        }else{
             $order_array[ta_status] = 801;            
        }
        
        $obj = new class_shipTa();

        // excel file save   
       $get_file_array = Array();
     
        if($_FILES["attach_file"]["name"][0] != ''){
            
            foreach($_FILES["attach_file"]["name"] as $f => $f_name){

               $f_name = fileRename($_FILES["attach_file"]["name"][$f]); //$_FILES["attach_file"]["name"][$f];
               $f_size = $_FILES["attach_file"]["size"][$f];           
               $u_name = explode('.', $f_name);
               $u_name = time().$f.'.'.$u_name[1];

               //$u_file_base = '../files_ship/';
               //$u_file = $u_file_base.$u_name.'/'.$f_size.'<br>';

                fileUpload($_FILES["attach_file"]["name"][$f], $_FILES["attach_file"]["size"][$f], $_FILES["attach_file"]["tmp_name"][$f], $f_name);

                $get_file_array[od_number] = $_REQUEST[od_number];     
                $get_file_array[file_name] = $f_name;     
                $get_file_array[file_o_name] = $_FILES["attach_file"]["name"][$f];     
                $get_file_array[file_size] =  $_FILES["attach_file"]["size"][$f];    
                $get_file_array[register] =  $_REQUEST[register];    

               // insert portfolio
               $insert = $obj->registUpExlFile($get_file_array);

           }
            
        }
       
        
         
        
     //   $order_array[register] = $_REQUEST[register];
        
        //ArrayRegist($order_array, $table = 'tang_order');
      //  $objs = new class_curd();   
    //    $r_count = RecordCount($table = 'tang_order', $where = 'od_number ='.$_REQUEST[od_number]);
          
      //  exit;
        ArrayUpdate($order_array, $table = 'tang_order', $where = 'od_number ='.$_REQUEST[od_number]);
       
    }
    
    

    function RegistTangOrder($req_array){
        
        $py_array = Array();

        $order_array = Array();
 
        $order_array[od_number] = $_REQUEST[od_number];
        $order_array[hsid] = $_REQUEST[hsid];
        $order_array[hsid_sub] = $_REQUEST[hsid_sub];
        $order_array[br_code] = $_REQUEST[yynumber];
        $order_array[cs_name] = $_REQUEST[name];
        $order_array[cs_jumin] = $_REQUEST[jumin];
       
        $order_array[c_phone] = $_REQUEST[tel_1].'-'.$_REQUEST[tel_2].'-'.substr($_REQUEST[tel_3], 0,4);  
        $order_array[h_phone] = $_REQUEST[hp_1].'-'.$_REQUEST[hp_2].'-'.substr($_REQUEST[hp_3], 0,4);
        $order_array[address] = $_REQUEST[address];
        $order_array[tname] = $_REQUEST[tname];
        $order_array[tpaek] = $_REQUEST[tpaek];
        //$post_array[tdang] = $_REQUEST[tdang];
        $order_array[tmemo] = $_REQUEST[tmemo];  
        $order_array[delivery_date] = $_REQUEST[reserve_date_1];      
     //   $order_array[modify_date] = $reg_date;
        $order_array[ta_delivery] = $_REQUEST[ta_delivery];
        $order_array[treat_date] = $_REQUEST[jakupdate];
        $order_array[delivery_date] = $_REQUEST[reserve_date_1];
    
        //상품 발송일 가져오기        
        $prepare_date = GetRecord($table = 'sch_delivery', $where = " d_send = '$_REQUEST[reserve_date_1]' ");         
        $order_array[prepare_date] = $prepare_date[d_prepare];
        
        //발송일에 대한 준비일
        $order_array[prepare_date] = $prepare_date[d_prepare];        
        
        //처방일의 기본 발송일과 넘어온 발송일이 다르면 예약
        //처방일의 기본 발송일: $_REQUEST[send_date]
         //request된 발송일 $_REQUEST[reserve_date_1]
        if($_REQUEST[send_date] == $_REQUEST[reserve_date_1]){
             $order_array[ta_status] = 102;
        }else{
             $order_array[ta_status] = 801;            
        }
        
        
        $order_array[register] = $_REQUEST[register];
        
        //ArrayRegist($order_array, $table = 'tang_order');
        $objs = new class_curd();   
        $r_count = RecordCount($table = 'tang_order', $where = 'od_number ='.$_REQUEST[od_number]);
     
        if($r_count[r_count] == 0){
            echo'<script>alert("insert")</script>';
            ArrayRegist($order_array, $table = 'tang_order');
        }else{        
            echo'<script>alert("update")</script>';
            foreach($order_array as $k=>$v){
                
                echo $k.'=>'.$v.'<br>';
                
            }
            exit;
            ArrayUpdate($order_array, $table = 'tang_order', $where = 'od_number ='.$_REQUEST[od_number]);
        }
        
    }
    
    function RegistPrescription($req_array){
        
         $pres_array = Array();
        $pres_array[od_number] = $_REQUEST[od_number];
        $pres_array[hsid] = $_REQUEST[hsid];
        $pres_array[hsid_sub] = $_REQUEST[hsid_sub];
        $pres_array[dc_name] = $_REQUEST[dc_name];
        $pres_array[pr_name] = $_REQUEST[pr_name];
        $pres_array[pre_name] = $_REQUEST[pre_name];
        $pres_array[take_date] = $_REQUEST[take_date];
        $pres_array[packs_quantity] = $_REQUEST[packs_quantity];
        $pres_array[br_code] = $_REQUEST[yynumber];

        if($_REQUEST[tot_packs] == ''){
            $pres_array[tot_packs] = 0;
        }else{
            $pres_array[tot_packs] = $_REQUEST[tot_packs];
        }

        if($_REQUEST[packs] == ''){
            $pres_array[packs] = 0;
        }else{
            $pres_array[packs] = $_REQUEST[tot_packs];
        }

     //   $pres_array[reg_date] = $reg_date;
        $pres_array[register] = $_REQUEST[register];
        $pres_array[treat_date] = $_REQUEST[jakupdate];
        
       // ArrayRegist($pres_array, $table = 'prescription');
       
        $r_count = RecordCount($table = 'prescription', $where = 'od_number ='.$_REQUEST[od_number]);

        if($r_count[r_count] == 0){
            ArrayRegist($pres_array, $table = 'prescription');
        }else{        
            ArrayUpdate($pres_array, $table = 'prescription', $where = 'od_number ='.$_REQUEST[od_number]);
        }
        
    }
    
    function RegistPreScriptionDetail($req_array){
        
        $pres_detail_array = Array();
      
        $stuff_count = $_REQUEST[stuff_count];
        
        $pres_detail_array[od_number] = $_REQUEST[od_number];
        $pres_detail_array[hsid] = $_REQUEST[hsid];
        $pres_detail_array[hsid_sub] = $_REQUEST[hsid_sub];

        for($i=1;$i<=$stuff_count;$i++){

            $pres_detail_array[st_no] = $_REQUEST[st_no_.$i];             
            $pres_detail_array[packs_quantity] = $_REQUEST[tot_packs_.$i];
            $pres_detail_array[register] = $_REQUEST[register];
            $pres_detail_array[br_code] = $_REQUEST[yynumber];
            $pres_detail_array[treat_date] = $_REQUEST[jakupdate];
          //  $pres_detail_array[pres_memo_.$i] = $_REQUEST[pres_memo_.$i];
          //   $pres_detail_array[packs_quantity_.$i] = $_REQUEST[packs_quantity_.$i];
          //   
            //call insert
          //  ArrayRegist($pres_detail_array, $table = 'prescription_detail');

      //  if($r_count[r_count] == 0){
          //  ArrayRegist($pres_detail_array, $table = 'prescription_detail');
            
          //   $r_count = RecordCount($table = 'prescription_detail', $where = 'od_number ='.$_REQUEST[od_number]);

         //   if($r_count[r_count] == 0){
                ArrayRegist($pres_detail_array, $table = 'prescription_detail');
         //   }else{        
             //   ArrayUpdate($pres_detail_array, $table = 'prescription_detail', $where = 'od_number ='.$_REQUEST[od_number]);
          //  }
    //    }else{
      //      ArrayUpdate($pres_detail_array, $table = 'prescription_detail', $where = 'od_number ='.$_REQUEST[od_number]);
        }
    }
  
    //update function
    function ArrayUpdate($get_array, $table, $where){
        
        $obj = new class_curd();
        $update = $obj->curdUpdate($get_array, $table, $where);
       
        return $update;
        
    }
        
    //insert function
    function ArrayRegist($get_array, $table){
             
        $obj = new class_curd();
        $insert = $obj->curdInsert($get_array, $table);        
    }
    

//get record count
    function RecordCount($table, $where ){       
        $obj = new class_curd();              
        $r_count = $obj->curdRecordCount($table, $where);   
      
        return $r_count;          
    }   
    
    function GetRecord($table, $where){
        
        $obj = new class_curd();
        $r_record = $obj->curdRecord($table, $where);
        
        return $r_record;
        
    }


    // 적용: insert, ta_status = 102


    //ta_status = 102 --> update tang_order table