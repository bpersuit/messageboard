
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
				.addMessage{

					text-align: center;
				}

			</style>
		</head>
		<body>
			<div  class='messageHome_head'>添加留言</div>
			<div class="addMessage">
				<textarea rows="3" cols="20"></textarea>	
				<div class="submit">提交</div>
			</div>
			<div class='messageHome_head'>留言板的主页面</div>
			<?php
				session_start(); 

				//获取所有的留言
				require_once ('db.php'); 
				require_once ('message.php');

				$db = new db();

			    $sql = "select m.id,userid,content,createdate,username from message m,user u where m.hasdel = 0 and m.userid = u.id order by createdate asc";

			    $arr = $db->Query($sql);

			     foreach($arr as $v){

			     	$message = new Message();
			     	$message ->id = $v[0];
			     	$message ->content = $v[2];
			     	$message ->date = $v[3];
			     	$message->username = $v[4];
			     	
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

				<div class="deleteMessage" messageid='<?php echo $message->id ?>' >删除</div>
			</div>

			<?php
			     	
			    }
			?>
			<script type="text/javascript" src="./js/jquery-2.1.1.min.js"></script>
			<script>
				$(function(){


					$(".addMessage .submit").click(function(){

						//验证是否登录
						if(valication()){

							var messageValue = $(".addMessage textarea").val();

							if(messageValue == ''){

								alert("输入留言信息");

								return;
							}

							$.ajax({         

			    				type: "POST",         

			    				url: "./addMessage.php",         

			    				dataType: "json",         

			    				data: {"messageValue":messageValue},         

			    				success:function(result){

			    					console.log(result);
			    					alert(result.result);
			    					window.location.href='./messageHome.php';

			    				}
			    			});

						}

					});

					$(".deleteMessage").click(function(){


						var messageid = $(this).attr("messageid");

						$.ajax({         

			    				type: "POST",         

			    				url: "./deleteMessage.php",         

			    				dataType: "json",         

			    				data: {"messageid":messageid},         

			    				success:function(result){

			    					alert(result.result);

			    					window.location.href = './messageHome.php';

			    				}
			    			});


					});
				})

				function valication(){

					var  user = "<?php if(isset($_SESSION['user'])) echo $_SESSION['user'] ;else echo '';?>";
					
					if(user != null && user != '')

						return true;
					else
						return false;
				}

			</script>
		</body>
	</html>