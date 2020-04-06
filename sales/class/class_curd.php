<?php
    class class_curd extends class_db {
	
        public function __construct(){        
            //$this->gw_db_pkmall_connection();
           // $this->gw_db_dev_connection();
            $this->gw_db_sales_connection();
        }
        
        //common regist        
        public function curdInsert( $get_post, $table ){
           
            try{	
                    foreach( $get_post as $key=>$value){
                            $this->offsetSet($key, $value);
                    }
                    $insert = $this->insert($table);	
                    return $insert;

            } catch(Exception $ex){		
                    ///CommonErrorHandler( $ex );	
            }

        }
    
        public function curdList($page_no, $page_list_no, $where, $branch, $tag){
        
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
        public function curdItemList($page_no, $page_list_no, $where, $branch, $tag){

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
                        SELECT distinct *
                        FROM sal_item ";

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
    
     public function curdLists($page_no, $page_list_no, $where, $branch, $tag, $table, $group_by){
        
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
                        FROM $table $where $group_by
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
    
    public function curdRecord($table, $where){
        
        try{
            $fields = ' * ';
        //    $table = $table;
        //    echo $where;

            $get_data = $this->get_record($fields, $table, $where);

            return $get_data;

        } catch ( Exception $ex ){
                    die($ex->getMessage());	
        }        
    }
    
    public function curdUpdate( $get_post, $table, $where ){

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
    
    public function curdRecordCount($table, $where) {
       
      try{
            $fields = ' COUNT(*) r_count ';
        //    $table = ' sal_traffic ';
        //   $where = "sal_date = '$sal_date' AND ct_id = '$ct_id' ";

            $get_data = $this->get_record($fields, $table, $where);

            return $get_data;

        } catch ( Exception $ex ){
                die($ex->getMessage());	
        }
       
   }

}