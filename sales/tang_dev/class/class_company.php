<?php

class class_company extends class_db {
	
	public function __construct(){
		
		$this->gw_db_connection();
	}
	
	//전체 구매횟수 리스트
	public function getCompanyList(){
									
		$query = "SELECT company_id, company_name FROM company";

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

	}

    public function getCompanyName($comp_id){
        //et_record($field, $table, $where)
        $query = "SELECT company_name FROM company WHERE company_id = ".$comp_id;

        $result =  $this->get_record('company_name', 'company', "company_id = '".$comp_id."'" );

        if(gettype($result) == string){
            echo $result;
        }

        return $result;

    }

			//전체 구매횟수 리스트
	public function getDepartMentList($company_id){
									
		$where = '';

		if($company_id != '') $where = " WHERE company_id = ".$company_id;
		$query = "SELECT * FROM department".$where;

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

	}

}