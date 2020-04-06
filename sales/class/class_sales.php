<?php

//require_once '../lib/JSON.php';

class class_sales extends class_db {
	
    public function __construct(){
        $this->gw_db_pkmall_connection();
     //   $this->gw_db_sales_connection();
       // $this->gw_db_dev_connection();
    }
    
    //판매 리스트 가져오기
    public function getOrderList($page_no, $page_list_no, $where, $branch, $tag){
        
        if($page_no == 1){            
            $start_page = 0;
        }else{
            $start_page = $page_no*$page_list_no-$page_list_no;
        }
        $end_page = $page_list_no;
        
        switch($tag){
            case 'list': $page_range = " LIMIT $start_page, $end_page " ; break;
            case 'cnt': $page_range = '' ; break;
        }
        
        try{
            
             $query = " SELECT 
                            a.od_id, od_name, od_email, od_hp, od_b_zip1, od_b_zip2, od_b_addr1, od_b_addr2, od_b_addr3, od_memo, 
                            od_receipt_price, od_status, od_time, od_settle_case 
                        FROM g5_shop_order a INNER JOIN g5_shop_cart b ON a.od_id = b.od_id
                        WHERE $where 
                        ORDER BY a.od_id DESC $page_range ";            
          echo $query;             
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
    
    
    //신의 한수 판매리스트
    public function getSinOrderTot( $to_date, $tag){
        
         switch($tag){            
            case 'c': $wh_it_id = ' it_id IN (1573177193, 1595421782, 1580192523, 1583711913, 1584077837)'; $where = ' '; break;
            case 'w': $wh_it_id = ' it_id IN (2048543503, 2582612241, 2583473227, 2583473227)'; $where = ' '; break;          
        }
        
        try{
           
             $query = "  SELECT it_id, it_name, SUM(tot_price) tot_price, SUM(tot_qty) tot_qty FROM 
                            (SELECT od_id, SUM(od_receipt_price) tot_price FROM g5_shop_order WHERE DATE_FORMAT(od_receipt_time, '%Y-%m-%d') = '$to_date' AND od_status IN ('완료','입금','배송') GROUP BY od_id) a 
                        INNER JOIN 
                            (SELECT od_id, SUM(ct_qty) tot_qty, it_name, it_id FROM g5_shop_cart  WHERE $wh_it_id  GROUP BY od_id) b 
                        ON a.od_id = b.od_id GROUP BY it_id  ";            
            //echo '<br>'.$query.'<br>';             
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


    //0212 modify
     //신의 한수 판매리스트
    public function getUserOrderTot( $to_date, $ct_id){
        
         switch($tag){            
            case 'c': $wh_it_id = ' it_id IN (1573177193, 1580192523, 1595421782)'; $where = ' '; break;
            case 'w': $wh_it_id = ' it_id IN (2048543503)'; $where = ' '; break;          
        }
        
        try{
           
             $query = "  SELECT it_id, it_name, SUM(tot_price) tot_price, SUM(tot_qty) tot_qty FROM 
                            (SELECT od_id, SUM(od_receipt_price) tot_price FROM g5_shop_order WHERE DATE_FORMAT(od_receipt_time, '%Y-%m-%d') = '$to_date' AND od_status IN ('완료','입금','배송') GROUP BY od_id) a 
                        INNER JOIN 
                            (SELECT od_id, SUM(ct_qty) tot_qty, it_name, it_id FROM g5_shop_cart  WHERE mb_level = '$ct_id'  GROUP BY od_id) b 
                        ON a.od_id = b.od_id GROUP BY it_id  ";            
           // echo '<br>'.$query.'<br>';             
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

    //판매 리스트 가져오기
    public function getOrderTot($to_date, $where_r, $ct_id){   
      
        switch($ct_id){            
            case 'yt_admin': $wh_it_id = ''; $where = ''; break;
            case 'pk_tlsdmlgkstn': $wh_it_id = ' it_id IN (1573177193, 1580192523, 1595421782)'; $where = ' WHERE '; break;
            case 'pk_vmfhdusdn':  $wh_it_id = '  it_id IN (2048543501)';  $where = ' WHERE ';break;            
            case 'pk_kevin':  $wh_it_id = '  it_id IN (2048543502)';  $where = ' WHERE ';break;  
        }
       
        try{
           
             $query = "  SELECT it_id, it_name, SUM(tot_price) tot_price, SUM(tot_qty) tot_qty FROM 
                            (SELECT od_id, SUM(od_receipt_price) tot_price FROM g5_shop_order WHERE DATE_FORMAT(od_receipt_time, '%Y-%m-%d') = '$to_date' AND od_status IN ('완료','입금','배송') GROUP BY od_id) a 
                        INNER JOIN 
                            (SELECT od_id, SUM(ct_qty) tot_qty, it_name, it_id FROM g5_shop_cart  $where $where_r  $wh_it_id  GROUP BY od_id) b 
                        ON a.od_id = b.od_id GROUP BY it_id  ";            
          //  echo '<br>'.$query.'<br>';             
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
    
    //크리에이터 판매 리스트 가져오기
    public function getCtItemList(){   
       
        try{           
             $query = " SELECT it_id, it_name, ca_id, it_2  FROM g5_shop_item WHERE it_2 = 'y'  ";            
           // echo '<br>'.$query.'<br>';             
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
    
    
}