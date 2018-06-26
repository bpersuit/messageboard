<?PHP
	session_start(); 

?>

<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" href="./css/bootstrap.min.css"> 
		<link rel="stylesheet" href="./css/index.css"> 
	</head>
	<body>
		<div id="myAlert" class="alert alert-warning" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<span></span>
		</div>
		<div id="login"> 

	      	<span class="login_header">用户登录</span>
	     	<div id="login_form">
	     	  <input type="text" class="form-control" id="user" placeholder="用户名">
	     	  <input type="password" class="form-control" id="pass" placeholder="密码">
	          <input type="text" class="form-control code" placeholder="验证码">
	          <img src='./authcode.php'</label></p>
	          <div class="login_submit">
		          <button type="button" class="btn btn-primary">登 录</button>
		      </div>
	          
	      	</div> 
	    
		</div> 

		<script type="text/javascript" src="./js/jquery-2.1.1.min.js"></script> 
		<script type="text/javascript" src="./js/bootstrap.min.js"></script> 
		<script>
			
			$(function(){

				$(".btn").click(function(){

					var username = $("#user").val().trim();
					var pas = $("#pass").val().trim();

					var inputcode = $(".code").val().trim();

					//进行验证
					if(login_valication()){

						$.ajax({         

		    				type: "POST",         

		    				url: "./login.php?action=login",         

		    				dataType: "json",         

		    				data: {"user":username,"pass":pas,"inputcode":inputcode},         

		    				success:function(result){

		    					console.log(result);

		    					if(result.success == 0){

			    					$("#myAlert > span").text(result.message);

			    					$("#myAlert").show();
			    				}else{

			    					alert("登录成功");

			    					window.location.href = './messageHome.php';

			    				}

		    					//alert(result.message);

		    				}
		    			});
					}
				});
			})

			function login_valication(){

				var username = $("#user").val().trim();

				var pas = $("#pass").val().trim();

				var inputcode = $(".code").val().trim();

				var code = "<?php echo $_SESSION['code'] ?>";

				console.log(code);

				if(username == null || username == '' ){

					alert("请输入用户名");

					return false;
				}
				if(pas == null || pas == '' ){

					alert("请输入密码");

					return false;

				}

				if(inputcode ==''){

					alert("请输入验证码");

					return false;

				}

				//还需要对于相关的长度等等做限制验证

				return true;

			}
		</script>
	</body>
</html>