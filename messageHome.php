<?php
	session_start();
	//获取所有的留言
	require_once ('db.php'); 
	require_once ('message.php');
	$user = '';
	if(isset($_SESSION['user']))

		$user = $_SESSION['user'] ;
?>
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

					border:1px solid #eee;
					padding:10px 20px 0px 20px;

				}
				.addMessage{

					text-align: center;
				}
				.addMessage textarea{

					width:60%;
					height:100px;
					border-radius:5px;
				}
				.message-Item-creater{

					float:left;
				}
				.message-Item-date{

					float: left;
					margin-left:10px;
				}
				.deleteMessage{

					float:right;
					margin-right:10px;
					margin-top: -15px;
				}
				.currentuser{

					float: left;
				}
				.logout{

					margin-left:10px;
					float: left;
				}
				.head{

					margin-top: 20px;
					margin-left:100px;
				}

			</style>
		</head>
		<body>
			<div class="head">
				<?php
					if($user != '')
						echo "<div class='currentuser'>当前的登录用户为：$user</div><div class='logout'><a href='./login.php?action=logout'>退出</a></div>";
					else
						echo "<div><a href='./index.php'>登录</a></div>";
				?>
				<div style="clear:both"></div>
			</div>
			<div  class='messageHome_head'>添加留言</div>
			<div class="addMessage">
				<textarea rows="3" cols="20"></textarea>	
				<div class="submit">
					<button type="button" class="btn btn-primary">登 录</button>
				</div>
			</div>
			<div class='messageHome_head' style="margin-top:20px;">留言板的主页面</div>
			<?php
				
				$db = new db();

			    $sql = "select m.id,userid,content,createdate,username from message m,user u where m.hasdel = 0 and m.userid = u.id order by m.createdate desc";

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
				<?php
					
					if($user != '' && $user == $message->username){

						echo "<div class='deleteMessage' messageid= $message->id ><img src='./img/delete.png'></div>";
					}
				?>
				<div style="clear:both;"></div>
				
			</div>

			<?php
			     	
			    }
			?>
			<script type="text/javascript" src="./js/jquery-2.1.1.min.js"></script>
			<script>
				$(function(){


					$(".addMessage .btn").click(function(){

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

						if(valication()){

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
						}


					});
				})

				function valication(){

					var  user = "<?php echo $user ?>";
					
					if(user != null && user != '')

						return true;
					else{

						alert("请先登录");

						return false;

					}
				}

			</script>
		</body>
	</html>