<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>管理我的关注</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">		
		<script src="../js/jquery-1.9.1.js"></script>
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<link href="../css/manageSelf.css" rel="stylesheet" type="text/css">
		<script src="../js/manage.js"></script>
		<script src="../js/SelfFollow.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<header id="manageHeader">
				<?php include(__DIR__."/../View/manageHeader.php"); ?>
			</header>
			<!--下面是页面主体部分-->
			<div class="row-fluid queryDiv">
				<div class="span12 mainContent">
					<div class="selfManageMenu">	
						<form class="form-search input-append">
							<input class="input-medium" type="text" placeholder="人/问题/话题" /> 
							<button type="submit" class="btn">查找</button>
						</form>						
					</div>
					<h4>关注的人</h4>
					<hr>
					<div class="selfTableDiv hasFollowedUser">
						<table class="table selfTable">		
							<thead>
								<tr>
									<th>人物称呼</th>
									<th>性别</th>
									<th>邮箱</th>
									<th>人物详情</th>
									<th>取消关注</th>
								</tr>							
							</thead>
							<tbody>
								<tr>
									<td>
										山外山
									</td>
									<td>
										男
									</td>
									<td>
										1401717460@qq.com
									</td>
									<td>
										<button class="btn-link detailsBtn">人物详情</button>
									</td>
									<td>
										<button class="btn-link">取消关注</button>
									</td>
								</tr>							
							</tbody>
						</table>
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
					
					<h4>关注的问题</h4>
					<hr>
					<div class="selfTableDiv hasFollowedQuestion">
						<table class="table selfTable">		
							<thead>
								<tr>
									<th>提问者</th>
									<th>提问日期</th>
									<th>问题类型</th>
									<th>问题内容</th>
									<th>详情</th>
								</tr>							
							</thead>
							<tbody>
								<tr>
									<td>
										山外山
									</td>
									<td>
										2018/7/9
									</td>
									<td>
										IT类
									</td>
									<td>
										软件必须修复所有bug之后才开始发布吗？
									</td>
									<td>
										<button class="btn-link questionDtailsBtn">查看详情</button>
									</td>	
								</tr>							
							</tbody>
						</table>
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
					
					<h4>关注的话题</h4>
					<hr>
					<div class="selfTableDiv hasFollowedTopic">
						<table class="table selfTable">		
							<thead>
								<tr>
									<th>话题</th>
									<th>话题详情</th>
									<th>取消关注</th>
								</tr>							
							</thead>
							<tbody>
								<tr>
									<td>
										这是一个话题，它应该有和问题不同的地方
									</td>
									<td>
										<button class="btn-link detailsBtn">话题详情</button>
									</td>
									<td>
										<button class="btn-link">取消关注</button>
									</td>
								</tr>							
							</tbody>
						</table>
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
				
			</div>	
			
			<div class="row-fluid questionDetailsDiv">
				<div class="span12 mainContent">
					<ul class="nav nav-tabs pull-right">
						<li>
							<button class="btn-link" id="returnListBtn">返回问题列表</button>
						</li>
					</ul>
					<?php include(__DIR__."/../View/questionDetails.php"); ?>
				</div>
			</div>		
			
			
			<footer id="manageFooter">
				<?php include(__DIR__."/../View/manageFooter.php"); ?>
			</footer>	
				
		</div>		
	</body>
</html>
