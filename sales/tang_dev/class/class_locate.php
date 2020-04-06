<?php

class class_locate extends class_db {
	
	public function __construct(){
		
		$this->gw_db_connection();
	}
	
	//전체 구매횟수 리스트
	public function getBuildingList(){
									
		$query = "SELECT * FROM locate WHERE loc_tag = 1 and use_yn = 1";

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

		public function getFloorList($loc_top){

		
		($loc_top)?$wh = " loc_top = ".$loc_top." AND ":$wh = " ";	

		$query = "SELECT * FROM locate WHERE ".$wh." loc_tag = 2";
//		$query = "SELECT * FROM locate WHERE loc_tag = 2";

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

	public function getFloorListId($floor_id){
									
		$query = "SELECT * FROM locate WHERE loc_top = ".$floor_id." AND loc_tag = 2";
//		$query = "SELECT * FROM locate WHERE loc_id = ".$floor_id;

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

	public function getTeamList($loc_mid, $building){

		if($loc_mid != '' && $building != ''){
			$wh =  "loc_top = ".$building." AND loc_mid = ".$loc_mid." AND use_yn = 1 AND ";
		}else{
			$wh = '';
		}
									
		$query = "SELECT * FROM locate WHERE ".$wh." loc_tag = 3";
//		$query = "SELECT * FROM locate WHERE  loc_tag = 3";
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

	public function getLocateName($loc_top, $loc_mid, $loc_bottom){

			try{
			$fields = ' loc_name ';
			$table = 'locate';
			$where = " loc_top =".$loc_top." AND loc_mid = ".$loc_mid." AND loc_bottom = ".$loc_bottom;
			
			$get_data = $this->get_record($fields, $table, $where);
			return $get_data;
	
		} catch ( Exception $ex ){
			die($ex->getMessage());	
		}
	}

	public function getLocateNameId($locate_id){

			try{
			$fields = ' loc_name ';
			$table = 'locate';
			$where = " loc_id =".$locate_id;
			
			$get_data = $this->get_record($fields, $table, $where);
			return $get_data;
	
		} catch ( Exception $ex ){
			die($ex->getMessage());	
		}
	}

    public function getLocateEmp($emp_id, $locate_id){

        try{
            $fields = '  COUNT(*) cnt ';
            $table = 'emp_locate';
            $where = " emp_id =".$emp_id." AND loc_id = ".$locate_id;

            $get_data = $this->get_record($fields, $table, $where);
            return $get_data;

        } catch ( Exception $ex ){
                die($ex->getMessage());
        }
    }

}