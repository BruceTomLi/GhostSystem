<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>问题页</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
		<link href="css/question.css" rel="stylesheet" type="text/css">
		<script src="js/jquery-1.9.1.js"></script>
		<script src="./bootstrap/js/bootstrap.min.js"></script>
		<script src="js/question.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12" id="questionHeader">
					<?php include("View/questionHeader.php"); ?>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
					<div class="row-fluid">
						<div class="span9 queryDiv mainContent">
							<section class="questionDescription">
								<h4>Ghost是什么</h4>
								<hr>
								<p><span>描述：</span>不太明白ghost是做什么用的</p>
								<p><span>时间：</span><span>2018/7/10</span></p>
								<p><button class="btn-link" id="addCommentBtn">添加评论</button></p>
								<div class="addCommentDiv">
									<textarea></textarea><br />
									<button class="btn btn-success">评论</button>
									<button class="btn btn-warning" id="cancelAddComment">取消</button>
								</div>
							</section>	
							<section class="questionAnswers">
								<h4>2个回复</h4>
								<hr>
								<ul>
									<li>
										<ul>
											<li>
												<span>天外天：</span>
												<span>
													不是，软件的bug往往难以全部修复，可以在容许几个不影响主要业务的bug
												的情况下让软件运行下去
												</span>
												<button class="btn-link replyBtn">回复</button>
											</li>
											<li>
												<span>水中水&nbsp;回复&nbsp;天外天：</span>
												<span>
													是的，我也觉得可以在软件没有修复所有bug的时候上线
												</span>
												<button class="btn-link replyBtn">回复</button>
											</li>
										</ul>
									</li>	
									<li>
										<ul>
											<li>
												<span>天外天：</span>
												<span>
													不是，软件的bug往往难以全部修复，可以在容许几个不影响主要业务的bug
												的情况下让软件运行下去
												</span>
												<button class="btn-link replyBtn">回复</button>
											</li>
											<li>
												<span>水中水&nbsp;回复&nbsp;天外天：</span>
												<span>
													是的，我也觉得可以在软件没有修复所有bug的时候上线
												</span>
												<button class="btn-link replyBtn">回复</button>
											</li>
										</ul>
									</li>	
								</ul>	
							</section>
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
											<td><img src="img/liuchenghua.jpg"></td>
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
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12" id="questionFooter">
					<?php include("View/questionFooter.php"); ?>
				</div>
			</div>
		</div>
	</body>
</html>
