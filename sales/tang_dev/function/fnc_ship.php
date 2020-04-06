<?php

//upload file rename
 function fileRename($upload_filename){
        
    $file_ext = explode('.',basename(strtolower($upload_filename)));
   
    $file_req_name = $file_ext[0];
    $file_req_ext = $file_ext[1];

    //upload image file name
    $file_req_full_name = time().mt_rand(0, 99).'.'.$file_req_ext;   

    return $file_req_full_name;
        
}
    
//file upload
function fileUpload($file_req_full_name, $file_size, $file_tmp_name, $file_re_name){
    
 //   echo $file_req_full_name.'<br>';
//    echo $file_re_name.'<br>';
  

    //save main image    
    $target_dir = "../files_ship/";
    $target_file = $target_dir.basename($file_re_name);    
    //echo "<script> alert('".$target_file."');</script>";
     
    $uploadOk = 1;
  
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
  
     if(isset($_POST["btnSubmit"])) {
         /*$check = getimagesize($file_tmp_name);
         if($check !== false) {
             echo "File is an image - " . $check["mime"] . ".";
             $uploadOk = 1;
         } else {
             echo "File is not an image.";
             echo $uploadOk = 0;
         }
          * 
          */
     }else       
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
            exit;
        }

        // Check file size
        if ($file_size > 500000000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
            exit;
        }
        // Allow certain file formats
        if($imageFileType != "xls" && $imageFileType != "xlsx" && $imageFileType != "XLS" && $imageFileType != "XLSX")
       {
        //    echo "Sorry, only xls, xlsx files are allowed.";
        //    $uploadOk = 0;
        //    exit;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            exit;
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($file_tmp_name, $target_file)) {
                echo "The file ". basename($file_req_full_name). " has been uploaded.";
           //    exit;
            } else {
                echo "<script>alert('$file_tmp_name');alert('$target_file');</script>";
                echo "<script>alert('Sorry, there was an error uploading your file.'); history.back(-1);</script>";
                exit;
            }
        }
    
   // return $file_req_full_name;
    
}


//special string replace
function sPecStrReplace($req_str){

    $ex_str = preg_replace("/[#\&\+\-%@=\/\\\:;\'\"\^~\_|\!\*$#<>\[\]\{\}]/i", "", $req_str);        

    return $ex_str;

}

//redirect error page
function redirectErrorPage($err_str){
    
    if( gettype($err_str) == string){
        echo '<script type="text/javascript">                      
                window.location = "../common/svr_error.php?msg='.$update.'";
            </script>';
    }else {
        echo '<script type="text/javascript">             
                alert("수정 되었습니다.");
                window.location = "../popup/popup_list.php";
            </script>';
    }
    
}
