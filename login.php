<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Ghost系统登录</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
		<link href="css/login.css" rel="stylesheet" type="text/css">
		<script src="js/jquery-1.9.1.js"></script>
		<script src="./bootstrap/js/bootstrap.min.js"></script>
		<script src="js/login.js"></script>
	</head>
	<body>
		<div class="container loginBackground">
			<div class="row-fluid">
				<div class="span12">
					<div class="login">
						<div class="row-fluid ">
							<div class="span7 loginContent">
								<div class="form">
									<legend>Ghost</legend>
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
								      <label class="checkbox">
								        <input type="checkbox"><span>记住我</span>&nbsp;&nbsp;
								        <a href="#">忘记密码</a>
								      </label>								      
								      <br />
								      <button type="submit" class="btn" id="loginBtn">登录</button>
								    </div>
								  </div>
								</div>
							</div>
							<div class="otherLogin">
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
							</div>
						</div>
						<div class="row-fluid loginFooter">
							<div class="span12">
								<span>还没有账号？</span>&nbsp;
								<a href="#">立即注册</a>&nbsp;
								<a href="#">游客访问</a>&nbsp;
								<a href="#">回答阅读</a>&nbsp;
							</div>
						</div>
					</div>					
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
					<p class="copyRight">Copyright © 2018 - 京ICP备11008151号, All Rights Reserved</p>
				</div>
			</div>
		</div>
	</body>
</html>
