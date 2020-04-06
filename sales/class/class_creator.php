<?php

//require_once '../lib/JSON.php';

class class_creator extends class_db {
	
    public function __construct(){
        $this->gw_db_sales_connection();
    }
    
    public function getCreatorInfo($ct_id){
        
        try{
            $fields = ' * ';
            $table = ' sal_creator ';
            $where = "ct_id = '$ct_id'";

            $get_data = $this->get_record($fields, $table, $where);

            return $get_data;

        } catch ( Exception $ex ){
                    die($ex->getMessage());	
        }        
    }

        // insert member information
    public function updateCreator( $get_post, $ct_id ){

         try{
                $table = 'sal_creator';
                $where = "ct_id = '$ct_id' ";

                foreach( $get_post as $key=>$value){
                        $this->offsetSet($key, $value);
                }

                $update = $this->update($table, $where);

                return $update;

        } catch(Exception $ex){		
                ///CommonErrorHandler( $ex );	
        }  

    }
    
    //update creator
    public function registCreator( $get_post ){

        try{	
                foreach( $get_post as $key=>$value){
                        $this->offsetSet($key, $value);
                }
                $insert = $this->insert( 'sal_creator' );	
                return $insert;

        } catch(Exception $ex){		
                ///CommonErrorHandler( $ex );	
        }

    }
    
       //creator 리스트 가져오기
    public function getCreatorList($page_no, $page_list_no, $where, $branch, $tag){
        
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
                        SELECT ct_id, ct_name, passwd, rs_rate, last_login, regist_date, login_cnt, ct_url
                        FROM sal_creator WHERE ct_auth = 1 AND ct_use = 1 GROUP BY ct_id
                        $page_range";

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
    
     //get login information use request m_id
    public function getChkLoginId($ct_id){

        try{

            $fields = ' ct_id, ct_name, passwd, rs_rate, login_cnt, last_login, regist_date, ct_use, ct_url, ct_auth ';
            $table = ' sal_creator ';
            $where = "ct_id = '".$ct_id."'";

            $get_data = $this->get_record($fields, $table, $where);

            return $get_data;

            } catch ( Exception $ex ){
                    die($ex->getMessage());	
            }

    }
        
    //get traffic, inert trffic
    public function getDailyTraffic($ct_id, $od_date){

        try{

            $fields = ' sal_date, ct_id, ct_traffic, reg_date ';
            $table = ' sal_traffic ';
            $where = "ct_id = '".$ct_id."' AND od_date = '$od_date'";

            $get_data = $this->get_record($fields, $table, $where);

            return $get_data;

            } catch ( Exception $ex ){
                    die($ex->getMessage());	
            }

    }
        
    //update creator information
    public function updateLoginInfo($get_post){

         try{
                $table = 'sal_creator';
                $where = "ct_id = '$get_post[ct_id]'";

                foreach( $get_post as $key=>$value){
                        $this->offsetSet($key, $value);
                }

                $update = $this->update($table, $where);

                return $update;

        } catch(Exception $ex){		
                ///CommonErrorHandler( $ex );	
        }            
    }

        //creator item별 리스트 가져오기
    public function getCreator(){

        try{
             $query = " SELECT a.ct_id, ct_name, rs_rate, it_id, sal_pl FROM sal_item a INNER JOIN (SELECT * FROM sal_creator WHERE ct_use = 1) b ON a.ct_id = b.ct_id ";

         //  echo $query; 
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
        
    //RS 크리에이터 리스트 
     public function getCreatorRsList(){

        try{
            $query = " SELECT * FROM sal_creator WHERE ct_auth = 1 ";
         //  echo $query; 
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
        
    //RS 크리에이터 리스트 
    public function getCreatorItemList($ct_id){

        try{
           if($ct_id){
                $query = " SELECT * FROM sal_item WHERE ct_id = '$ct_id' ";
           }else{               
                $query = " SELECT * FROM sal_item ";
           }
           
        //  echo $query; 
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
        
         // insert sal information
    public function registTraffic( $get_post ){

        try{	
                foreach( $get_post as $key=>$value){
                        $this->offsetSet($key, $value);
                }
                $insert = $this->insert( 'sal_traffic' );	
                return $insert;

        } catch(Exception $ex){		
                ///CommonErrorHandler( $ex );	
        }

    }

    // insert sal_item
    public function registItem( $get_post ){

        try{
            foreach( $get_post as $key=>$value){
                $this->offsetSet($key, $value);
            }
            $insert = $this->insert( 'sal_item' );
            return $insert;

        } catch(Exception $ex){
            ///CommonErrorHandler( $ex );
        }

    }
    
     //update creator information
    public function updateTraffic($get_post, $ct_id, $sal_date){

         try{
                $table = 'sal_traffic';
                $where = "ct_id = '$ct_id' AND sal_date = '$sal_date'";

                foreach( $get_post as $key=>$value){
                        $this->offsetSet($key, $value);
                }

                $update = $this->update($table, $where);

                return $update;

        } catch(Exception $ex){		
                ///CommonErrorHandler( $ex );	
        }            
    }
    
    //get traffic count
   public function trafficCount($sal_date, $ct_id) {
       
      try{
            $fields = ' COUNT(*) list_cnt ';
            $table = ' sal_traffic ';
            $where = "sal_date = '$sal_date' AND ct_id = '$ct_id' ";

            $get_data = $this->get_record($fields, $table, $where);

            return $get_data;

        } catch ( Exception $ex ){
                die($ex->getMessage());	
        }
       
   }
   
    
    //get traffic
    public function getTraffic($get_post, $ct_id){

         try{
                 $query = "                  
                            SELECT sal_date, ct_id, ct_traffic
                            FROM sal_traffic WHERE ct_id = '$ct_id'  ";

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
    
    /*
    // insert member information
    public function registDailySales( $get_post ){

        try{	
                foreach( $get_post as $key=>$value){
                        $this->offsetSet($key, $value);
                }
                $insert = $this->insert( 'sal_daily_sales' );	
                return $insert;

        } catch(Exception $ex){		
                ///CommonErrorHandler( $ex );	
        }

    }
    */
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
         //   $query =" SELECT * FROM sal_daily_sales WHERE ct_id = '$ct_id' ORDER BY sal_date DESC $page_range ";            
            $query = " SELECT a.sal_date, a.ct_id, SUM(d_tot_price) d_tot_price, SUM(d_tot_qty) d_tot_qty, "
                    . " ct_traffic sal_traffic, SUM(od_suc) od_suc, SUM(od_cnc) od_cnc "
                    . " FROM sal_daily_sales a LEFT OUTER JOIN sal_traffic b ON a.ct_id = b.ct_id AND a.sal_date = b.sal_date"
                    . " WHERE a.ct_id = '$ct_id' "
                    . " GROUP BY sal_date ORDER BY sal_date  DESC $page_range ";
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
    
    //creator daily 할인율 RS 입력
    public function getCtSaleRate($page_no, $page_list_no, $where, $branch, $tag){
        
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
                        SELECT *
                        FROM ct_sales_rate a INNER JOIN sal_item b on a.item_id = b.it_id INNER JOIN sal_creator c ON a.ct_id = c.ct_id WHERE ct_use=1 ORDER BY rate_id DESC 
                        $page_range";

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
    
    //regist crator  rate
     public function registRsRate( $get_post ){

        try{	
                foreach( $get_post as $key=>$value){
                        $this->offsetSet($key, $value);
                }
                $insert = $this->insert( 'ct_sales_rate' );	
                return $insert;

        } catch(Exception $ex){		
                ///CommonErrorHandler( $ex );	
        }

    }
  
    //ct_rs_rate_mod
     public function getCtRsRateMod($rate_id){
            
        try{

            $fields = ' * ';
            $table = ' ct_sales_rate ';
            $where = "rate_id = '".$rate_id."'";

            $get_data = $this->get_record($fields, $table, $where);

            return $get_data;

            } catch ( Exception $ex ){
                    die($ex->getMessage());	
            }
            
        }


    //제품리스트 수정
    public function getItemMod($it_id){

        try{

            $fields = ' * ';
            $table = ' sal_item ';
            $where = "it_id = '".$it_id."'";

            $get_data = $this->get_record($fields, $table, $where);

            return $get_data;

        } catch ( Exception $ex ){
            die($ex->getMessage());
        }

    }
        
     public function updateCtRsRatePopMod( $get_post, $rate_id ){

       try{
                $table = 'ct_sales_rate';
                $where = "rate_id = $rate_id";

                foreach( $get_post as $key=>$value){
                        $this->offsetSet($key, $value);
                }

                $update = $this->update($table, $where);

                return $update;

        } catch(Exception $ex){		
                ///CommonErrorHandler( $ex );	
        }         

    }
    /*
    public function updateItemMod( $get_post, $table, $where ){

        try{
            // $table = 'sal_creator';
            //  $where = "ct_id = '$ct_id' ";

            foreach( $get_post as $key=>$value){
                $this->offsetSet($key, $value);
            }

            $update = $this->update($table, $where);

            return $update;

        } catch(Exception $ex){
            ///CommonErrorHandler( $ex );
        }

    }
*/

       
     //creator daily 할인율 RS 입력
    public function getCtSalesRs($ct_id, $sal_date){
        
        try{

		$fields = ' * ';
		$table = ' ct_sales_rate ';
		$where = "ct_id = '$ct_id' AND sal_from_date <= '$sal_date' AND sal_to_date >= '$sal_date'";
			
		$get_data = $this->get_record($fields, $table, $where);

		return $get_data;
	
		} catch ( Exception $ex ){
			die($ex->getMessage());	
		}
            
        }
        
     //ct_rs_rate_mod
     public function getCtRsDateDup($from_date, $to_date, $ct_id, $it_id){
            
            try{

		$fields = ' COUNT(*) cnt ';
		$table = ' ct_sales_rate ';
		$where = "ct_id = '".$ct_id."' AND item_id = $it_id AND (sal_from_date >= '$from_date' AND sal_to_date <= '$to_date')";
			
		$get_data = $this->get_record($fields, $table, $where);

		return $get_data;
	
		} catch ( Exception $ex ){
			die($ex->getMessage());	
		}
            
        }
        
    //신의 한수 레포팅 자료
         //creatorrs
  
    public function getMonthlyReport($ct_id, $month){            
        try{
         //   $query =" SELECT * FROM sal_daily_sales WHERE ct_id = '$ct_id' ORDER BY sal_date DESC $page_range ";
            $query = " 
                    SELECT sal_date
                            , SUM(if(a.ct_id = '$ct_id' AND sal_pl = 1, d_tot_price,0)) AS cs_price
                       , SUM(if(a.ct_id = '$ct_id' AND sal_pl = 1, d_tot_qty,0)) AS cs_qty
                            , SUM(if(a.ct_id = '$ct_id' AND sal_pl = 0, d_tot_price,0)) AS w_price
                            , SUM(if(a.ct_id = '$ct_id' AND sal_pl = 0, d_tot_qty,0)) AS w_qty
                    FROM sal_daily_sales a INNER JOIN sal_item b ON a.ct_id = b.ct_id AND a.it_id = b.it_id
                    WHERE LEFT(sal_date,7) = '$month'
                    GROUP BY sal_date
                    ORDER BY sal_date  ";

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