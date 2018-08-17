<!DOCTYPE html>
<html style="height: 100%">
	<head>
		<meta charset="UTF-8">
		<title>系统注册</title>
		<link rel="Shortcut Icon" href="img/logo_ico.gif" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
		<link href="css/register.css" rel="stylesheet" type="text/css">
		<script src="js/jquery-1.9.1.js"></script>
		<script src="./bootstrap/js/bootstrap.min.js"></script>
		<script src="js/register.js"></script>
	</head>
	<body style="height: 100%">
		<div class="container registerBackground">
			<div class="row-fluid">
				<div class="span12">
					<div class="register">
						<div class="row-fluid ">
							<div class="form-horizontal registerForm">
								<div class="formTitle">
									<legend><img src="img/logo.gif" />注册</legend>
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
								    	<input type="password" id="inputPassword" placeholder="密码(推荐数字,字母,符号组合)">
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
								  		<label class="control-label" for="inputJob">行业</label>
									    <div class="controls">
									    	<select id="inputJob">
									    		<option value="">--</option>
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
							      	<!--不使用在前台插入标记的方式实现数据检查-->
							      	<!--<input type="hidden" id="isNameOk" value="false"/>
							      	<input type="hidden" id="isEmailOk" value="false"/>
							      	<input type="hidden" id="isPwdOk" value="false"/>-->
							      	<span id="regChk"></span>
							    </div>
							  </div>
							</div>
						</div>
						
						<!--暂时不开发第三方账号登录功能-->
						<!--<div class="row-fluid registerFooter">
							<div class="span12">
								<div class="otherLogin">
									<p>使用第三方账号直接登录</p>
									<p><a href="#"><img src="img/qq-login.png"></a>
									<a href="#"><img src="img/weibo-login.png"></a></p>
								</div>
							</div>
						</div>-->
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
