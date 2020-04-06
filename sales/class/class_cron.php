<?php
    class class_cron extends class_db {
	
        public function __construct(){        
           $this->gw_db_pkmall_connection();
           // $this->gw_db_dev_connection();
           // $this->gw_db_sales_connection();
        }
      
         //일별 판매 리스트 가져오기
        public function getDailyCrData($td_date, $ct_id, $it_id){   

            try{
              
                 $query = "       
                            SELECT date_format(od_receipt_time, '%Y-%m-%d') daily_date, SUM(od_receipt_price) tot_price, SUM(ct_qty) tot_qty, COUNT(*) cnt
                            FROM 
                                g5_shop_order a INNER JOIN g5_shop_cart b ON a.od_id = b.od_id
                            WHERE 
                                date_format(od_receipt_time, '%Y-%m-%d') = '$td_date' AND mb_level = '$ct_id' AND it_id = $it_id AND od_status IN ('입금','배송','완료')";
                
              echo $query.'<br>'; 
            //  exit;
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
             
                 $query = "SELECT date_format(od_receipt_time, '%Y-%m-%d') daily_date, SUM(ct_qty*io_price) tot_price, SUM(ct_qty) tot_qty, COUNT(*) cnt FROM 
                            (SELECT od_id, od_receipt_price, od_status, od_receipt_time FROM g5_shop_order 
                            WHERE date_format(od_receipt_time, '%Y-%m-%d') = '$td_date')
                             a INNER JOIN 
                             (SELECT * FROM g5_shop_cart WHERE it_id = $it_id) b 
                             ON a.od_id = b.od_id 
                            WHERE od_status IN ('입금','배송','완료')";
                 
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

        //월별 판매 리스트 가져오기
        public function getMohthlyList($page_no, $page_list_no, $where, $branch, $tag){

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
                 $query = "                  
                            SELECT date_format(od_receipt_time, '%Y-%m') daily_date, SUM(od_receipt_price) tot_price, SUM(ct_qty) tot_qty, COUNT(*) cnt
                            FROM g5_shop_order a INNER JOIN g5_shop_cart b ON a.od_id = b.od_id
                            WHERE $where
                            AND od_status IN ('입금','배송','완료') GROUP BY date_format(od_receipt_time, '%Y-%m') 
                            ORDER BY date_format(od_receipt_time, '%Y-%m')  DESC $page_range";

    //           echo $query; 

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