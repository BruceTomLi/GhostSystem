<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>问题页</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">	
	<script src="../js/jquery-1.9.1.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../js/question.js"></script>
	<link href="../css/question.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12" id="questionHeader">
				<?php include(__DIR__."/../View/questionHeader.php"); ?>
			</div>
		</div>
		<div class="row-fluid contentDiv">
			<div class="span12 mainContent">
				<div class="row-fluid queryDiv">
					<div class="span9">
						<h3 class="pull-left">发现</h3>
						<ul class="nav nav-tabs pull-right">
							<li>
								<a href="#">最新</a>
							</li>
							<li>
								<a href="#">热门</a>
							</li>
							<li>
								<a href="#">推荐</a>
							</li>	
							<li>
								<a href="#">等待回复</a>
							</li>
						</ul>
						<table class="table questionTable">								
							<tbody>
								<tr>
									<td>
										<img src="../img/wangsai.jpg">
									</td>
									<td>
										<p><a href="questionDetails.php">Ghost 0.7.0 中文版正式发布</a></p>
										<p><span>分类</span>• 幸福快乐滴lion 回复了问题 • 4 人关注 • 4 个回复 • 1600 次浏览 • 23 小时前</p>
									</td>
									<td>
										<p>贡献</p>
										<p><img src="../img/liuchenghua.jpg"></p>
									</td>
								</tr>
								<tr>
									<td>
										<img src="../img/wangsai.jpg">
									</td>
									<td>
										<p><a href="questionDetails.php">Ghost 0.7.0 中文版正式发布</a></p>
										<p><span>分类</span>• 幸福快乐滴lion 回复了问题 • 4 人关注 • 4 个回复 • 1600 次浏览 • 23 小时前</p>
									</td>
									<td>
										<p>贡献</p>
										<p><img src="../img/liuchenghua.jpg"></p>
									</td>
								</tr>
								<tr>
									<td>
										<img src="../img/wangsai.jpg">
									</td>
									<td>
										<p><a href="questionDetails.php">Ghost 0.7.0 中文版正式发布</a></p>
										<p><span>分类</span>• 幸福快乐滴lion 回复了问题 • 4 人关注 • 4 个回复 • 1600 次浏览 • 23 小时前</p>
									</td>
									<td>
										<p>贡献</p>
										<p><img src="../img/liuchenghua.jpg"></p>
									</td>
								</tr>
								<tr>
									<td>
										<img src="../img/wangsai.jpg">
									</td>
									<td>
										<p><a href="questionDetails.php">Ghost 0.7.0 中文版正式发布</a></p>
										<p><span>分类</span>• 幸福快乐滴lion 回复了问题 • 4 人关注 • 4 个回复 • 1600 次浏览 • 23 小时前</p>
									</td>
									<td>
										<p>贡献</p>
										<p><img src="../img/liuchenghua.jpg"></p>
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
					
					<div class="span3 right-nav">
						<div class="right-nav-item">
							<span class="pull-left">
								热门话题
							</span>
							<span class="pull-right">
								<a href="#" class="pull-right">更多 »</a>
							</span>
						</div>
						<hr>
						<div class="right-nav-item">
							<span class="pull-left">
								热门用户
							</span>
							<span class="pull-right">
								<a href="#" class="pull-right">更多 »</a>
							</span>
							<table class="table navTable">
								<tbody>
									<tr>
										<td><img src="../img/liuchenghua.jpg"></td>
										<td>
											<p><a href="#">某某用户</a></p>
											<p>2 个问题, 0 次赞同</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>	
				
				<div class="row-fluid detailsDiv">
					<div class="span9">
						<ul class="nav nav-tabs pull-right">
							<li>
								<button class="btn-link" id="returnListBtn">返回问题列表</button>
							</li>
						</ul>
						<?php include(__DIR__."/../View/questionDetails.php"); ?>
					</div>
					
					<div class="span3 right-nav">
						<?php include(__DIR__."/../View/questionRightNav.php"); ?>
					</div>
				</div>		
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12" id="questionFooter">
				<?php include(__DIR__."/../View/questionFooter.php"); ?>
			</div>
		</div>
	</div>
</body>
</html>
