<?php
    require_once "../class/class_db.php";
    require_once '../class/class_stdata.php';
    require_once "../lib/PHPExcel.php";

    $objPHPExcel = new PHPExcel();
    $obj = new class_stdata();
   
    $page_no = $_REQUEST[page_no];
    $page_list_no = $_REQUEST[page_list_no];
    $where = $_REQUEST[where];
    $req_s_id = $_REQUEST[req_s_id];
    $s_auth = $_REQUEST[s_auth];

    $list_cnt =  $obj->getDailyList($page_no, $page_list_no, $where, $req_s_id, 'cnt', $s_auth);    

    $arrStats = Array();

    for($i=0;$i<count($list_cnt);$i++){
        $arrStats[$i+1] = array(        
            'sal_date' => $list_cnt[$i][sal_date], 
            'd_tot_price' => $list_cnt[$i][d_tot_price],
            'd_tot_qty' => $list_cnt[$i][d_tot_qty]
        );
    }

    //엑셀 열 명칭
    $objPHPExcel -> setActiveSheetIndex(0)
    -> setCellValue("A1", "일자")
    -> setCellValue("B1", "판매 금액")
    -> setCellValue("C1", "판매 수량")
    ;

    $count_s = 1;

//엑셀에 입력될 데이터
foreach($arrStats as $key => $val) {

    $num = 1 + $key;

    $objPHPExcel -> setActiveSheetIndex(0)

    -> setCellValue(sprintf("A%s", $num),  $val['sal_date'])
    -> setCellValue(sprintf("B%s", $num), $val['d_tot_price'])
    -> setCellValueExplicit(sprintf("C%s", $num), $val['d_tot_qty']);

    $count_s++;

}

// 엑셀 서식
// 가로 넓이 조정
$objPHPExcel -> getActiveSheet() -> getColumnDimension("A") -> setWidth(30);
$objPHPExcel -> getActiveSheet() -> getColumnDimension("B") -> setWidth(30);
$objPHPExcel -> getActiveSheet() -> getColumnDimension("C") -> setWidth(30);

  
    // 전체 가운데 정렬
$objPHPExcel -> getActiveSheet() -> getStyle(sprintf("A1:C%s", $count_s)) -> getAlignment()
-> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // 전체 테두리 지정
$objPHPExcel -> getActiveSheet() -> getStyle(sprintf("A1:C%s", $count_s)) -> getBorders() -> getAllBorders()
-> setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // 타이틀 부분
    $objPHPExcel -> getActiveSheet() -> getStyle("A1:C1") -> getFont() -> setBold(true);
    $objPHPExcel -> getActiveSheet() -> getStyle("A1:C1") -> getFill() -> setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    -> getStartColor() -> setRGB("CECBCA");
   
    // 내용 지정
    $objPHPExcel -> getActiveSheet() -> getStyle(sprintf("A2:C%s", $count_s)) -> getFill()
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