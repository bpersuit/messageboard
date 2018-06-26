<?php
	session_start();
	
	ini_set("error_reporting","E_ALL & ~E_NOTICE");

	require_once ('db.php'); 

	$db = new db();

	//判断是否有用户登录
	if(isset($_SESSION['user'])){

		$currentUser = $_SESSION['user'];

		$messageContent = trim($_POST['messageValue']);

		if($messageContent != ''){

			$loginUser = "select id from user where username = '".$currentUser."'";

			$arrTmp = $db->Query($loginUser);

			$loginUserId = $arrTmp[0][0];

			$currentTime =  date('y-m-d h:i:s',time());


			//还需要对于输入的内容进行转义，防止注入等等处理

			$sql = "insert into message(userid,content,createdate)Value('$loginUserId','$messageContent','$currentTime')";

			$result = $db->Insert($sql);

			 $returnArr=array();

			if($result == 1){

				$returnArr['result'] = '保存成功';

			}else{

				$returnArr['result'] = '保存失败';

			}

			echo json_encode($returnArr);

		}
		
	}else{

		echo 'ERROR';
	}


?>