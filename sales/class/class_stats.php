<?php

//require_once '../lib/JSON.php';

class class_stats extends class_db {
	
    public function __construct(){
        $this->gw_db_sales_connection();
    }
  
    //일별 판매 리스트 가져오기
    public function getStatsDailySales($ct_id, $it_id, $st_date, $ed_date, $tag){   
        
        if($tag == 'cs'){
            
            switch($ct_id){            
            case 'pk_tlsdmlgkstn':
                $s_query = "  SUM(if(it_id = 1573177193, d_tot_price,0)) AS sun_price
                            ,SUM(if(it_id = 1573177193, d_tot_qty,0)) AS sun_qty
                            ,SUM(if(it_id = 1580192523, d_tot_price,0)) AS org_price
                            ,SUM(if(it_id = 1580192523, d_tot_qty,0)) AS org_qty
                            ,SUM(if(it_id = 1595421782, d_tot_price,0)) AS ji_price 
                            ,SUM(if(it_id = 1595421782, d_tot_qty,0)) AS ji_qty
                             ,SUM(if(it_id = 1583711913, d_tot_price,0)) AS bok_price 
                            ,SUM(if(it_id = 1583711913, d_tot_qty,0)) AS bok_qty
                            "; 
                break;
            case 'pk_gong':
                $s_query = "  SUM(if(it_id = 2583279042, d_tot_price,0)) AS sun_price
                            ,SUM(if(it_id = 2583279042, d_tot_qty,0)) AS sun_qty                         
                            "; 
                break;
            default:
                $s_query = " SUM(if(it_id = $it_id, d_tot_price,0)) AS tot_price"
                    . ", SUM(if(it_id = $it_id, d_tot_qty,0)) AS tot_qty ";
                break;            
        }
        }else{
            switch($ct_id){            
            case 'pk_tlsdmlgkstn':
                $s_query = "  SUM(if(it_id = 2048543503, d_tot_price,0)) AS sun_price
                            ,SUM(if(it_id = 2048543503, d_tot_qty,0)) AS sun_qty
                            ,SUM(if(it_id = 2583473227, d_tot_price,0)) AS org_price
                            ,SUM(if(it_id = 2583473227, d_tot_qty,0)) AS org_qty
                             ,SUM(if(it_id = 2582612241, d_tot_price,0)) AS bok_price 
                            ,SUM(if(it_id = 2582612241, d_tot_qty,0)) AS bok_qty
                            "; 
                break;
            case 'pk_gong':
                $s_query = "  SUM(if(it_id = 2583279042, d_tot_price,0)) AS sun_price
                            ,SUM(if(it_id = 2583279042, d_tot_qty,0)) AS sun_qty                         
                            "; 
                break;
            default:
                $s_query = " SUM(if(it_id = $it_id, d_tot_price,0)) AS tot_price"
                    . ", SUM(if(it_id = $it_id, d_tot_qty,0)) AS tot_qty ";
                break; 
            
            }
        }        

        try{
            $query =" SELECT sal_date,
                        $s_query
                    FROM sal_daily_sales
                    WHERE ct_id = '$ct_id' AND sal_date BETWEEN '$st_date' AND '$ed_date'
                    GROUP BY sal_date
                    ORDER BY sal_date DESC ";         
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
    
    //크리에이터 개별 웹 통계 web 통계
    public function getTlsWebStats($ct_id, $st_date, $ed_date){
        
         try{
            $query =" 
                    SELECT sal_date, a.ct_id, it_name, it_opt, sal_pl, d_tot_qty, d_tot_price, ct_name, ct_auth, ct_use
                    FROM sal_daily_sales a INNER JOIN sal_item b ON a.it_id = b.it_id INNER JOIN sal_creator c ON a.ct_id = c.ct_id
                     WHERE sal_pl = 0 AND a.ct_id = '$ct_id' AND sal_date BETWEEN '$st_date' AND '$ed_date'                     
                    GROUP BY sal_date, a.ct_id, a.it_id
                    ORDER BY sal_date DESC, a.ct_id, d_tot_price  
                    ";
          //  echo $query;
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

    //전체 상품 통계 
    public function getStatsTotSales($st_date, $ed_date, $ct_id){   
        
        if($ct_id == ''){
            $ct_sql = '';
        }else{
            $ct_sql =  " AND a.ct_id = '$ct_id'";
        }
               
        try{
            $query =" 
                        SELECT sal_date,
                                SUM(if(it_class = 100 AND it_opt = 10, d_tot_price,0)) AS org_10_price,
                                SUM(if(it_class = 100 AND it_opt = 10, d_tot_qty,0)) AS org_10_qty,
                                SUM(if(it_class = 100 AND it_opt = 30, d_tot_price,0)) AS org_30_price,
                                SUM(if(it_class = 100 AND it_opt = 30, d_tot_qty,0)) AS org_30_qty,
                                SUM(if(it_class = 200 AND it_opt = 10, d_tot_price,0)) AS sun_10_price,
                                SUM(if(it_class = 200 AND it_opt = 10, d_tot_qty,0)) AS sun_10_qty,
                                SUM(if(it_class = 200 AND it_opt = 30, d_tot_price,0)) AS sun_30_price,
                                SUM(if(it_class = 200 AND it_opt = 30, d_tot_qty,0)) AS sun_30_qty,
                                SUM(if(it_class = 300 AND it_opt = 10, d_tot_price,0)) AS ji_10_price,
                                SUM(if(it_class = 300 AND it_opt = 10, d_tot_qty,0)) AS ji_10_qty,
                                SUM(if(it_class = 300 AND it_opt = 30, d_tot_price,0)) AS ji_30_price,
                                SUM(if(it_class = 300 AND it_opt = 30, d_tot_qty,0)) AS ji_30_qty,
                                SUM(if(it_class = 400 AND it_opt = 10, d_tot_price,0)) AS dang_10_price,
                                SUM(if(it_class = 400 AND it_opt = 10, d_tot_qty,0)) AS dang_10_qty,
                                SUM(if(it_class = 400 AND it_opt = 30, d_tot_price,0)) AS dang_30_price,
                                SUM(if(it_class = 400 AND it_opt = 30, d_tot_qty,0)) AS dang_30_qty,
                                SUM(if(it_class = 500 AND it_opt = 10, d_tot_price,0)) AS bok_10_price,
                                SUM(if(it_class = 500 AND it_opt = 10, d_tot_qty,0)) AS bok_10_qty,
                                SUM(if(it_class = 500 AND it_opt = 30, d_tot_price,0)) AS bok_30_price,
                                SUM(if(it_class = 500 AND it_opt = 30, d_tot_qty,0)) AS bok_30_qty
                        FROM sal_daily_sales a INNER JOIN sal_item b 
                        ON a.it_id = b.it_id
                        WHERE sal_date BETWEEN '$st_date' AND '$ed_date' $ct_sql
                        GROUP BY sal_date
                        ORDER BY sal_date DESC
                    ";
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
    
    //판매 통계 web 일별 집계
    public function getDailyStats($st_date, $ed_date, $ct_id){

            $query =" 
                SELECT sal_date, a.ct_id, it_name, it_opt, sal_pl, d_tot_qty, d_tot_price, ct_name, ct_auth, ct_use
                FROM sal_daily_sales a INNER JOIN sal_item b ON a.it_id = b.it_id INNER JOIN sal_creator c ON a.ct_id = c.ct_id
                WHERE sal_date BETWEEN '$st_date' AND '$ed_date' AND sal_pl = 0
                GROUP BY sal_date, a.ct_id, a.it_id
                ORDER BY sal_date DESC, a.ct_id, d_tot_price";
                       
        try{
           
           // echo $query;
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
    
    //web 크리에터  
    public function getSalItem(){
        
        try{
            $query =" 
                       SELECT * FROM sal_item a INNER JOIN sal_creator b ON a.ct_id = b.ct_id
                       WHERE  sal_pl != 1 AND a.ct_id != 'pk_tlsdmlgkstn'
                        GROUP BY a.ct_id, sal_pl
                    ";
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
    
     
    //크리에이터별 판매품목 
    public function getWebCtSalItem($ct_id){
        
        try{
            $query =" 
                       SELECT * FROM sal_item a INNER JOIN sal_creator b ON a.ct_id = b.ct_id
                       WHERE  a.ct_id = '$ct_id' AND sal_pl = 0
                        GROUP BY a.ct_id, sal_pl
                    ";
           // echo $query;
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
    
    //크리에이터, 판매품목 
    public function getTlsSalItem(){
        
        try{
            $query =" 
                        SELECT * FROM 
                            (SELECT * FROM sal_item WHERE ct_id  = 'pk_tlsdmlgkstn' AND sal_pl = 1) a
                            INNER JOIN 
                            ( SELECT * FROM sal_creator)b ON a.ct_id = b.ct_id
                    ";
          //  echo $query;
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