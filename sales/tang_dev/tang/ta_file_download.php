<?php
    session_start();
    require_once '../autoload.php'; 
    
     $target_Dir = "../files_ship/";
    
    switch($_REQUEST[tag]){
        
        case 'd': file_delete(); break;
        case 'u': file_download(); break;
        
        
    }
    
    function file_download(){
    
    $obj_curd = new class_curd();
    $view_file = $obj_curd->curdRecord($table = 'attatch_file', $where = ' file_id ='.$_REQUEST[file_id]);
    
   
  
    $file = $view_file[file_name];
    $file_o_name = $view_file[file_o_name];

   // $file = $view_file[file_name];
    $down = $target_Dir.$file;
  
  //echo $down;
  //exit;
  
  $filesize = filesize($down);
  
  if(file_exists($down)){
    header("Content-Type:application/octet-stream");
    header("Content-Disposition:attachment;filename=$file_o_name");
    header("Content-Transfer-Encoding:binary");
    header("Content-Length:".filesize($target_Dir.$file));
    header("Cache-Control:cache,must-revalidate");
    header("Pragma:no-cache");
    header("Expires:0");
    if(is_file($down)){
        $fp = fopen($down,"r");
        while(!feof($fp)){
          $buf = fread($fp,8096);
          $read = strlen($buf);
          print($buf);
          flush();
        }
        fclose($fp);
    }
  } else{
    ?>
    <script>alert("존재하지 않는 파일입니다.")</script>
        <?php
      }
        
    }
    
    function file_delete(){
        
        // 파일 삭제 unlink
        // 
        // 
        //db 삭제
        
      /*  
        $obj_curd = new class_curd();
         $view_file = $obj_curd->curdRecord($table = 'attatch_file', $where = ' file_id ='.$_REQUEST[file_id]);
    
   
  
    $file = $view_file[file_name];
    $file_o_name = $view_file[file_o_name];

   // $file = $view_file[file_name];
    $down = $target_Dir.$file;
        
        if( !unlink($target_Dir.'/file.txt') ) {
            echo "failed\n";
          }
          else {
            echo "success\n";
          }
       * 
       */
    }
   
?>