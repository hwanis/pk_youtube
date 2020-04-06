<?php
class class_db extends mysqli implements  ArrayAccess {

    private $params = array();
    
    public function __construct($host, $user, $passwd, $db_name, $port,  $chrset='utf8')
    {    	

    }
    
    public function db_connection( $config_array ){
    	
    	$chrset = 'utf8';
    	$db = parent::__construct($config_array[host], $config_array[user],$config_array[passwd], $config_array[db_name], $config_array[port]);
    	 
    	if (mysqli_connect_error()){
    	    
                echo '<script type="text/javascript">                      
                window.location = "../common/svr_error.php?msg='.mysqli_connect_error().'";
            </script>';
    	//	DbResultCheck(10000, 'db connection', mysqli_connect_error());
    		die(mysqli_connect_error());
    		//throw new ErrorException(mysqli_connect_error(),mysqli_connect_errno());
    		 
    	}
    	 
    	# character set
    	$chrset_is = parent::character_set_name();
    	//echo $chrset_is;
    	if(strcmp($chrset_is,$chrset)) parent::set_charset($chrset);
    	
    	return $db;
	    			
    }
    
    public function gw_db_connection(){

    	$config_array = Array(
    			'host' => "localhost",
    		/*	'user' => "pask",
    			'passwd' => "P2sK@18",
    			'db_name' => "pask"*/
    			'user' => "pk_dev",
    			 'passwd' => "Pyun1!Kang",
    			'db_name' => "asset",
    			'port' => 3306
    			
    	);
    	
    	$db = $this->db_connection( $config_array );
    	
    	return $db; 
    }
    
    public function gw_db_ent_connection(){
    
    	$config_array = Array(
    			 
    			'host' => "localhost",
    			'user' => "missyoon3",
    			'passwd' => "missyoon!.com",
    			'db_name' => "missyoon3",
    			'port' => 3306
    			 
    	);
    	 
    	$db = $this->db_connection( $config_array );
    	 
    	return $db;
    }
    
    public function gw_db_pkmall_connection(){
    
    	$config_array = Array(
    			 
            'host' => "110.10.189.201",
            'user' => "missyoon3",
            'passwd' => "missyoon!.com",
            'db_name' => "missyoon3",
            'port' => 3306
    			 
    	);
    	 
    	$db = $this->db_connection( $config_array );
    	 
    	return $db;
    }

    public function gw_db_wwdoctor_connection(){
    
    	$config_array = Array(
    			 
            'host' => "localhost",
            'user' => "pk_ot_dev",
            'passwd' => "Pk0*D2kang&",
            'db_name' => "pkinteg",
            'port' => 3306
    			 
    	);
    	 
    	$db = $this->db_connection( $config_array );
    	 
    	return $db;
    }
    
    public function gw_db_ship_connection(){
    
    	$config_array = Array(
    			 /*
    			'host' => "localhost",    	
    			'db_name' => "pask",
    			'user' => "pk_dev",
    			 'passwd' => "Pyun1!Kang",
    			'db_name' => "pkshipping",
    			'port' => 3306
    			 */
            'host' => "203.234.230.6",    	            
            'user' => "root",
            'passwd' => "Pyungang01!123",
            'db_name' => "pyeongang",
            'port' => 3306
    	);
    	 
    	$db = $this->db_connection( $config_array );
    	 
    	return $db;
    }
    
    #@ interface : ArrayAccess
    # use : $obj["two"] = "A value";
    public function offsetSet($offset, $value) {
        $this->params[$offset] = parent::real_escape_string($value);
    }

    #@ interface : ArrayAccess
    # use : isset($obj["two"]); -> bool(true)
    public function offsetExists($offset) {
        return isset($this->params[$offset]);
    }

    #@ interface : ArrayAccess
    # use : unset($obj["two"]); -> bool(false)
    public function offsetUnset($offset) {
        unset($this->params[$offset]);
    }

    #@ interface : ArrayAccess
    # use : $obj["two"]; -> string(7) "A value"
    public function offsetGet($offset) {
        return isset($this->params[$offset]) ? $this->params[$offset] : null;
    }

    # @ interface : DBSwitch
    # :s1 -> :[character type]+[variable]
    # variable type, :s1,:sa,:sA, :d1, :d2, :dA ....
    #  :s1, :s1 <- don't duplicate
    public function bindParams($query,$args=array()){
        if(strpos($query,':') !==false){
            preg_match_all("/(\\:[s|d|f|b])+[0-9]+/s",$query,$matches);
            if(is_array($matches))
            {
                foreach($matches[0] as $n => $s)
                {
                    # check! character type and length concord
                    $bindtype = substr($s,1,1);
                    $bvmatched = false;
                    switch($bindtype){
                        case 's': if(is_string($args[$n])) $bvmatched = true; break;
                        case 'd': if(is_int($args[$n])) $bvmatched = true; break;
                        case 'f': if(is_float($args[$n])) $bvmatched = true; break;
                        case 'b': if(is_binary($args[$n])) $bvmatched = true; break;
                    }
                    if($bvmatched){
                        $query = str_replace($s,'%'.$bindtype,$query);
                        $query = sprintf("{$query}",parent::real_escape_string($args[$n]));
                    }else{
                        $query = false;
                        break;
                    }
                }
            }
        }
        return $query;
    }

    function error_message( $ex ){

            $error_message = $ex->getMessage();
            $error_line = $ex->getLine();
            $error_file = $ex->getFile();

            $error_str = 'Query Error :'.$error_message.'<br> Error Line : '.$error_line.'<br> Error File :'.$error_file;

            return $error_str;

    }
    #@ return int
    public function get_total_record($table, $where, $field='*'){
    	
        $wh = ($where) ? " WHERE ".$where : '';
        $a ='SELECT count('.$field.') count FROM '.$table.' '.$wh;
		//echo "total record :".$a."<br>";     
		$record_query = 'SELECT count('.$field.') FROM '.$table.$wh;
		
		//echo $record_query;
		$result  = $this->query($record_query);
        
        try{
            if($result){
            	
                $row = $result->fetch_row();
                
                if($row){
                	
                	return $row[0];
                	
                } else {
                	
                	return $msg = mysqli_errno($this);
                }
                
                
            } 
            
        }catch (Exception $ex)
        {
            die($ex->getMessage());
        }
    }
    
    public function get_groupby_record($fields, $table, $where, $ordered)
    {
    	$query = 'select '.$fields.' from '.$table;
    	if($where != '')
    	{
    		$query = $query.' where '.$where;
    	}
    	
    	if($ordered != '')
    	{
    		$query = $query.' '.$ordered;
    	}
    	
    	//echo $query;
    }

    public function get_groupby_total_record($table, $gb)
    {
        $query = 'SELECT COUNT(*) FROM (SELECT count(*) FROM '.$table.' GROUP BY '.$gb.') a';
        //echo $query."<br>";
        try{
            if($result = parent::query('SELECT COUNT(*) FROM (SELECT count(*) FROM '.$table.' GROUP BY '.$gb.') a' )){
                $row = $result->fetch_row();
                return $row[0];
            }
            else {
            	
            	return mysqli_error($this);
            	
            }
          //  return 0;
        }catch (Exception $ex)
        {
            die($ex->getMessage());
        }
    }

    public function get_record($field, $table, $where){
        
    	$where = ($where) ? " WHERE ".$where : '';
        $qry = "SELECT ".$field." FROM ".$table." ".$where;
        //echo $qry;
        
        try{
        	$result = $this->query($qry);
        	
        	$result_row = mysqli_num_rows($result);
            if( $result_row>0 ){

            	$row = $result->fetch_assoc();
            	return $row;

            } else {

            	if( gettype($result_row) == integer ){
            		
            		$msg = mysqli_error($this);

            		return $result_row;
            		
            	} else {
            		
            		$msg = mysqli_error($this);
            		
            	}
            						
            	return $msg;
            	
            }
            ///return false;
        } catch (Exception $ex){
        	
            die($ex->getMessage());
            
        }
    }
    
    //get multi record
    public function get_record_multi($fields, $table, $where){
    	$where = ($where) ? " WHERE ".$where : '';
    	$query = "SELECT ".$fields." FROM `".$table."` ".$where;
    	//echo $query;
    	try{
    		if($result = $this->query($query,3)){
    
    			$resultRow = Array();
    			while($row = $result->fetch_assoc())
    			{
    				$resultArray = $row;
    				array_push($resultRow,$resultArray);
    			}
    			return $resultRow;
    		}
    
    		///return false;
    	}catch (Exception $ex)
    	{
    		die($ex->getMessage());
    	}
    }
    
    public function call_procedure($st_date, $ed_date){
        $config_array = Array(
    			 
            'host' => "localhost",
        /*	'user' => "pask",
            'passwd' => "P2sK@18",
            'db_name' => "pask"*/
            'user' => "pk_dev",
             'passwd' => "Pyun1!Kang",
            'db_name' => "pkshipping",
            'port' => 3306
    			 
    	);
    	 
    	//$db = $this->db_connection( $config_array );
        
        $result = mysqli_query($this->db_connection($config_array),  "CALL sp_stats('2019-10-01','2019-10-11')") or die("Query fail: " . mysqli_error());        
        return $result;
        
      //  while ($row = mysqli_fetch_array($result)){   
        //    echo $row[0] . " - " . + $row[1]; 
      //  }
        
        
    }
    
    public function get_list( $fields, $table, $where, $ordered ){
    	
    	$where = ($where) ? " WHERE ".$where : '';    	
    	$query = "SELECT ".$fields." FROM ".$table." ".$where.$ordered;
    	//echo $query;
    	try{
    		
    		$result = $this->query( $query );
    		
    		$resultRow = Array();
    		while($row = $result->fetch_assoc())
    		{
    			$resultArray = $row;
    			array_push($resultRow,$resultArray);
    		}
    		
    		return $resultRow;
    		
    		
    	} catch( Exception $ex ){
    		
    		CommonErrorHandler($ex);
    		
    	}
    }
    
    public function get_paging_list($fields, $table, $where, $ordered, $start_limit, $end_limit, $fetch)
    {    	
    	$where = ($where) ? " WHERE ".$where : '';
    	//$ordered = " order by regdt desc ";
    	$limit = ' limit '.$start_limit.' , '.$end_limit;
    	$query = "SELECT ".$fields." FROM ".$table." ".$where.$ordered.$limit;
    	//echo $query;
    	try{
    		$result = $this->query($query,3); 
    		
    		//echo  gettype($result);
    
    		if( gettype($result) != string ){
    	
    			if($fetch == '')
    			{
    				$resultRow = Array();
    				while($row = $result->fetch_assoc())
    				{
    					$resultArray = $row;
    					array_push($resultRow,$resultArray);
    				}
    				
    				return $resultRow;
    			}
    			else 
    			{
    				$resultRow = Array();   	
    				while($row = $result->fetch_row())
    				{
    					$resultArray = $row;
    					array_push($resultRow,$resultArray);
    				}
    				return $resultRow;
    			}
    			
    			
    		} else {

    			return $result_msg = $result;
    			
    		}
    	
    		///return false;
    	}catch (Exception $ex)
    	{
    		CommonErrorHandler($ex);
    	}
    }

    function query($query)
    {
    	
    	//echo $query;		
        $result = parent::query($query);

        try{
            if(!$result){

               return $result = mysqli_error($this);
              
            }
		
            return $result;
        }catch (Exception $ex)
        {
        	//echo"4";
            die($ex->getMessage());
          
        	//CommonErrorHandler($ex);
            
           /* $error_message = $ex->getMessage();
            $error_line = $ex->getLine();
            $error_file = $ex->getFile();           
            $error_str = 'Query Error :'.$error_message.'<br> Error Line : '.$error_line.'<br> Error File :'.$error_file;            
            return $error_str;*/
            
        }
    }

    # @ interface : DBSwitch
    # args = array(key => value)
    # args['name'] = 1, args['age'] = 2;
    public function insert($table){
        $fieldk = '';
        $datav  = '';
      
        if(count($this->params)<1) return false;

        foreach($this->params as $k => $v){

            $fieldk .= sprintf("`%s`,",$k);
            if($k != 'ta_id'){
                $datav .= sprintf("'%s',", parent::real_escape_string($v));
            }else{
                $datav .= sprintf("%s,", parent::real_escape_string($v));
            }
        }

        $fieldk = substr($fieldk,0,-1);
        $datav  = substr($datav,0,-1);
        $this->params = array();
      
        try{
        	
            $query  = sprintf("INSERT INTO `%s` (%s) VALUES (%s)",$table,$fieldk,$datav);
            echo $query;
                      
			
            $ret = $this->query($query);
                       
            return $ret;
            
        } catch (Exception $ex) {
        	
        //    die($ex->getMessage());
            print($ex->getMessage());
        }

       // return $ret;
    }
    

    # @ interface : DBSwitch
    public function update($table,$where)
    {    	        	
    //	echo 'table ;'.$where;
        $fieldkv = '';

        if(count($this->params)<1) return false;
                
        foreach($this->params as $k => $v){
        	
            $fieldkv .= sprintf("`%s`='%s',",$k,parent::real_escape_string($v));
        }

        $fieldkv = substr($fieldkv,0,-1);

        $this->params = array();
        try{
            if($where == "*") {
               $query  = sprintf("UPDATE `%s` SET %s ",$table,$fieldkv);
   
            } else {
                $query  = sprintf("UPDATE `%s` SET %s WHERE %s",$table,$fieldkv, $where);
            }
          //  echo $query;
            $ret = $this->query($query);
          //  return $ret;
            
        } catch (Exception $ex){
        	
            die($ex->getMessage());
            //$query_result = false;
            //return $query_result;
        }
    }

    # @ interface : DBSwitch
    public function delete($table,$where){
    	
    	//echo $table."<br>";
        try
        {
            if($where == "*")
            {
                $query = sprintf("DELETE FROM %s",$table);
            }
            else
            {
                $query = sprintf("DELETE FROM %s WHERE %s",$table,$where);
            }

        //   echo $query."<br>";
       //    exit;
            
            $ret = $this->query($query,6);
            return $ret;
            
        }catch (Exception $ex) {
            die($ex->getMessage());
            //$query_result = false;
            //return $query_result;
        }
    }

    public function get_fetch_column_name( $query ){
    	
    	$i = 0;
    	while( $i < mysqli_num_fields($query)){
    		
    		$meta = mysqli_fetch_field($query, $i);
    		
    		if(!$meta){
    			
    			die("No information available");
    			
    		}
    	}
    	
    	return $meta;
    	
    }

    public function get_column_name($table)
    {
        try
        {           

        	$query = sprintf("SELECT * from %s",$table);
        	
        	//echo $query;
        	
        	if($result = $this->query($query)){

        		$i = 0;
        
        		while($column_info = $result->fetch_field()){
        			
        			//echo $column_info->name."<br>";
        			$output[$i] = $column_info->name;
        			
        			$i++;
        			
        		}
        		
        		return $output;
        		
        	}

            return false;
            
        }
        catch(Exception $ex)
        {
            die($ex->getMessage());
            //$query_result = false;
            //return $query_result;
        }
        
    }
    
    public function getColumnType( $table, $where ){
    	
    	(empty($where)) ? $where = '': $where ='where '.$where; 
    	
    	$query = sprintf( "show fields from %s %s", $table, $where );
    	//echo $query;
    	try{
    		
    		$result = $this->query($query);
    		 
    		if( $result ){
    			
    			//$row = $result->fetch_assoc();
    			//return $row;
    			
    			$i = 0;

    			while($row = $result->fetch_assoc()){
    				 
    				//echo $column_info->name."<br>";
    				//echo $column_info['Field'].'/'.$column_info['Type'].'/'.$column_info['Null'].'/'.$column_info['Key'].'/'.$column_info['Default']."<br>";
    				$output[$i]['Field'] = $row['Field'];
    				$output[$i]['Type'] = $row['Type'];
    				$output[$i]['Null'] = $row['Null'];
    				$output[$i]['Key'] = $row['Key'];
    				$output[$i]['Default'] = $row['Default'];
    				 
    				$i++;
    				 
    			}

    			return $output;
    			
    		}
    		
    		return false;
    		
    	} catch(Exception $ex) {

    		die($ex->getMessage());
   
    	}
    	
    }

    public function getCountColumn($table)
    {
        $query = sprintf("SELECT COUNT(COLUMN_NAME) AS CNTCOLUMN FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '%s'",$table);
        try{
                if($result = $this->query($query,11)){
                $row = $result->fetch_assoc();
                return $row;
            }
            return false;
        }catch(Exception $ex)
        {
            die($ex->getMessage());
            //$query_result = false;
            //return $query_result;
        }
    }

    public function getMaxValue( $field, $table, $where)
    {
        echo 'eeee';
    	if( $where == ''){
    		
        	$query = sprintf("SELECT MAX(".$field.") AS 'maxvalue' FROM %s ",$table);
        	
    	} else {
    		
    		$query = sprintf("SELECT MAX(".$field.") AS 'maxvalue' FROM %s WHERE %s ",$table, $where);
    		
    	}
    	
    	//echo $query;
    	
        try{
            if($result = $this->query($query)){
                $row = $result->fetch_assoc();

               // echo $row[maxvalue];
               // exit;
                return $row;
            }
          //  return false;
        }catch(Exception $ex)
        {
            die($ex->getMessage());
           // $query_result = false;
           // return $ex;
        }
        
        
    }
    
    public function ConfigBoard($param_array)
    {		
    	$page = $param_array['page'];
    	$page_size = $param_array['page_size'];
    	$block_size = $param_array['block_size'];
    	$fields = $param_array['fields'];
    	$table = $param_array['table'];
    	$where = $param_array['where'];
    	$ordered = $param_array['ordered'];
    	$tag = $param_array['tag'];
    
    	switch($tag)
    	{
            case 'view' : $fetch='array';
            case 'group' :$fetch = '';break;
            case 'userlist' :  $fetch=''; break;
            default : $fetch = '';$where = "";break;
    	}
        	
    	if(!$page) $page=1;
    	
    	//$tablename = explode(".",$table);
    		
    	//for get current page record
    	if($page == 1)
    	{
            $start_page = 0;
    	}
    	else
    	{
    		$start_page = ($page-1)*$page_size;
    	}
    	
    	$end_page = $page_size;
    
    	$start_limit = $start_page;
    	$end_limit = $end_page;

    	try{
    		
    		$get_data = $this->get_paging_list($fields, $table, $where, $ordered, $start_limit, $end_limit, $fetch);
    		
    		if( gettype($get_data) == string )
    		{
    			//die('Error[GetUsers] : all paging access error');
    			return $get_data;
    		}
    		
    		//return $get_data;
    		
    	} catch (Exception $ex){
    		
    		die( 'Select Error');
    		
    	}
    
    
    	//current page record count
    	$current_page_count = count($get_data);
    	
    	//get full record count
    	$total_record = $this->get_total_record($table,$where);

    	//get total page count
    	if($total_record % $page_size==0)
    	{
    		$total_block = floor($total_record/$page_size);
    	}
    	else
    	{
    		$total_block = floor($total_record/$page_size)+1;
    	}
    
    	
    	
    	$total_section = floor($total_block/$block_size);
    	$current_secion = floor(($page-1)/$block_size);
    
    	$block = floor(($page-1)/$block_size);
    
    	//start block number
    	if($current_secion==0)
    	{
    		$page_block_start = 1;
    	}
    	else
    	{
    		$page_block_start=$current_secion*$block_size+1;
    	}
    
    	//end block number
    
    	if($block_size>=$total_block)
    	{
    		$page_block_end = $total_block;
    	}
    	else
    	{
    		if($current_secion<$total_section)
    		{
    			$page_block_end = ($current_secion+1)*10;
    		}
    		else
    		{
    			$page_block_end = $current_secion*10+($total_block%$block_size);
    		}
    	}
    
    	$result_array = Array(
    			'board_list'=>$get_data,
    			'total_block'=>$total_block,
    			'page_block_start'=>$page_block_start,
    			'page_block_end'=>$page_block_end,
    			'current_page_count'=>$current_page_count,
    			'total_record'=>$total_record
    	);
    
    	return $result_array;
    }

    public function __get($propertyName){
        if(property_exists(__CLASS__,$propertyName)){
            return $this->{$propertyName};
        }
    }

    public function __destruct(){
        parent::close();
    }
}