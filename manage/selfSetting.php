<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>管理个人设置</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">		
		<script src="../js/jquery-1.9.1.js"></script>
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<link href="../css/manage.css" rel="stylesheet" type="text/css">
		<link href="../css/manageSelf.css" rel="stylesheet" type="text/css">
		<script src="../js/manage.js"></script>		
	</head>
	<body>
		<div class="container-fluid">
			<header id="manageHeader">
				<?php include(__DIR__."/../View/manageHeader.php"); ?>
			</header>
			<!--下面是页面主体部分-->
			<div class="row-fluid queryDiv">
				<div class="span12 mainContent">
					<div class="row-fluid ">
						<div class="form-horizontal registerForm">
							<div class="formTitle">
								<legend>编辑我的信息</legend>
							</div>
						  	<div class="control-group">
						  		<label class="control-label" for="inputUsername">用户名</label>
						    	<div class="controls">
							      	<input type="text" id="inputUsername" placeholder="用户名">
							      	<span id="userNameChk"></span>
							    </div>
						  	</div>
						  	<div class="control-group">
						  		<label class="control-label" for="inputEmail">邮箱</label>
						    	<div class="controls">
						      		<input type="text" id="inputEmail" placeholder="邮箱">
						      		<span id="emailChk"></span>
						    	</div>
						  	</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">密码</label>
							    <div class="controls">
							    	<input type="password" id="inputPassword" placeholder="密码">
							    	<span id="passwordChk"></span>
							    </div>
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
									<label class="control-label" for="inputOneWord">一句话介绍</label>
							    	<div class="controls">
							      		<input type="text" id="inputOneWord" placeholder="一句话介绍">
							    	</div>
							  	</div>
						  	</div>
						  	<div class="control-group">
						  		<label class="control-label" for="inputUserRole">用户角色</label>
						    	<div class="controls">
						      		<select id="roles" multiple="multiple">
							    		<!--<option value="city">请选择城市</option>-->
							    	</select>
							    	<span id="selectUserRoles"></span>
						    	</div>
						  	</div>
							<div class="control-group">
							    <div class="controls">
							      	<button type="submit" class="btn btn-info" id="changeUserBtn">修改</button>
							      	<!--<button type="submit" class="btn btn-warning" id="cancleBtn">取消</button>-->
							      	<input type="hidden" id="isNameOk" value="false"/>
							      	<input type="hidden" id="isEmailOk" value="false"/>
							      	<input type="hidden" id="isPwdOk" value="false"/>
							      	<span id="regChk"></span>
							    </div>
							</div>
						</div>
						<hr>	
					</div>						
				</div>
			</div>
			<footer id="manageFooter">
				<?php include(__DIR__."/../View/manageFooter.php"); ?>
			</footer>	
				
		</div>		
	</body>
</html>
