<?php   
    $b_filename = basename($_SERVER['PHP_SELF']);
    
    try{
        $obj = new class_common();
        
        $pg_name = $obj->getPageList($b_filename);
   
    } catch (Exception $ex) {
        die($ex);
    }	
 
?>


<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>
    
      <link rel="stylesheet" href="../assets/css/jquery-ui.custom.css" />
            <link rel="stylesheet" href="../assets/css/chosen.css" />	
            <link rel="stylesheet" href="../assets/css/jquery-ui.css" />              
            <link rel="stylesheet" href="../assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="#">Home</a>
        </li>

        <li>
                <a href="#"><?=$pg_name[pg_category]?></a>
        </li>
        <li class="active"><?=$pg_name[pg_title]?></li>
    </ul><!-- /.breadcrumb -->

    <!-- #section:basics/content.searchbox -->


    <!-- /section:basics/content.searchbox -->
</div>
<div class="page-content">
    <div class="page-header">
        <h1>
            <?=$pg_name[pg_title]?>
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                <?=$pg_name[pg_contents]?>
            </small>
        </h1>
    </div><!-- /.page-header -->