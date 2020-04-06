<?php
    class class_stdata extends class_db {
	
        public function __construct(){        
            //$this->gw_db_pkmall_connection();
           // $this->gw_db_dev_connection();
            $this->gw_db_sales_connection();
        }
        
        public function getCreatorItem($where_item){
            
             try{
                $query =" SELECT * FROM sal_item $where_item GROUP BY it_id ";          
                //    echo $query; 
                //   exit;           
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
      
         //일별 판매 리스트 가져오기
        public function getDailyCrData($td_date, $ct_id){   

            try{
                $query =" SELECT * FROM sal_daily_sales WHERE ct_id = '$ct_id' ORDER BY sal_date DESC  ";
                /*
                 $query = "       
                            SELECT date_format(od_receipt_time, '%Y-%m-%d') daily_date, SUM(od_receipt_price) tot_price, SUM(ct_qty) tot_qty, COUNT(*) cnt
                            FROM 
                                g5_shop_order a INNER JOIN g5_shop_cart b ON a.od_id = b.od_id
                            WHERE 
                                date_format(od_receipt_time, '%Y-%m-%d') = '$td_date' AND mb_level = '$ct_id' AND od_status IN ('입금','배송','완료')";
                 */
              //echo $query.'<br>'; 
               //  AND it_id IN (1573177193, 1595421782) AND od_status IN ('입금','배송','완료') GROUP BY date_format(od_receipt_time, '%Y-%m-%d')  AND
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
        
          //신의 한수 일별 판매 리스트 가져오기
        public function getDailyCrData_s($td_date, $it_id){   

            try{
                 $query = "                  
                            SELECT date_format(od_receipt_time, '%Y-%m-%d') daily_date, SUM(od_receipt_price) tot_price, SUM(ct_qty) tot_qty, COUNT(*) cnt
                            FROM 
                                g5_shop_order a INNER JOIN g5_shop_cart b ON a.od_id = b.od_id
                            WHERE 
                                date_format(od_receipt_time, '%Y-%m-%d') = '$td_date' AND it_id IN ($it_id) AND od_status IN ('입금','배송','완료')";

             //   echo $query.'<br>'; 
               //  AND it_id IN (1573177193, 1595421782) AND od_status IN ('입금','배송','완료') GROUP BY date_format(od_receipt_time, '%Y-%m-%d')  AND
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

        
     //일별 판매 리스트 가져오기
    public function getDailyList($page_no, $page_list_no, $where, $ct_id, $tag, $s_auth){   
        
        if($page_no == 1){            
            $start_page = 0;
        }else{
            $start_page = $page_no*$page_list_no-$page_list_no;
        }
        
        $end_page = $page_list_no;
        
        switch($tag){
            case 'list': $page_range = " LIMIT $start_page, $end_page " ; break;
            case 'cnt': $page_range = '' ; break;
            case 'dashboard': $page_range = " LIMIT 0, 5 "; break;
        }
        
        if($ct_id != ''){
            $ct_id_sql = " WHERE ct_id = '$ct_id' ";
        }else{
            $ct_id_sql = "";
        }
        
        try{
            
            switch($s_auth){                
                case 0:
                    $query = " SELECT a.sal_date, d_tot_qty, d_tot_price, cn_qty, cn_price  FROM (
                                SELECT 
                                        date_format(sal_date, '%Y-%m-%d') sal_date, SUM(d_tot_price) d_tot_price, SUM(d_tot_qty) d_tot_qty, SUM(sal_traffic) sal_traffic, SUM(od_suc) od_suc 
                                FROM sal_daily_sales $ct_id_sql
                                      GROUP BY date_format(sal_date, '%Y-%m-%d') 
                                )a LEFT OUTER JOIN od_cancel b
                                ON a.sal_date = b.sal_date 
                               WHERE $where GROUP BY a.sal_date 
                               ORDER BY a.sal_date DESC $page_range";

                    break;
                case 1:
                    // $ct_id = pk_tlsdmlgkstn :
                    // $ct_id != pk_tlsdmlgkstn: 
                $query =" SELECT a.sal_date, d_tot_qty, d_tot_price, cn_qty, cn_price  FROM (
                                SELECT 
                                        date_format(sal_date, '%Y-%m-%d') sal_date, SUM(d_tot_price) d_tot_price, SUM(d_tot_qty) d_tot_qty, SUM(sal_traffic) sal_traffic, SUM(od_suc) od_suc 
                                FROM sal_daily_sales $ct_id_sql
                                      GROUP BY date_format(sal_date, '%Y-%m-%d') 
                                )a LEFT OUTER JOIN od_cancel b
                                ON a.sal_date = b.sal_date 
                               WHERE $where GROUP BY a.sal_date 
                               ORDER BY a.sal_date DESC  ";
                    break;
            }
             
         //  echo $query; 
        //   exit;
           
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
    
    //월별 판매 리스트 가져오기
    public function getMohthlyList($page_no, $page_list_no, $where, $ct_id, $tag){
        
        if($page_no == 1){            
            $start_page = 0;
        }else{
            $start_page = $page_no*$page_list_no-$page_list_no;
        }
        
        $end_page = $page_list_no;
        
        switch($tag){
            case 'list': $page_range = " LIMIT $start_page, $end_page " ; break;
            case 'cnt': $page_range = '' ; break;
            case 'dashboard': $page_range = " LIMIT 0, 5 "; break;
        }
        
        try{
            
            switch($s_auth){                
                case 0:
                    $query = "SELECT date_format(sal_date, '%Y-%m') sal_date, SUM(d_tot_price) d_tot_price, SUM(d_tot_qty) d_tot_qty, SUM(sal_traffic) sal_traffic, SUM(od_suc) od_suc FROM sal_daily_sales 
                              $where GROUP BY date_format(sal_date, '%Y-%m') ORDER BY date_format(sal_date, '%Y-%m') DESC $page_range";
                    break;
                case 1:
                $query =" SELECT date_format(sal_date, '%Y-%m') sal_date, ct_id, d_tot_price, d_tot_qty, sal_traffic, od_suc, od_cnc  FROM sal_daily_sales "
                        . "$where  GROUP BY date_format(sal_date, '%Y-%m')  ORDER BY sal_date DESC $page_range ";
                    break;
            }
            
            //echo $query;
            
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
    
    //총 판매액
    public function getTotSales( $ct_id, $s_auth){
        
        try{
            
            switch($s_auth){                
                case 0:
                    $query = "SELECT a.ct_id, a.it_id, it_name, SUM(d_tot_price) d_tot_price, SUM(d_tot_qty) d_tot_qty "
                        . "FROM sal_daily_sales a INNER JOIN sal_item b ON a.it_id = b.it_id GROUP BY a.ct_id;";
                    break;
                case 1:
                    $query =" SELECT a.it_id, it_name, SUM(d_tot_price) d_tot_price, SUM(d_tot_qty) d_tot_qty "
                        . "FROM sal_daily_sales a INNER JOIN sal_item b ON a.it_id = b.it_id"
                        . " WHERE a.ct_id = '$ct_id' GROUP BY it_id; ";
                    break;
            }
            
         //   echo $query;
            
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
    
  //creatorrs
      //일별 판매 리스트 가져오기
    public function getCreatorRs($page_no, $page_list_no, $where, $ct_id, $tag){   
        
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
            $query =" SELECT * FROM sal_daily_sales WHERE ct_id = '$ct_id' ORDER BY sal_date DESC $page_range ";
           
           //echo $query; 
           
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