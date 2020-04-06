<?php
    class class_report extends class_db {
	
        public function __construct(){        
            //$this->gw_db_pkmall_connection();
           // $this->gw_db_dev_connection();
            $this->gw_db_sales_connection();
        }
        
        public function getSalReport($ct_id, $month){   
     
        try{                
             $query = " SELECT x.sal_date,
                            SUM(if(x.ct_id = '$ct_id' AND sal_pl = '0', d_tot_price,0)) AS web_price,
                            SUM(if(x.ct_id = '$ct_id' AND sal_pl = '0', d_tot_qty,0)) AS web_qty,
                            web_traffic, cs_traffic,
                            SUM(if(x.ct_id = '$ct_id' AND sal_pl = '1', d_tot_price,0)) AS cs_price,
                            SUM(if(x.ct_id = '$ct_id' AND sal_pl = '1', d_tot_qty,0)) AS cs_qty,
                            cart_qty
                        FROM(
                             SELECT a.sal_date, a.ct_id, a.it_id, d_tot_price, d_tot_qty, it_name, it_opt, sal_pl FROM sal_daily_sales a INNER JOIN sal_item b ON a.ct_id = b.ct_id AND a.it_id = b.it_id
                             WHERE LEFT(a.sal_date, 7) = '$month' AND a.ct_id = '$ct_id'
                            )x LEFT OUTER JOIN sal_traffic y ON x.sal_date = y.sal_date AND x.ct_id = y.ct_id                      
                        GROUP BY x.sal_date, x.ct_id ";
            //echo $query; 
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
   
}