<!DOCTYPE html>
<html style="height: 100%">
	<head>
		<meta charset="UTF-8">
		<title>系统登录</title>
		<link rel="Shortcut Icon" href="img/logo_ico.gif" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
		<link href="css/login.css" rel="stylesheet" type="text/css">
		<script src="js/jquery-1.9.1.js"></script>
		<script src="./bootstrap/js/bootstrap.min.js"></script>
		<script src="js/login.js"></script>
	</head>
	<body style="height: 100%">
		<div class="container loginBackground">
			<div class="row-fluid">
				<div class="span12">
					<div class="login">
						<div class="row-fluid loginContent">
							<div class="form">
								<legend><img src="img/logo.gif" />登录</legend>
							  <div class="control-group">
							    <label class="control-label" for="inputAccount">账号</label>
							    <div class="controls">
							      <input type="text" id="inputAccount" placeholder="邮箱/用户名">
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="inputPassword">密码</label>
							    <div class="controls">
							      <input type="password" id="inputPassword" placeholder="密码">
							    </div>
							  </div>
							  <div class="control-group">
							    <div class="controls">
							    	<!--暂时不开发找回密码功能，后面开发邮箱激活账号时一起开发邮箱找回密码功能-->
							      	<!--<label class="checkbox">
							        	<input type="checkbox"><span>记住我</span>&nbsp;&nbsp;
							        	<a href="#">忘记密码</a>
							      	</label>-->
							      <br />
							      <button type="submit" class="btn" id="loginBtn">登录</button>
							    </div>
							  </div>
							</div>
							<!--<div class="otherLogin">
								<div class="form">
									<legend>第三方账号登录</legend>
								  <div class="control-group">
								    <div class="controls">
								     	<a href="#"><img src="img/qq-login.png"></a>
								    </div>
								  </div>
								  <div class="control-group">
								    <div class="controls">
								      <a href="#"><img src="img/weibo-login.png"></a>
								    </div>
								  </div>
								</div>
							</div>-->
						</div>
						<div class="row-fluid loginFooter">
							<div class="span12">
								<span>还没有账号？</span>&nbsp;
								<a href="register.php">立即注册</a>&nbsp;
								<a href="index.php">游客访问</a>&nbsp;
								<a href="forum/question.php">回答阅读</a>&nbsp;
							</div>
						</div>
					</div>					
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
					<?php include("View/loginRegisterFooter.php"); ?>
				</div>
			</div>
		</div>
	</body>
</html>
