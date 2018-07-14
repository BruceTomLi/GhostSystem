<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>管理用户</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">		
		<script src="../js/jquery-1.9.1.js"></script>
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<link href="../css/manage.css" rel="stylesheet" type="text/css">
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
					<div class="manageMenu">	
						<form class="form-search input-append pull-left">
							<input class="input-medium" type="text" placeholder="用户名/邮箱" /> 
							<button type="submit" class="btn">查找</button>
						</form>
						
						<ul class="nav nav-tabs pull-right">
							<li>
								<button id="hideOrShowAdvanceSearchBtn" class="btn-link">隐藏/显示高级搜索</a>
							</li>
							<li>
								<button id="hideOrShowDetailsBtn" class="btn-link">隐藏/显示用户详情</a>
							</li>
							<li>
								<button id="hideOrShowAbleBtn" class="btn-link">隐藏/显示禁用用户</a>
							</li>
						</ul>
					</div>
					<div class="advanceSearchDiv">
						<select>
							  <option>所有角色</option>
							  <option>普通用户</option>
							  <option>权限管理员</option>
							  <option>作者</option>
						</select>
						<select>
							  <option>所有性别</option>
							  <option>男</option>
							  <option>女</option>
						</select>
						<select>
							  <option>禁用/启用</option>
							  <option>禁用</option>
							  <option>启用</option>
						</select>
					</div>
					<div class="handleMultiDiv">
						<label class="checkbox inline">
					      	<input type="checkbox"> 全选
					    </label>
					    <label class="checkbox inline">
					      	<input type="checkbox"> 反选
					    </label>
					    <div class="selectUserDiv pull-right">					    	
						    <button id="disabledBtn" class="btn btn-warning inline">禁用选中用户</button>
							<button id="enabledBtn" class="btn btn-success inline">启用选中用户</button>
							<button id="disabledQueryBtn" class="btn btn-warning inline">禁用查询用户</button>
							<button id="enabledQueryBtn" class="btn btn-success inline">启用查询用户</button>
						</div>
					</div>
					<div class="tableDiv">
						<table class="table">		
						<thead>
							<tr>
								<th class="forSelectMulti">选择</th>
								<th>用户名</th>
								<th class="detailsInfo">邮箱</th>
								<th class="detailsInfo">性别</th>
								<th class="detailsInfo">职业</th>
								<th class="detailsInfo">所在省份</th>
								<th class="detailsInfo">所在城市</th>
								<th class="detailsInfo">一句话介绍</th>
								<th>用户角色</th>
								<th>禁用</th>
								<th>编辑</th>
							</tr>							
						</thead>
						<tbody>
							<tr>
								<td class="forSelectMulti">
									<label class="checkbox">
								      	<input type="checkbox">
								    </label>
								</td>
								<td>
									Tom Li
								</td>
								<td class="detailsInfo">
									1401717460@qq.com
								</td>
								<td class="detailsInfo">
									男
								</td>
								<td class="detailsInfo">
									程序猿
								</td>
								<td class="detailsInfo">
									江苏省
								</td>
								<td class="detailsInfo">
									昆山市
								</td>
								<td class="detailsInfo">
									努力做一个好的软件开发者
								</td>
								<td>
									普通用户，作者，权限管理员
								</td>
								<td>
									<button class="btn btn-warning">禁用</button>
								</td>
								<td>
									<button class="btn btn-info editBtn">编辑</button>
								</td>
							</tr>
							
						</tbody>
					</table>
					</div>
					<div class="pagination">
						<ul>
							<li>
								<a href="#">上一页</a>
							</li>
							<li>
								<a href="#">1</a>
							</li>
							<li>
								<a href="#">2</a>
							</li>
							<li>
								<a href="#">3</a>
							</li>
							<li>
								<a href="#">4</a>
							</li>
							<li>
								<a href="#">5</a>
							</li>
							<li>
								<a href="#">下一页</a>
							</li>
						</ul>
					</div>
				</div>
				
				</div>			
			
			<div class="row-fluid editDiv">
				<div class="span12 mainContent">
					<div class="row-fluid ">
						<ul class="nav nav-tabs pull-right">
							<li>
								<button class="btn-link listBtn">返回用户列表</button>
							</li>
						</ul>
						<div class="form-horizontal registerForm">
							<div class="formTitle">
								<legend>编辑用户</legend>
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
						      <button type="submit" class="btn btn-warning" id="changeUserCancleBtn">取消</button>
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
