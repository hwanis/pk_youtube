<?php
    require_once '../autoload.php'; 
    //request 블록 번호
    if(empty($_REQUEST[ct_id])){
       // 잘못된 접근
    }
//getCreatorRsList
    $obj = new class_creator();
    
    $req_s_id = $_REQUEST[ct_id];    
   
    $list = $obj->getCreatorItemList($req_s_id);    
?>
            
<div class="col-sm-3">                                
    <select class="chosen-select form-control" id="it_id" name="it_id" >      
        <?php                                                 
            for($i=0;$i<count($list);$i++){
        ?>

        <?php
            if($req_s_id == $list[$i][it_id]){
        ?>
            <option value="<?=$list[$i][it_id]?>" selected><?=$list[$i][it_name]?>(<?=$list[$i][sal_pl]?>)</option>                                                           
        <?php
            }else{
        ?>
            <option value="<?=$list[$i][it_id] ?>"><?=$list[$i][it_name]?>(<?php echo $list[$i][sal_pl]==1 ? 'CS': 'WEB'; ?>)</option>        
        <?php                                                        
            }
        }
        ?>
    </select> 
</div>
                    


	