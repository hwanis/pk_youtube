<?php
class class_common extends class_db {
	
    public function __construct(){	
      
       $this->gw_db_sales_connection(); 
    }
	
    //get page list
    public function getPageList($pg_name){
       
         try{
		$fields = " pg_id, pg_title, pg_category, pg_name, pg_contents, pg_path ";
                
		$table = "sal_pagelist";
		$where = "pg_name = '$pg_name'";
              	
		$get_data = $this->get_record($fields, $table, $where);

		return $get_data;
	
        } catch ( Exception $ex ){
                die($ex->getMessage());	
        } 
    }
      
}