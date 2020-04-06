<?php
    session_start();
    //require_once "./inc/common.php";

if($_SESSION['s_id'] == '')
{
    echo
    '<script>location.href="/login/"</script>';
    exit;
}else{
    echo '<script type="text/javascript">
       window.location = "../sales/daily_sales.php"
	</script>';
}

