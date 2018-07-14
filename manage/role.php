<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>管理角色</title>
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
					<div class="tableDiv">
						<table class="table">		
						<thead>
							<tr>
								<th>角色名</th>
								<th>角色描述</th>
								<th>拥有权限</th>
								<th>修改</th>
							</tr>							
						</thead>
						<tbody>
							<tr>
								<td>
									权限管理员
								</td>
								<td>
									可以管理用户信息，角色信息，权限信息
								</td>
								<td>
									管理用户信息,管理角色信息,管理权限信息
								</td>
								<td>
									<button class="btn btn-info editBtn">修改</button>
								</td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
				
			</div>			
			
			<div class="row-fluid editDiv">
				<div class="span12 mainContent">
					<div class="row-fluid ">
						<ul class="nav nav-tabs pull-right">
							<li>
								<button class="btn-link listBtn">返回角色列表</button>
							</li>
						</ul>
						<div class="form-horizontal">
							<div class="formTitle">
								<legend>编辑角色</legend>
							</div>
						  	<div class="control-group">
						  		<label class="control-label" for="inputRolename">角色名</label>
						    	<div class="controls">
							      	<input type="text" id="inputRolename" placeholder="角色名">
							    </div>
						  	</div>
						  	<div class="control-group">
						  		<label class="control-label" for="inputRoleDescription">角色描述</label>
						    	<div class="controls">
						      		<input type="text" id="inputRoleDescription" placeholder="角色描述">
						    	</div>
						  	</div>
							<div class="control-group">
								<label class="control-label" for="inputAuthority">拥有权限</label>
							    <div class="controls">
							    	<label class="checkbox">
								      	<input type="checkbox"> 管理用户信息
								    </label>
								    <label class="checkbox">
								      	<input type="checkbox"> 管理角色信息
								    </label>
								    <label class="checkbox">
								      	<input type="checkbox"> 管理权限信息
								    </label>
								    <label class="checkbox">
								      	<input type="checkbox"> 管理所有文章信息
								    </label>
								    <label class="checkbox">
								      	<input type="checkbox"> 普通用户权限
								    </label>
							    </div>
							</div>
						  	
							 <div class="control-group">
							    <div class="controls">
								    <button type="submit" class="btn btn-info" id="changeRoleBtn">修改</button>
								    <button type="submit" class="btn btn-warning" id="changeRoleCancleBtn">取消</button>
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
