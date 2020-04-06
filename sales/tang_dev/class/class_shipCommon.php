<?php

//require_once '../lib/JSON.php';

class class_shipCommon extends class_db {
	
    public function __construct(){

        $this->gw_db_ship_connection();
    }

    public function getStuffInventory(){
        
         try{            
            $query = "SELECT * FROM stuff_inventory ORDER BY st_no ";           
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
  
    
    
    
}