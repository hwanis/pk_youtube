<?php
    class class_curd extends class_db {
	
        public function __construct(){        
            //$this->gw_db_pkmall_connection();
           // $this->gw_db_dev_connection();
            $this->gw_db_ship_connection();
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
        
    public function curdUpdate( $get_post, $table, $where ){
         try{              
                foreach( $get_post as $key=>$value){
                    $this->offsetSet($key, $value);
                }
                $update = $this->update($table, $where);

                return $update;

        } catch(Exception $ex){		
                ///CommonErrorHandler( $ex );	
        }  
    }
    
    public function curdList($table, $where){
       
        if($where){            
            $where = " WHERE $where";            
        }else{            
            $where = '';
        }
            
        try{
            $query = " SELECT * FROM $table $where";
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
    
    public function curdJoinList($field, $table, $where){
        
        if($where){            
            $where = " WHERE $where";            
        }else{            
            $where = '';
        }
            
        try{
            $query = " SELECT $field FROM $table $where";
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
    
    public function curdRecordCount($table, $where) {
 
        try{
            $fields = ' COUNT(*) r_count ';
            $get_data = $this->get_record($fields, $table, $where);

            return $get_data;

        } catch ( Exception $ex ){
                die($ex->getMessage());	
        }       
   }
   
   public function curdRecord($table, $where) {
 
        try{
            $fields = ' * ';
            $get_data = $this->get_record($fields, $table, $where);

            return $get_data;

        } catch ( Exception $ex ){
                die($ex->getMessage());	
        }
       
   }
   
}