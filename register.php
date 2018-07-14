<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Ghost系统注册</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
		<link href="css/register.css" rel="stylesheet" type="text/css">
		<script src="js/jquery-1.9.1.js"></script>
		<script src="./bootstrap/js/bootstrap.min.js"></script>
		<script src="js/register.js"></script>
	</head>
	<body>
		<div class="container registerBackground">
			<div class="row-fluid">
				<div class="span12">
					<div class="register">
						<div class="row-fluid ">
							<div class="form-horizontal registerForm">
								<div class="formTitle">
									<legend>注册新用户</legend>
								</div>
							  	<div class="control-group">
							    	<div class="controls">
								      	<input type="text" id="inputUsername" placeholder="用户名">
								      	<span id="userNameChk"></span>
								    </div>
							  	</div>
							  	<div class="control-group">
							    	<div class="controls">
							      		<input type="text" id="inputEmail" placeholder="邮箱">
							      		<span id="emailChk"></span>
							    	</div>
							  	</div>
								<div class="control-group">
								    <div class="controls">
								    	<input type="password" id="inputPassword" placeholder="密码">
								    	<span id="passwordChk"></span>
								    </div>
								</div>
							  	<div class="moreInfoDiv">
							  		<hr>
							  		<span class="moreInfo">更多资料</span>	
							  	</div>
							  	<div class="moreForm">
								    <div class="control-group">
								    	<label class="control-label" for="inputSex">性别</label>
								    	<div class="controls selectSex">
								    		<label class="radio inline">
											  <input type="radio" name="sexRadios" id="optionsRadios1" value="man" checked>
											  男
											</label>
											<label class="radio inline">
											  <input type="radio" name="sexRadios" id="optionsRadios2" value="woman">
											  女
											</label>
								    	</div>							  		
									</div>
									<div class="control-group">
								  		<label class="control-label" for="inputJob">职业</label>
									    <div class="controls">
									    	<select id="inputJob">
									    		<option value="empty">--</option>
									    	</select>
									    </div>
									</div>
									<div class="control-group">
								  		<label class="control-label" for="inputCity">所在城市</label>
									    <div class="controls">
									    	<select class="input-small" id="province">
									    		<!--<option value="province">请选择省份或直辖市</option>-->
									    	</select>
									    	<select class="input-small" id="city">
									    		<!--<option value="city">请选择城市</option>-->
									    	</select>
									    </div>
									</div>
									<div class="control-group">
								    	<div class="controls">
								      		<input type="text" id="inputOneWord" placeholder="一句话介绍">
								    	</div>
								  	</div>
							  	</div>
							  	<div class="control-group">
							    	<div class="controls">
							      		<input class="input-small" type="text" id="inputValcode" placeholder="验证码">
							      		<img id="valcodeId" src="" alt="请输入验证码"></img>
							      		<input id="valcodeValue" type="hidden" value="" />
							      		<span id="valcodeChk"></span>
							    	</div>
							  	</div>
							  <div class="control-group">
							    <div class="controls">
							      <label class="checkbox">
							        <input type="checkbox" id="isAgree"> 我同意
							        <a href="#">用户协议</a>
							        <a href="#" style="margin-left:30px;">已有账号？</a>
							      </label>
							      <span id="agreeChk"></span>
							    </div>
							  </div>
							  <div class="control-group">
							    <div class="controls">
							      <button type="submit" class="btn btn-success" id="registerBtn">注册</button>
							      <input type="hidden" id="isNameOk" value="false"/>
							      <input type="hidden" id="isEmailOk" value="false"/>
							      <input type="hidden" id="isPwdOk" value="false"/>
							      <span id="regChk"></span>
							    </div>
							  </div>
							</div>
							<hr>	
						</div>
						
						<div class="row-fluid registerFooter">
							<div class="span12">
								<div class="otherLogin">
									<p>使用第三方账号直接登录</p>
									<p><a href="#"><img src="img/qq-login.png"></a>
									<a href="#"><img src="img/weibo-login.png"></a></p>
								</div>
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
