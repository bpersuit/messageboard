
<!DOCTYPE html>
	<html>
		<head>
			<link rel="stylesheet" href="./css/bootstrap.min.css"> 
			<style>
				.messageHome_head{

					text-align:center;
					font-size:18px;
				}
				.message-Item{

					border:1px solid #0e90d2;

				}

			</style>
		</head>
		<body>
			<div>添加留言</div>
			<div class='messageHome_head'>留言板的主页面</div>
			<?php
				session_start(); 

				//获取所有的留言
				require_once ('db.php'); 
				require_once ('message.php');

				$db = new db();

			    $sql = "select * from message where hasdel = 0 order by createdate asc";

			    $arr = $db->Query($sql);

			     foreach($arr as $v){

			     	$message = new Message();
			     	$message ->id = $v[0];
			     	$message ->content = $v[2];
			     	$message ->date = $v[3];
			     	$usersql = "select username from user where id = '$v[0]'";

			     	$userArr = $db->Query($usersql,1);
			     	$message->username = $userArr[0][0];
			     	
			?>
			<div class="message-Item">
				
				<div class="message-Item-name">
					
					<?php echo $message->content;?>
				</div>

				<div class="message-Item-creater">
					
					创建者:<?php echo $message->username;?>

				</div>
				<div class="message-Item-date">
					
					发布时间：<?php echo $message->date;?>

				</div>
			</div>

			<?php
			     	
			    }
			?>

		</body>
	</html>