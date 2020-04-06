<?php

//require_once '../lib/JSON.php';

class class_shipTa extends class_db {
	
    public function __construct(){

        $this->gw_db_ship_connection();
    }

    public function registUpExlFile( $get_post ){		
        try{	
                foreach( $get_post as $key=>$value){
                    $this->offsetSet($key, $value);
                }
                $insert = $this->insert( 'attatch_file' );	
                return $insert;
        } catch(Exception $ex){		
               $ex->getFile();
               $ex->getMessage();
        }				
    }		
        
    //save excel upload file to db
    public function registUploadTangList($get_xls_array, $c_size, $doc_date){               
        
        try{
            /*
            0  $up_id_array[$i], 1  $branch_array[$i], 2  $cs_name_array[$i], 3  $contact_1_array[$i], 4  $contact_2_array[$i], 5  $post_no_array[$i], 6  $addr_array[$i], 
            7  $prescription_array[$i], 8  $ta_pack_array[$i],  9  $ta_box_array[$i], 10 $reserve_date_array[$i], 11 $contents_array[$i]  
            */
          
          //  echo 'a :'.$get_xls_array[2][0];
            for($i=2;$i<count($get_xls_array);$i++){   
                
                if((int)$get_xls_array[$i][5]<10000){                    
                    (string)$post_no = '0'.$get_xls_array[$i][5];                   
                }else{                    
                    $post_no = $get_xls_array[$i][5];                    
                }    
                              
                $qeury_str = "          
                        INSERT INTO ta_list
                        SET up_id = ".$get_xls_array[$i][0].",
                            branch = '".$get_xls_array[$i][1]."',
                            cs_name = '".$get_xls_array[$i][2]."',
                            contact_1 = '".$get_xls_array[$i][3]."',
                            contact_2 = '".$get_xls_array[$i][4]."',
                            post_no = '".$post_no."',
                            addr = '".$get_xls_array[$i][6]."',
                            prescription = '".$get_xls_array[$i][7]."',
                            ta_pack = ".$get_xls_array[$i][8].",                          
                            contents = '".$get_xls_array[$i][11]."',
                            doc_date = '".$doc_date."'
                         ";                  
                    //  ta_box = ".$get_xls_array[$i][9].",
                    //reserve_date = ".$get_xls_array[$i][10].",
                $ret = $this->query($qeury_str);
              //  return $ret;
            }
                        
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }
        
    }
    
    //get branch excel file upload list
    public function getUploadTangList_s($page_no, $page_list_no, $where, $branch, $tag){
        if($page_no == 1){            
            $start_page = 0;
        }else{
            $start_page = $page_no*$page_list_no-$page_list_no;
        }
        $end_page = $page_list_no;
        
        try{

            switch($tag){                
                case 'list': $query = "SELECT * FROM pyeongang WHERE $where AND ta_status = 201 AND yyname = $branch  ORDER BY hsid DESC LIMIT $start_page, $end_page "; break;
                case 'cnt':$query = "SELECT * FROM pyeongang WHERE $where AND ta_status = 201 AND yyname = $branch  ORDER BY hsid DESC "; break;                
            }
            
           //echo $query.'<br>';
                        
            $result =  $this->query($query);
            if(gettype($result) == string){
                echo $result;
            }
            $resultRow = Array();
            while($row = $result->fetch_assoc())
            {
                $resultArray = $row;
                array_push($resultRow,$resultArray);
            }
            return $resultRow;
            
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }        
    }
    
    //firebird connect
     public function getTangList($st_date, $task, $branch, $ta_status){
        
         //echo $st_date.'<br>';
         //echo $task.'<br>';
         //echo $branch.'<br>';
        
        if($branch != ''){
         //   $branch_str = " AND yynumber = '$branch'";
         }else{
          //   $branch_str = '';             
         }          
         
        if($st_date == "") {
             $st_date = "";             
             $and = "";
         }else{
            $st_date = " jakupdate = '$st_date' ";             
            $and = " AND ";
         };         
         
        if($st_date == '' && $task == ''){
             $where = "";
         }else{
            $where = " WHERE ";
        }
         
         switch($task){             
            case 'history': 
               // $status = " ta_status = 201  $branch_str "; 
                 $status = " ta_status > 200 and ta_status < 299 $branch_str "; 
                $query = "SELECT * FROM pyeongang  $where $status ORDER BY hsid DESC";   
                
                break;
            case 'list':  
                $status = " ta_status = $ta_status $branch_str "; 
               //  $status = " delivery_date = '".date('Y-m-d')."'".$branch_str ; 
                $query = "SELECT hsid, yynumber, yyname,  
                            CASE WHEN yyname = 1001  THEN '서초'
                                 WHEN yyname = 1002  THEN '명동'
                                 WHEN yyname = 1003  THEN '안산'
                                 WHEN yyname = 1004  THEN '산본'
                                 WHEN yyname = 1005  THEN '대구'
                                 WHEN yyname = 1006  THEN '부산'
                            ELSE '확인' END yyname_kor,
                            name, jumin, jakupdate, 
                            tel, handphone, address, tname, tpaek, tdang,
                            tdate, tmemo, edtime, delivery_date, ta_delivery,
                            ta_status, modfy_date, mod_cnt, register,
                            delivery_num, CONVERT(qrp USING euckr) qrp_c
                        FROM pyeongang  $where $status ORDER BY edtime DESC";   
                break;
            case 'reserve':  
                $status = " ta_status =  301  $branch_str "; 
                 $query = "
                            SELECT * FROM pyeongang WHERE ta_status = 301 AND yyname = $branch ORDER BY delivery_date ASC
                        ";   
                // echo $query;
                break;
            case 'end':  
                $status = " ta_status =  301  "; 
                 $query = "SELECT * FROM pyeongang $where ".date('Y-m-d')." AND $status ORDER BY hsid DESC";   
                break;          
            case 'cancel':  
                $status = " ta_status =  901  "; 
                 $query = "SELECT * FROM pyeongang $where $status $branch_str ORDER BY hsid DESC";   
                break;     
            default:  
                $status = " ta_status is null "; 
                 $query = "SELECT * FROM pyeongang $where ".date('Y-m-d')." AND $status ORDER BY hsid DESC";   
                break;
         }
        
        try{            
         //   $query = "SELECT * FROM pyeongang $where ".date('Y-m-d')." AND $status ORDER BY hsid DESC";           
            //$query = "SELECT * FROM pyeongang WHERE  $status ORDER BY hsid DESC";                   
          
            $result =  $this->query($query);
            if(gettype($result) == string){
                echo $result;
            }
            $resultRow = Array();
            while($row = $result->fetch_assoc())
            {
                $resultArray = $row;
                array_push($resultRow,$resultArray);
            }
            return $resultRow;
            
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }        
    }
    
    
    //get d-day send list
    public function getDeliverySendList(){
        
        try{            
            $query = "SELECT * FROM tang_order WHERE ta_status = 102 ORDER BY od_number DESC";           
          //  echo $query.'<br>';                        
            $result =  $this->query($query);
            if(gettype($result) == string){
                echo $result;
            }
            $resultRow = Array();
            while($row = $result->fetch_assoc())
            {
                $resultArray = $row;
                array_push($resultRow,$resultArray);
            }
            return $resultRow;
            
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        } 
        
    }
    
    //get ta_delivery
    public function getSendDeliveryCount($delivery, $branch){
      
         $st_date = date('Y-m-d');
        
        try{
		$fields = " COUNT(*) list_count";                
		$table = "tang_order";                
                
              //  if($where){
                //$where = "jakupdate = '$doc_date' AND ta_delivery = $delivery AND yyname = '$branch'  ";                    
                $where = "ta_status = 102 AND ta_delivery = $delivery AND br_code = '$branch' ";                    
              
              //  }else{
              //      $where = '';
              //  }                
		$get_data = $this->get_record($fields, $table, $where);
		return $get_data;
	
        } catch ( Exception $ex ){
                die($ex->getMessage());	
        }     
             
    }
    
    //택배 다운로드
    public function getDownloadTangList(){
        
        try{            
            $query = "SELECT * FROM pyeongang WHERE ta_status>200 ORDER BY hsid DESC";           
          //  echo $query.'<br>';                        
            $result =  $this->query($query);
            if(gettype($result) == string){
                echo $result;
            }
            $resultRow = Array();
            while($row = $result->fetch_assoc())
            {
                $resultArray = $row;
                array_push($resultRow,$resultArray);
            }
            return $resultRow;
            
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }        
    }
    
    //common function - 게시판의 전체 게시물
  /*  public function getBoardListCount($g_table, $where){     
        
         try{
		$fields = " COUNT(*) list_count";                
		$table = "$g_table";                
              
                $where = $where." AND ta_status = 201 AND yyname = 1001";                    
                  
		$get_data = $this->get_record($fields, $table, $where );
		return $get_data;
	
        } catch ( Exception $ex ){
                die($ex->getMessage());	
        }         
    }*/
    
    //tang upload list view
    public function getTangView($hsid, $dr_id){
        
        try{
		$fields = ' hsid, od_number, hsid_sub, yynumber, yyname,                                 
                                name, jumin, jakupdate, 
                                tel, handphone, address, tname, tpaek, tdang,
                                tdate, tmemo, edtime, delivery_date, ta_delivery,
                                ta_status, modfy_date, mod_cnt, register,
                                delivery_num, CONVERT(qrp USING euckr) qrp_c, qrp ';
		$table = ' pyeongang';
		$where = "hsid = $hsid ";			
		$get_data = $this->get_record($fields, $table, $where);
		return $get_data;
	
            } catch ( Exception $ex ){
                //die($ex->getMessage());	
                 echo '<script type="text/javascript">                      
                    window.location = "../common/svr_error.php?msg='.$ex->getMessage().'";
                </script>';
            }
        
    }
    
      //view - order tang
    public function getSendOrderView($od_number){
        
        try{
		$fields = ' a.od_number, a.hsid, a.hsid_sub, a.br_code, cs_name, a.treat_date, c_phone, h_phone, address, tname, tpaek, ta_delivery, tmemo, dc_name,
                            pr_name, pre_name, take_date, packs_quantity, tot_packs, ta_status, delivery_date, prepare_date, a.treat_date ';
		$table = ' tang_order a INNER JOIN prescription b ON a.od_number = b.od_number';
		$where = " a.od_number = $od_number ";		
                
		$get_data = $this->get_record($fields, $table, $where);
		return $get_data;
	
            } catch ( Exception $ex ){
                //die($ex->getMessage());	
                 echo '<script type="text/javascript">                      
                    window.location = "../common/svr_error.php?msg='.$ex->getMessage().'";
                </script>';
            }        
    }
    
    
      //tang upload list view
    public function getReserveView($hsid){
        
        try{
		$fields = ' * ';
		$table = ' pyeongang ';
		$where = "hsid = $hsid ";			
		$get_data = $this->get_record($fields, $table, $where);
		return $get_data;
	
            } catch ( Exception $ex ){
                //die($ex->getMessage());	
                 echo '<script type="text/javascript">                      
                    window.location = "../common/svr_error.php?msg='.$ex->getMessage().'";
                </script>';
            }
        
    }
    //update reserve date
    public function updateReverveView($get_post, $hsid){               
        
        try{         
                $table = 'pyeongang';
                $where = "hsid = $hsid";

                foreach( $get_post as $key=>$value){
                    $this->offsetSet($key, $value);
                }

                $update = $this->update($table, $where);

                return $update;
              //  return $ret;                        
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }
        
    }
    
    //update ta_status
     public function updateUploadTangList($get_post, $hsid){               
        
        try{         
                $table = 'pyeongang';
                $where = "hsid = '$hsid'";

                foreach( $get_post as $key=>$value){
                    $this->offsetSet($key, $value);
                }

                $update = $this->update($table, $where);

                return $update;
              //  return $ret;                        
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }
        
    }
    
    //update ta_status
     public function updateCron($get_post){               
        
        try{         
                $table = 'pyeongang';
                $where = "ta_status = 101";

                foreach( $get_post as $key=>$value){
                    $this->offsetSet($key, $value);
                }

                $update = $this->update($table, $where);

                return $update;
              //  return $ret;                        
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }
        
    }
    
    //save reserve data
    public function registReserveData($get_post){
        
       try{            
            
           foreach( $get_post as $key=>$value){
                $this->offsetSet($key, $value);
            }
            $insert = $this->insert( 'pyeongang' );	
            return $insert;
            
        } catch(Exception $ex){		
            $ex->getFile();
            $ex->getMessage();
        }	
        
    }
    
    //excel download 송장
   // public function getExlDownload($branch, $st_date, $delivery){
    public function getExlDownload($branch, $delivery, $st_date){
        
         try{            
             $query = "SELECT * FROM pyeongang WHERE yyname = '$branch' AND ta_delivery = $delivery AND ta_status = 101  ORDER BY hsid DESC";           
           // $query = "SELECT * FROM pyeongang WHERE jakupdate = '$st_date' AND yyname = '$branch' AND ta_delivery = $delivery AND ta_status = 101  ORDER BY hsid DESC";           
            //$query = "SELECT * FROM pyeongang WHERE yyname = '$branch' AND ta_delivery = $delivery AND jakupdate = '$st_date' ORDER BY hsid DESC";           
            //echo $query.'<br>';                        
            //exit;
            $result =  $this->query($query);
            if(gettype($result) == string){
                echo $result;
            }
            $resultRow = Array();
            while($row = $result->fetch_assoc())
            {
                $resultArray = $row;
                array_push($resultRow,$resultArray);
            }
            return $resultRow;
            
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        } 
        
    }
    
    public function updateUploadTang($get_post, $ta_id){        
         
        try{         
                $table = 'pyeongang';
                $where = "hsid = '$ta_id'";

                foreach( $get_post as $key=>$value){
                    $this->offsetSet($key, $value);
                }

                $update = $this->update($table, $where);

                return $update;
              //  return $ret;                        
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }
        
    }
    
    // 삭제 ta_status 수정
    public function delTangList($get_post, $od_number){        
         
        try{         
                $table = 'tang_order';
                $where = "od_number = $od_number";

                foreach( $get_post as $key=>$value){
                    $this->offsetSet($key, $value);
                }

                $update = $this->update($table, $where);

                return $update;
              //  return $ret;                        
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }
        
    }
    
    //reserve data 삭제
    
     public function delReserveData($hsid){
        
         try{         
                $table = 'pyeongang';
                $where = "hsid = $hsid";
                $delete = $this->delete($table, $where);
                return $delete;
              //  return $ret;                        
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }        
    }
    
    //지정일 배송저장
    public function registDeliveryReserve( $get_post ){		
        try{
            //if 기존 예약 리스트가 있으면 삭제? 수정?... 
            //수정하려면 rs_id를 가져와야 함
            /*
             * 
             * if(rs_id){ update } else { insert }
             * 
             * if(rs_id != '' && date == ''){ delete } else { ..... }
             * 
             * 
             */
            
           // $get_post[ta_status] = 301;
            
            foreach( $get_post as $key=>$value){
                $this->offsetSet($key, $value);
            }
            $insert = $this->insert( 'pyeongang' );	
            return $insert;
        } catch(Exception $ex){		
            $ex->getFile();
            $ex->getMessage();
        }				
    }	
    
    public function getReserveList($hsid){
        
          try{            
            $query = "SELECT * FROM ta_delivery_reserve WHERE hsid = $hsid";
           // echo $query.'<br>';                        
            $result =  $this->query($query);
            if(gettype($result) == string){
                echo $result;
            }
            $resultRow = Array();
            while($row = $result->fetch_assoc())
            {
                $resultArray = $row;
                array_push($resultRow,$resultArray);
            }
            return $resultRow;
            
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }      
        
    }
    
    //지정 배송일 리스트 화면
    public function getReserveListProc(){
        
        try{            
            $query = "SELECT * FROM ta_delivery_reserve a INNER JOIN ta_list b ON a.ta_id = b.ta_id WHERE ta_status = 201 ORDER BY a.ta_id";           
           // echo $query.'<br>';                        
            $result =  $this->query($query);
            if(gettype($result) == string){
                echo $result;
            }
            $resultRow = Array();
            while($row = $result->fetch_assoc())
            {
                $resultArray = $row;
                array_push($resultRow,$resultArray);
            }
            return $resultRow;
            
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }        
    }
    
    //일괄 택배 적용_ta_delivery_send_list
    public function updateBatchDelivery($get_post, $doc_date, $branch){               
        
        try{         
                $table = 'pyeongang';
                //$where = "jakupdate = '$doc_date' AND yyname = '$branch'";
                $where = "ta_status = 101 AND yynumber = '$branch'";

                foreach( $get_post as $key=>$value){
                    $this->offsetSet($key, $value);
                }

                $update = $this->update($table, $where);

                return $update;
              //  return $ret;                        
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }
        
    }
    
    //일괄 택배 적용_ta_delivery__list
    public function updateBatchSendDelivery($get_post, $doc_date, $branch){               
        
        try{         
                $table = 'tang_order';
                //$where = "jakupdate = '$doc_date' AND yyname = '$branch'";
                $where = "ta_status = 102 AND br_code = '$branch'";

                foreach( $get_post as $key=>$value){
                    $this->offsetSet($key, $value);
                }

                $update = $this->update($table, $where);

                return $update;
              //  return $ret;                        
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }
        
    }
    
    //택배 지정이 없는 리스트 count
    
     public function getTangListNoneDeliverCount($g_table, $doc_date){
        
         try{
		$fields = " COUNT(*) list_count";                
		$table = "$g_table";                
                
              //  if($where){
                $where = "jakupdate = '$doc_date' AND ta_delivery = 0 ";                    
              //  }else{
              //      $where = '';
              //  }                
		$get_data = $this->get_record($fields, $table, $where);
		return $get_data;
	
        } catch ( Exception $ex ){
                die($ex->getMessage());	
        }         
    }
    
    //public function getTangDeliveryCount($doc_date, $delivery, $branch){
     public function getTangDeliveryCount($delivery, $branch){
      
         $st_date = date('Y-m-d');
        
        try{
		$fields = " COUNT(*) list_count";                
		$table = "pyeongang";                
                
              //  if($where){
                //$where = "jakupdate = '$doc_date' AND ta_delivery = $delivery AND yyname = '$branch'  ";                    
                $where = "ta_status = 101 AND ta_delivery = $delivery AND yyname = '$branch' ";                    
              
              //  }else{
              //      $where = '';
              //  }                
		$get_data = $this->get_record($fields, $table, $where);
		return $get_data;
	
        } catch ( Exception $ex ){
                die($ex->getMessage());	
        }     
             
    }
    
    // 예약일이 설정된 데이터 가져오기
    public function getTdateList($jakupdate){
        
          try{            
            $query = "SELECT * FROM pyeongang WHERE ta_status = 101 and tdate != '' ";
           // echo $query.'<br>';                        
            $result =  $this->query($query);
            if(gettype($result) == string){
                echo $result;
            }
            $resultRow = Array();
            while($row = $result->fetch_assoc())
            {
                $resultArray = $row;
                array_push($resultRow,$resultArray);
            }
            return $resultRow;
            
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }      
        
    }
    
    
    //firebird connect
     public function getStatsList($st_date, $ed_date, $prescription, $ta_delivery, $branch){
        
         if($st_date == "") {
             $st_date = "";             
             $and = "";
         }else{
            $st_date = " jakupdate = '$st_date' ";             
            $and = " AND ";
         };         
         
         if($st_date == '' && $task == ''){
             $where = "";
         }else{
             $where = " WHERE ";
         }
         
        try{            
             //$query = "SELECT * FROM ta_list $where $st_date $and $status ORDER BY ta_id DESC";           
             $query = "SELECT yyname, tname, tpaek, COUNT(*) cnt FROM ta_list 
                        WHERE ta_status = 201 AND ta_delivery = $ta_delivery AND yyname = $branch AND tname IN ('$prescription')
                        GROUP BY yyname, tname, tpaek  ORDER BY tpaek;";
            $result =  $this->query($query);
            if(gettype($result) == string){
                echo $result;
            }
            $resultRow = Array();
            while($row = $result->fetch_assoc())
            {
                $resultArray = $row;
                array_push($resultRow,$resultArray);
            }
            return $resultRow;
            
        } catch (Exception $ex) {
            print($ex->getCode());
            print($ex->getMessage());
        }        
    }
    
    public function getSpStats($st_date, $ed_date){
        
        $query = "CALL sp_stats('$st_date', '$ed_date')";
        
        $result =  $this->query($query);
        if(gettype($result) == string){
            echo $result;
        }
        $resultRow = Array();
        while($row = $result->fetch_assoc())
        {
            $resultArray = $row;
            array_push($resultRow,$resultArray);
        }
        return $resultRow;
        
    }
    
    //update ta_status
    
    
}