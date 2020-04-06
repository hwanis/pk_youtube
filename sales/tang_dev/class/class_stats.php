<?php

class class_stats extends class_db {
	
	public function __construct(){
		
		$this->gw_db_ent_connection();
	}
	
	//전체 구매횟수 리스트
	public function getOrderList($tag, $count){

			switch($tag){

				case "a" :
                                        $query = "select  mb_id, od_name, count(mb_id) cnt, od_id,   '정회원' as mem, it_name, od_b_hp,  addr,
                                                                         zip, od_time, sum(ct_qty) ct_qty, sum(ct_price) ct_price	 from (
                                                                                        select  a.mb_id, od_app_no,  a.od_id, od_name,  count(a.mb_id) cnt ,  '정회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
                                                                        CONCAT(od_b_zip1, od_b_zip2) zip, od_time, ct_qty, ct_price	 from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id	where od_status in ('완료') and a.mb_id != ''
                                                                                group by a.mb_id, a.od_id order by a.mb_id	) aa group by mb_id having cnt = ".$count."

                                                                        union all												

                                                                                select  mb_id, od_name, count(od_name) cnt, od_id,  '정회원' as mem, it_name, od_b_hp,  addr,
                                                                         zip, od_time,  sum(ct_qty) ct_qty, sum(ct_price) ct_price	 from (
                                                                                        select  a.mb_id, a.od_name, od_app_no, a.od_id,  count(a.mb_id) cnt ,  '정회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
                                                                        CONCAT(od_b_zip1, od_b_zip2) zip, od_time, ct_qty, ct_price	 from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id	where od_status in ('완료') and a.mb_id = ''
                                                                                group by a.od_name, a.od_id order by a.od_name	) aa group by od_name having cnt =  ".$count." limit 1500";
				break;

				case "m" :
							$query = "select  mb_id, od_name,count(mb_id) cnt, od_id, od_name,  '정회원' as mem, it_name, od_b_hp,  addr,
											 zip, od_time,  sum(ct_qty) ct_qty, sum(ct_price) ct_price	 from (
													select  a.mb_id, od_app_no, a.od_id, od_name,  count(a.mb_id) cnt ,  '정회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
											CONCAT(od_b_zip1, od_b_zip2) zip, od_time, ct_qty, ct_price	 from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id	where od_status in ('완료') and a.mb_id != ''
												group by a.mb_id, a.od_id order by a.mb_id	) aa group by mb_id having cnt = ".$count." limit 1500";
				break;



				case "n" :
							$query = "	select  od_name, count(od_name) cnt, od_id,  '정회원' as mem, it_name, od_b_hp,  addr,
											 zip, od_time,  sum(ct_qty) ct_qty, sum(ct_price) ct_price	 from (
													select  a.od_name, od_app_no, a.od_id,  count(a.mb_id) cnt ,  '정회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
											CONCAT(od_b_zip1, od_b_zip2) zip, od_time, ct_qty, ct_price	 from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id	where od_status in ('완료') and a.mb_id = ''
												group by a.od_name, a.od_id order by a.od_name	) aa group by od_name having cnt = ".$count." limit 1500";
				break;


				case "c" :
							$query = "SELECT cnt, COUNT(cnt) AS tot_cnt FROM (
							SELECT a.od_name, COUNT(a.od_name) cnt FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  od_email LIKE 'pyunkang%' 
							AND od_status in ('완료')
							GROUP BY a.od_name ORDER BY cnt, a.od_name
							) c GROUP BY cnt  limit 1500";
				break;


			}
		
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


	//회원별 구매수량 리스트
	public function getBuyCountList($tag, $count){

			switch($tag){

				case "a" :
						$query = "	SELECT a.mb_id, od_app_no, a.od_id, od_name, '정회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
											CONCAT(od_b_zip1, od_b_zip2) zip, od_time, ct_qty,  ct_price  FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  a.mb_id != '' 
											AND od_status in ('완료') 
											and ct_qty = ".$count."

									union all
										
										SELECT a.mb_id, od_app_no, a.od_id, od_name, '정회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
											CONCAT(od_b_zip1, od_b_zip2) zip, od_time, ct_qty,  ct_price  FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  a.mb_id = '' 
											AND od_status in ('완료') 
											and ct_qty =".$count;

				break;

				case "m" :
							$query = "SELECT a.mb_id, od_app_no, a.od_id, od_name, '정회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
											CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,  ct_price*ct_qty ct_price  FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  a.mb_id != '' 
											AND od_status in ('완료') 
											and ct_qty = ".$count;
				break;

				case "n" :
							$query = "SELECT a.mb_id, od_app_no, a.od_id, od_name, '정회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
											CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price  FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  a.mb_id = '' 
											AND od_status in ('완료') 
											and ct_qty = ".$count;
				break;

				case "c" :
							$query = "SELECT cnt, sum(cnt) AS tot_cnt FROM (
							SELECT a.od_name, COUNT(a.od_name)*ct_qty cnt FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  od_email LIKE 'pyunkang%' 
							AND od_status in (''완료')
							GROUP BY a.od_name ORDER BY cnt, a.od_name
							) c GROUP BY cnt;";
				break;

			}
			
		//	echo $query;
			
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


	//전체 구매횟수 리스트
	public function getPdList($tag, $count){

				switch($tag){

				case "a" :
						$query = "  select cnt ct_qty, count(cnt) tot_cnt from (
							 select mb_id, count(mb_id) cnt from (
								 SELECT   a.mb_id,  count(a.mb_id) tot_cnt, a.od_id  FROM g5_shop_order a, g5_shop_cart b 
									WHERE a.od_id = b.od_id AND a.mb_id != '' AND od_status in ('완료') AND b.it_name ='".$pdt."'  
										GROUP BY  a.mb_id, od_id)aa group by mb_id
						 union all												

							select od_name, count(od_name) cnt from (
								SELECT   a.od_name,  count(a.od_name) tot_cnt, a.od_id  FROM g5_shop_order a, g5_shop_cart b 
									WHERE a.od_id = b.od_id AND a.mb_id = '' AND od_status in ('완료') AND b.it_name ='".$pdt."'  
										GROUP BY  a.od_name, od_id) aa group by od_name) cc group by cnt";
				break;

				case "m" :
						$query = "	select cnt ct_qty, count(cnt) tot_cnt from (
												select mb_id, count(mb_id) cnt from (
												SELECT   a.mb_id,  count(a.mb_id) tot_cnt, a.od_id  FROM g5_shop_order a, g5_shop_cart b 
												WHERE a.od_id = b.od_id AND a.mb_id != '' AND od_status in ('완료') AND b.it_name ='".$pdt."'  
												GROUP BY  a.mb_id, od_id
												order by a.mb_id) aa group by mb_id) bb group by cnt";
				break;

				case "n" :
					$query = "select cnt ct_qty, count(cnt) tot_cnt from (
									select od_name, count(od_name) cnt from (
										SELECT   a.od_name,  count(a.od_name) tot_cnt, a.od_id  FROM g5_shop_order a, g5_shop_cart b 
										WHERE a.od_id = b.od_id AND a.mb_id = '' AND od_status in ('완료') AND b.it_name ='".$pdt."'  
											GROUP BY  a.od_name, od_id
											order by a.od_name) aa group by od_name) bb group by cnt";
				break;

			/*	case "c" :
							$query = "SELECT cnt, sum(cnt) AS tot_cnt FROM (
							SELECT a.od_name, COUNT(a.od_name)*ct_qty cnt FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  od_email LIKE 'pyunkang%' 
							AND od_status in (''완료')
							GROUP BY a.od_name ORDER BY cnt, a.od_name
							) c GROUP BY cnt;";
				break;
				*/
			}
			
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

	//회원 유형별 리스트
	public function getTypeOrderList(){
	
			$query = "SELECT a.mb_id, od_name,  count(a.mb_id) cnt ,  sum(ct_qty) sum_qty, '정회원' mb_status  FROM g5_shop_order a, g5_shop_cart b 
								WHERE a.od_id = b.od_id and a.mb_id != '' and od_status in ('완료')  GROUP BY a.mb_id

								UNION ALL

								SELECT a.mb_id, od_name, count(a.od_name) cnt ,  sum(ct_qty) sum_qty, '비회원' mb_status FROM g5_shop_order a, g5_shop_cart b 
								WHERE a.od_id = b.od_id and a.mb_id = '' and od_status in ('완료')  GROUP BY a.od_name ";
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

//제품별 구매횟수 리스트
	public function getPdBuyCountList($tag, $count, $pd_name){

			switch($tag){

				case "a" :
						$query = " SELECT  a.mb_id, count(a.mb_id) cnt, od_app_no, a.od_id, od_name, '정회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
													CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price  FROM g5_shop_order a, g5_shop_cart b 
										WHERE a.od_id = b.od_id AND a.mb_id != '' AND od_status in ('완료') AND b.it_name = '".$pd_name."'    
										group by a.mb_id	having cnt = ".$count."
										  
										   union all 
											
										SELECT  a.mb_id, count(a.od_name) cnt, od_app_no, a.od_id, od_name, '준회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
													CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price  FROM g5_shop_order a, g5_shop_cart b 
										WHERE a.od_id = b.od_id AND a.mb_id = '' AND od_status in ('완료') AND b.it_name = '".$pd_name."'  
										group by a.od_name	having cnt = ".$count;

				break;

				case "m" :
							$query = "SELECT  a.mb_id, count(a.mb_id) cnt, od_app_no, a.od_id, od_name, '정회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
											CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price  FROM g5_shop_order a, g5_shop_cart b 
											WHERE a.od_id = b.od_id AND a.mb_id != '' AND od_status in ('완료') AND b.it_name ='".$pd_name."'  
											group by a.mb_id	having cnt = ".$count;
				break;

				case "n" :
							$query = "SELECT  a.od_name, count(a.od_name) cnt, od_app_no, a.od_id, '준회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
											CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price  FROM g5_shop_order a, g5_shop_cart b 
											WHERE a.od_id = b.od_id AND a.mb_id = '' AND od_status in ('완료') AND b.it_name ='".$pd_name."'  
											group by a.od_name	having cnt = ".$count;
				break;

				case "c" :
							$query = "SELECT cnt, sum(cnt) AS tot_cnt FROM (
							SELECT a.od_name, COUNT(a.od_name)*ct_qty cnt FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  od_email LIKE 'pyunkang%' 
							AND od_status in (''완료')
							GROUP BY a.od_name ORDER BY cnt, a.od_name
							) c GROUP BY cnt;";
				break;

			}
			
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


	//제품별 구매수량 리스트
	public function getPdBuySumCountList($tag, $count, $pd_name){

			switch($tag){

				case "a" :
						$query = " SELECT a.mb_id, sum(ct_qty) cnt,  od_app_no, a.od_id, od_name, '준회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
													CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  a.mb_id != '' 
														AND od_status in ('완료') AND it_name = '".$pd_name."' 
												GROUP BY mb_id  having cnt = ".$count." 
										  
										   union all 
											
										SELECT a.mb_id, sum(ct_qty) cnt,  od_app_no, a.od_id, od_name, '준회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
													CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  a.mb_id = '' 
														AND od_status in ('완료') AND it_name = '".$pd_name."' 
												GROUP BY od_name  having cnt = ".$count;

				break;

				case "m" :
							$query = "SELECT a.mb_id, sum(ct_qty) cnt,  od_app_no, a.od_id, od_name, '정회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
													CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  a.mb_id != '' 
														AND od_status in ('완료') AND it_name = '".$pd_name."' 
												GROUP BY mb_id  having cnt = ".$count." ORDER BY cnt, a.mb_id ";
				break;

				case "n" :
							$query = "SELECT a.mb_id, sum(ct_qty) cnt,  od_app_no, a.od_id, od_name, '준회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
													CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  a.mb_id = '' 
														AND od_status in ('완료') AND it_name = '".$pd_name."' 
												GROUP BY od_name  having cnt = ".$count." ORDER BY cnt, a.od_name";
				break;

				case "c" :
							$query = "SELECT cnt, sum(cnt) AS tot_cnt FROM (
							SELECT a.od_name, COUNT(a.od_name)*ct_qty cnt FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  od_email LIKE 'pyunkang%' 
							AND od_status in (''완료')
							GROUP BY a.od_name ORDER BY cnt, a.od_name
							) c GROUP BY cnt;";
				break;

			}
			
		//	echo $query;
			
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

	
	//회원별 구매횟수
	public function getReBuyDashBoard($tag){

			switch($tag){

				case "a" :
							$query = "SELECT cnt, count(cnt) tot_cnt from (
												select  mb_id, count(mb_id) cnt from (
									select  a.mb_id, od_app_no, od_time from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id	where od_status in ('완료') and a.mb_id != ''
										group by a.mb_id, a.od_id order by a.mb_id	) aa group by mb_id

												UNION ALL

												select  od_name, count(od_name) cnt from (
									select  od_name, od_app_no, od_time from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id	where od_status in ('완료') and a.mb_id = ''
										group by a.od_name, a.od_id order by a.od_name	) aa group by od_name
												) a GROUP BY cnt";
				break;

				case "m" :
							$query = "select cnt, count(cnt) tot_cnt from (
												select  mb_id, count(mb_id) cnt from (
													select  a.mb_id, od_app_no, od_time from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id	where od_status in ('완료') and a.mb_id != ''
												group by a.mb_id, a.od_id order by a.mb_id	) aa group by mb_id
										) bb group by cnt";
				break;

				case "n" :
							$query = "select cnt, count(cnt) tot_cnt from (
												select  od_name, count(od_name) cnt from (
													select  od_name, od_app_no, od_time from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id	where od_status in ('완료') and a.mb_id = ''
											group by a.od_name, a.od_id order by a.od_name	) aa group by od_name
										) bb group by cnt";
				break;


				case "c" :
							$query = "SELECT cnt, COUNT(cnt) AS tot_cnt FROM (
							SELECT a.od_name, COUNT(a.od_name) cnt FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  od_email LIKE 'pyunkang%' 
							AND od_status in ('완료')
							GROUP BY a.od_name ORDER BY cnt, a.od_name
							) c GROUP BY cnt;";
				break;


			}
			
		//	echo $query;
			
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


	
		//회원별 구매수량
	public function getBuyCountDashBoard($tag){

			switch($tag){

				case "a" :
						$query = "	select h cnt, count(h) tot_cnt from (
							SELECT a.mb_id f,  ct_qty h  FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  a.mb_id != '' 
							AND od_status in ('완료') 
							 union all
							SELECT a.mb_id, ct_qty  FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  a.mb_id = '' 
							AND od_status in ('완료') ) aa group by h";

				break;

				case "m" :
							$query = "	select h cnt, count(h) tot_cnt from (
							SELECT a.mb_id f,  ct_qty h  FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  a.mb_id != '' 
							AND od_status in ('완료') 
							 ) aa group by h";
				break;

				case "n" :
							$query = "	select h cnt, count(h) tot_cnt from (
							SELECT a.mb_id f, ct_qty h  FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  a.mb_id = '' 
							AND od_status in ('완료') ) aa group by h";
				break;

				case "c" :
							$query = "SELECT cnt, sum(cnt) AS tot_cnt FROM (
							SELECT a.od_name, count(a.od_name)*ct_qty cnt FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  od_email LIKE 'pyunkang%' 
							AND od_status in (''완료')
							GROUP BY a.od_name ORDER BY cnt, a.od_name
							) c GROUP BY cnt;";
				break;

			}
			
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

	//제품별 구매횟수
	public function getPdCountDashBoard($tag, $pd_name){

			switch($tag){

				case "a" :
						$query = "  select cnt ct_qty, count(cnt) tot_cnt from (
							 select mb_id, count(mb_id) cnt from (
								 SELECT   a.mb_id,  count(a.mb_id) tot_cnt, a.od_id  FROM g5_shop_order a, g5_shop_cart b 
									WHERE a.od_id = b.od_id AND a.mb_id != '' AND od_status in ('완료') AND b.it_name ='".$pd_name."'  
										GROUP BY  a.mb_id, od_id)aa group by mb_id
						 union all												

							select od_name, count(od_name) cnt from (
								SELECT   a.od_name,  count(a.od_name) tot_cnt, a.od_id  FROM g5_shop_order a, g5_shop_cart b 
									WHERE a.od_id = b.od_id AND a.mb_id = '' AND od_status in ('완료') AND b.it_name ='".$pd_name."'  
										GROUP BY  a.od_name, od_id) aa group by od_name) cc group by cnt";
				break;

				case "m" :
						$query = "	select cnt ct_qty, count(cnt) tot_cnt from (
												select mb_id, count(mb_id) cnt from (
												SELECT   a.mb_id,  count(a.mb_id) tot_cnt, a.od_id  FROM g5_shop_order a, g5_shop_cart b 
												WHERE a.od_id = b.od_id AND a.mb_id != '' AND od_status in ('완료') AND b.it_name ='".$pd_name."'  
												GROUP BY  a.mb_id, od_id
												order by a.mb_id) aa group by mb_id) bb group by cnt";
				break;

				case "n" :
					$query = "select cnt ct_qty, count(cnt) tot_cnt from (
									select od_name, count(od_name) cnt from (
										SELECT   a.od_name,  count(a.od_name) tot_cnt, a.od_id  FROM g5_shop_order a, g5_shop_cart b 
										WHERE a.od_id = b.od_id AND a.mb_id = '' AND od_status in ('완료') AND b.it_name ='".$pd_name."'  
											GROUP BY  a.od_name, od_id
											order by a.od_name) aa group by od_name) bb group by cnt";
				break;

			/*	case "c" :
							$query = "SELECT cnt, sum(cnt) AS tot_cnt FROM (
							SELECT a.od_name, COUNT(a.od_name)*ct_qty cnt FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  od_email LIKE 'pyunkang%' 
							AND od_status in (''완료')
							GROUP BY a.od_name ORDER BY cnt, a.od_name
							) c GROUP BY cnt;";
				break;
				*/
			}
			
		//	echo $query;
			
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

	//제품별 구매수량
	public function getPdSumDashBoard($tag, $pdt){

			switch($tag){

				case "a" :
						$query = "SELECT cnt, count(cnt) tot_cnt FROM (
											SELECT a.mb_id, sum(ct_qty) cnt,  od_app_no, a.od_id, od_name, '준회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
													CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price FROM g5_shop_order a , g5_shop_cart b 
													WHERE a.od_id = b.od_id AND  a.mb_id != '' 
														AND od_status in ('완료') AND it_name = '구전녹용 순'
												GROUP BY mb_id

											UNION ALL	
														
											SELECT a.mb_id, sum(ct_qty) cnt,  od_app_no, a.od_id, od_name, '준회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
													CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price FROM g5_shop_order a , g5_shop_cart b 
													WHERE a.od_id = b.od_id AND  a.mb_id = '' 
														AND od_status in ('완료') AND it_name = '구전녹용 순'
												GROUP BY od_name  
											) c GROUP BY  cnt ORDER BY cnt ";
				break;

				case "m" :
							$query = "		 SELECT cnt,  count(cnt) tot_cnt FROM (
												SELECT a.mb_id, sum(ct_qty) cnt,  od_app_no, a.od_id, od_name, '정회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
													CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price FROM g5_shop_order a , g5_shop_cart b 
													WHERE a.od_id = b.od_id AND  a.mb_id != '' 
														AND od_status in ('완료') AND it_name = '".$pdt."'
												GROUP BY mb_id  ORDER BY cnt, a.mb_id
										) a GROUP BY cnt";
				break;

				case "n" :
							$query = " SELECT cnt,  count(cnt) tot_cnt FROM (
												SELECT a.mb_id, sum(ct_qty) cnt,  od_app_no, a.od_id, od_name, '준회원' as mem, it_name, od_b_hp, concat(od_b_addr1, od_b_addr2, od_b_addr3) addr,
													CONCAT(od_b_zip1, od_b_zip2) zip, od_time,  ct_qty,   ct_price*ct_qty ct_price FROM g5_shop_order a , g5_shop_cart b 
													WHERE a.od_id = b.od_id AND  a.mb_id = '' 
														AND od_status in ('완료') AND it_name = '".$pdt."'
												GROUP BY od_name  ORDER BY cnt, a.od_name
										) a GROUP BY cnt";
				break;


			/*	case "c" :
							$query = "SELECT cnt, sum(cnt) AS tot_cnt FROM (
							SELECT a.od_name, COUNT(a.od_name)*ct_qty cnt FROM g5_shop_order a , g5_shop_cart b WHERE a.od_id = b.od_id AND  od_email LIKE 'pyunkang%' 
							AND od_status in (''완료')
							GROUP BY a.od_name ORDER BY cnt, a.od_name
							) c GROUP BY cnt;";
				break;
				*/


			}
			
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

	//회원별 결제 인원
	public function getSummaryBuy($tag){

		switch($tag){

			case "m" : 
				$query = "SELECT COUNT(a.mb_id) cnt FROM g5_shop_order a INNER JOIN g5_shop_cart b ON a.od_id = b.od_id
								WHERE od_receipt_price > 0 AND od_status IN ('완료') AND a.mb_id != '' " ;
				break;

				/*
				-- 비회원 결제회원
				select a.od_name, count(distinct(a.od_name))  from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id
				where od_receipt_price > 0 and a.mb_id = '' and od_email like 'pyunkang%';
				-- 콜센터
				select a.od_name, count(distinct(a.od_name))  from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id
				where od_receipt_price > 0 and a.mb_id = '' and od_email not like 'pyunkang%';

			*/
			case "n" : 
				$query = "	SELECT  COUNT(DISTINCT(a.od_name)) cnt  FROM g5_shop_order a INNER JOIN g5_shop_cart b ON a.od_id = b.od_id
								WHERE od_receipt_price > 0 AND a.mb_id = '' AND od_status IN ('완료') ";
				break;
			case "c" : 
				$query = "	SELECT a.od_name, COUNT(DISTINCT(a.od_name)) cnt  FROM g5_shop_order a INNER JOIN g5_shop_cart b ON a.od_id = b.od_id
								WHERE od_receipt_price > 0 AND a.mb_id = '' and od_email not like 'pyunkang%'";
				break;

		}
				
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



//회원별 재구매 인원
/*
	재구매 기준  : od_app_no 별도

*/
	public function getSummaryReBuy($tag){

		switch($tag){

			case "m" : 
				$query = "select  count(mb_id) cnt from (
									select  a.mb_id, od_app_no, od_time from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id	where od_status in ('완료') and a.mb_id != ''
										group by a.mb_id, a.od_id order by a.mb_id	) aa group by mb_id having cnt > 1";
				break;

			case "n" : 
				$query = "select  count(od_name) cnt from (
									select  a.od_name, od_app_no, od_time from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id	where od_status in ('완료') and a.mb_id = ''
										group by a.od_name, a.od_id order by a.od_name) aa group by od_name having cnt > 1";
				break;
	
		}
			
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

	//크로스 세일 인원
	public function getSummaryCrossBuy($tag){

		switch($tag)
		{
			case "m" : $cond = "!=''"; break;
			case "n" : $cond = "=''"; break;
		}

		$query =  "SELECT COUNT(mb_id) cnt FROM (
							SELECT a.mb_id,  it_name FROM g5_shop_order a INNER JOIN g5_shop_cart b ON a.od_id = b.od_id WHERE od_status IN ('완료') AND a.mb_id". $cond."
								GROUP BY a.mb_id, it_name ) aa GROUP BY mb_id HAVING cnt > 1";
		
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


	//제품별 재구매
	public function getSummaryPdReBuy($tag, $pd){

		switch($tag)
		{
			case "m" : $cond = "!=''";  $field = "a.mb_id"; $g_field ="mb_id"; break;
			case "n" : $cond = "=''"; $field="a.od_name"; $g_field ="od_name"; break;
		}

		$query =  " SELECT  ".$g_field.", COUNT(".$g_field.") cnt FROM (
						SELECT ". $field.", COUNT(".$field.") cnt FROM g5_shop_order a INNER JOIN g5_shop_cart b ON a.od_id = b.od_id
							WHERE od_status in ('완료') and a.mb_id ". $cond." AND it_name = '".$pd."' GROUP BY ".$field.", a.od_id 
							) AA GROUP BY ".$g_field." HAVING cnt > 1";

	//	echo $query;
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

    public function memConfiuration($mem, $tag){

        switch($tag){

            case "con_m" : $wh = " != '' AND od_status IN ('완료','입금','주문','취소') "; break;
            case "con_n" : $wh = " = '' AND od_status IN ('완료','입금','주문','취소') "; break;
            case "buy_m" : $wh = "!= '' AND od_status IN ('완료') "; break;
            case "buy_n" : $wh = " = '' AND od_status IN ('완료') "; break;
        }

        switch($mem){

            case "m" :
                $query = "select a.od_id mem from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id where a.mb_id ".$wh."  group by a.mb_id";
                break;
            case "n" :
                $query = "	select  a.od_name mem from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id where a.mb_id ".$wh." group by a.od_name";
                break;

        }
        //	echo $query;
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

    //전체 구매횟수 리스트
    public function memAllArea(){

        $query = "	select  si_do, count(si_do) cnt from(
							select concat(od_b_zip1,od_b_zip2) zipcode from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id where od_status in ('완료')
							 ) oc inner join 
							 (select postcode, si_do from post_code group by postcode )pc
							 on oc.zipcode = pc.postcode
							 group by si_do order by cnt desc";


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


    //서울 지역 구매 비율
    public function memSeoArea(){

        $query = "	select  gun, count(gun) cnt from(
					select concat(od_b_zip1,od_b_zip2) zipcode from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id where od_status in ('완료')
					 ) oc inner join 
					 (
						select * from post_code where si_do like '서울%' group by postcode 
					)pc
					 on oc.zipcode = pc.postcode
					 group by gun order by cnt desc";

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

    //경기 지역 구매 비율
    public function memKyungArea(){

        $query = "select gu_gun_code, sum(cnt) cnt, gun_name from (

					 select zipcode, si_do, gun, count(gun) cnt, si_do_code, gu_gun_code, gun_name from(
					select concat(od_b_zip1,od_b_zip2) zipcode from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id where od_status in ('완료')
					 ) oc inner join 
					 (
						select * from post_code where si_do like '%경기%' group by postcode
					)pc
					 on oc.zipcode = pc.postcode
					 group by gun
					 ) aaa group by gu_gun_code order by cnt desc";

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

    //발신지와 배달지가 다른 데이터
    public function memAddr($tag){

        switch($tag)
        {
            case "o" : $cond = "  and od_name != od_b_name "; break;
            case "a" : $cond ="  and od_name= od_b_name "; break;
        }

        $query = "select a.mb_id, replace(od_name, ' ','') , replace(od_b_name, ' ','') 
						from g5_shop_order a inner join g5_shop_cart b on a.od_id = b.od_id where od_status in ('완료')   ".$cond." group by a.od_id";

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