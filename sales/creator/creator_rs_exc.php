<?php
    require_once "../class/class_db.php";
    require_once '../class/class_creator.php';
    require_once "../lib/PHPExcel.php";
    
    $objPHPExcel = new PHPExcel();  
    $obj = new class_creator();
    
    $list_cnt =  $obj->getCreatorRs($_REQUEST[page_no], $_REQUEST[page_list_no], $_REQUEST[where], $_REQUEST[req_s_id], 'cnt');  

    $arrStats = Array();

    for($i=0;$i<count($list_cnt);$i++){
        $obj_rs = new class_creator();
        $rs = $obj_rs->getCtSalesRs($list_cnt[$i][ct_id], $list_cnt[$i][sal_date]);
        
        $arrStats[$i+1] = array(        
            'od_date' => $list_cnt[$i][sal_date], 
            'ct_traffic' => $list_cnt[$i][sal_traffic],            
            'd_tot_qty' => $list_cnt[$i][d_tot_qty],       
            'revert' => round((int)$list_cnt[$i][d_tot_qty]/(int)$list_cnt[$i][sal_traffic],3), 
            'd_tot_price' => $list_cnt[$i][d_tot_price], // 총 매출액
            'diff_price_rs' => (int)$list_cnt[$i][d_tot_price]-$list_cnt[$i][d_tot_price]*($rs[sal_rs]/100), //매출액 - RS
            'sal_rs' => $rs[sal_rs], //RS
            'diff_sal_rs' => $list_cnt[$i][d_tot_price]*($rs[sal_rs]/100)   
            // 유튜버 수수료 액
            
        );
    }

    //엑셀 열 명칭
    $objPHPExcel -> setActiveSheetIndex(0)
                -> setCellValue("A1", "주문일자")
                -> setCellValue("B1", "유입건수")
                -> setCellValue("C1", "판매수")
                -> setCellValue("D1", "전환")
                -> setCellValue("E1", "매출액")
                -> setCellValue("F1", "매출액-RS")
                -> setCellValue("G1", "RS")
                -> setCellValue("H1", "수수료 액")            
    ;

    $count_s = 1;

//엑셀에 입력될 데이터
foreach($arrStats as $key => $val) {

    $num = 1 + $key;

    $objPHPExcel -> setActiveSheetIndex(0)

    -> setCellValue(sprintf("A%s", $num),  $val['od_date'])
    -> setCellValue(sprintf("B%s", $num), $val['ct_traffic'])
    -> setCellValueExplicit(sprintf("C%s", $num), $val['d_tot_qty'])
    -> setCellValue(sprintf("D%s", $num),  $val['revert'])
    -> setCellValue(sprintf("E%s", $num), $val['d_tot_price'])
    -> setCellValueExplicit(sprintf("F%s", $num), $val['diff_price_rs'])
    -> setCellValue(sprintf("G%s", $num),  $val['sal_rs'])
    -> setCellValue(sprintf("H%s", $num), $val['diff_sal_rs']);
    
    $count_s++;

}

// 엑셀 서식
// 가로 넓이 조정
$objPHPExcel -> getActiveSheet() -> getColumnDimension("A") -> setWidth(30);
$objPHPExcel -> getActiveSheet() -> getColumnDimension("B") -> setWidth(30);
$objPHPExcel -> getActiveSheet() -> getColumnDimension("C") -> setWidth(30);
$objPHPExcel -> getActiveSheet() -> getColumnDimension("D") -> setWidth(30);
$objPHPExcel -> getActiveSheet() -> getColumnDimension("E") -> setWidth(30);
$objPHPExcel -> getActiveSheet() -> getColumnDimension("F") -> setWidth(30);
$objPHPExcel -> getActiveSheet() -> getColumnDimension("G") -> setWidth(30);
$objPHPExcel -> getActiveSheet() -> getColumnDimension("H") -> setWidth(30);
  
    // 전체 가운데 정렬
$objPHPExcel -> getActiveSheet() -> getStyle(sprintf("A1:H%s", $count_s)) -> getAlignment()
-> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // 전체 테두리 지정
$objPHPExcel -> getActiveSheet() -> getStyle(sprintf("A1:H%s", $count_s)) -> getBorders() -> getAllBorders()
-> setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // 타이틀 부분
    $objPHPExcel -> getActiveSheet() -> getStyle("A1:H1") -> getFont() -> setBold(true);
    $objPHPExcel -> getActiveSheet() -> getStyle("A1:H1") -> getFill() -> setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    -> getStartColor() -> setRGB("CECBCA");
   
    // 내용 지정
    $objPHPExcel -> getActiveSheet() -> getStyle(sprintf("A2:H%s", $count_s)) -> getFill()
    -> setFillType(PHPExcel_Style_Fill::FILL_SOLID) -> getStartColor() -> setRGB("F4F4F4");

    // 시트 네임
    $objPHPExcel -> getActiveSheet() -> setTitle("일별 판매액");

    // 첫번째 시트(Sheet)로 열리게 설정
    $objPHPExcel -> setActiveSheetIndex(0);

    // 파일의 저장형식이 utf-8일 경우 한글파일 이름은 깨지므로 euc-kr로 변환해준다.
   
    $filename = iconv("UTF-8", "EUC-KR", "st_daily");
    $filename = $filename.'_'.date("YmdHms");
    // 브라우저로 엑셀파일을 리다이렉션
    header("Content-Type:application/vnd.ms-excel");
    header("Content-Disposition: attachment;filename=".$filename.".xls");
    header("Cache-Control:max-age=0");

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
    $objWriter -> save("php://output");  
   
?>