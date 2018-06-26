<?php
/*用户登录的处理逻辑*/
session_start(); 

require_once ('db.php'); 
 
$action = $_GET['action']; 

if ($action == 'login') {  //登录 

    $user = stripslashes(trim($_POST['user'])); 
    $pass = stripslashes(trim($_POST['pass']));
    $inputcode = strtoupper(stripslashes(trim($_POST['inputcode'])));  
    $sessioncode = strtoupper($_SESSION['code']);

    $returnArr=array();
    
    if (empty ($user)) { 

         $returnArr['message'] = '用户名不能为空'; 
         $returnArr['success'] =0;
       
    } elseif (empty ($pass)) { 

       $returnArr['message'] = '密码不能为空'; 
       $returnArr['success'] =0;
      
    } elseif(empty ($inputcode) || $inputcode != $sessioncode){

         $returnArr['message'] = '验证码有误';
         $returnArr['success'] =0;
       
    }else{

        $db = new db();

        $sql = "select * from user where username='$user'";

        $arr = $db->Query($sql,1);

        if(sizeof($arr) == 1){

            $dPass = $arr[0][2];

           if($dPass == $pass){

                $returnArr['success'] =1;

                $returnArr['message'] ='登录成功';

                $returnArr['user'] = $user;

                $_SESSION['user'] = $user;

           }else{


                $returnArr['success'] =0;

                $returnArr['message'] ='密码错误';

           }
        }else{

            $returnArr['success'] =0;

            $returnArr['message'] ='用户名错误';

        }
    }

    echo json_encode($returnArr);

   
} elseif ($action == 'logout') {  //退出 
    unset($_SESSION); 
    session_destroy(); 
    
}
