<?php
    require_once "../autoload.php";
  //  require_once '../inc/common.php';

    $obj = new class_creator();    
    $get_creator = $obj ->getChkLoginId($_REQUEST[ct_id]); 

    if($get_creator[ct_id] == ''){           
        echo '  <script type="text/javascript">
                    alert("아이디가 존재하지 않습니다.");
                    window.location = "index.php";
                </script>';        
    }
   
    $ct_id          = $get_creator[ct_id];
    $ct_pass        = $get_creator[passwd];
    $ct_name        = $get_creator[ct_name];
 //   $m_auth = $get_member_info[m_auth];
    $ct_use         = $get_creator[ct_use];
    $last_login     = $get_creator[last_login];
    $login_cnt      = $get_creator[login_cnt];
    $regist_date    = $get_creator[regist_date];    
    $ct_auth        = $get_creator[ct_auth];    
     
    if($ct_id != ''){    
        //check password
        if(password_verify($_REQUEST['ct_pass'], $ct_pass)){
     
            session_start();
            
            $_SESSION[s_id]     = $ct_id;
            $_SESSION[s_name]   = $ct_name;
          //  $_SESSION[m_auth]   = $m_auth;
            $_SESSION[s_use]    = $ct_use;
            $_SESSION[s_auth]   = $ct_auth;
                            
            //사용가능 여부 
            if($ct_use == 0){
                 echo '<script type="text/javascript">
                alert("접근 권한이 없습니다.");
                 window.location = "index.php";
                </script>';
            }            
           
            //add login_cnt
            $login_cnt++;
            $last_login = date("Y-m-d H:i:s");
            
            $get_login_post = Array();            
            $get_login_post[login_cnt] = $login_cnt;
            $get_login_post[last_login] = $last_login;
            $get_login_post[ct_id] = $ct_id;
            $get_login_post[ct_ip] = $_SERVER["REMOTE_ADDR"];
            
            $update = $obj->updateLoginInfo($get_login_post);
            
             if( gettype($update) == string){
                echo '<script type="text/javascript">                      
                    window.location = "../common/svr_error.php?msg='.$update.'";
                </script>';
            }else {
                echo '<script type="text/javascript">                                    
                        window.location = "../sales/dashboard.php";
                    </script>';
            }  
            
        }else{            
             echo ' <script type="text/javascript">
                        alert("비밀번호가 맞지 않습니다.");
                        window.location = "index.php";
                    </script>';
        }         
    }else{     
        //not find id
        echo '<script type="text/javascript">
                alert("아이디가 존재하지 않습니다.");
                 window.location = "index.php";
            </script>';
    }
    

//id password 일치 check

//redirect login page 