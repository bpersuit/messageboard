<?php
	session_start();
	
	ini_set("error_reporting","E_ALL & ~E_NOTICE");

	require_once ('db.php'); 

	$db = new db();

	//判断是否有用户登录
	if(isset($_SESSION['user'])){

		$currentUser = $_SESSION['user'];

		$messageId = trim($_POST['messageid']);

		if($messageId != ''){

			$loginUser = "select id from user where username = '".$currentUser."'";

			$arrTmp = $db->Query($loginUser);

			$loginUserId = $arrTmp[0][0];

			//$currentTime =  date('y-m-d h:i:s',time());

			$sql = "update message set hasdel = 1 where id = $messageId and userid = $loginUserId";
			//还需要对于输入的内容进行转义，防止注入等等处理


			$result = $db->Insert($sql);

			$returnArr=array();

			if($result == true){

				$returnArr['result'] = '删除成功';

			}else{

				$returnArr['result'] = '删除失败';

			}

			echo json_encode($returnArr);

		}
		
	}else{

		echo 'ERROR';
	}


?>