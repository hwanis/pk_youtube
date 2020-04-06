<?php

    session_start();
    
    if(empty($_SESSION)){
        
        echo '<script type="text/javascript">
              alert("접근이 잘못 되었습니다.");
               window.location = "../login/";
              </script>';
    }
?>