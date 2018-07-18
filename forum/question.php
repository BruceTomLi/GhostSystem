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
						<section class="questionDescription">
							<div id="questionDetails">
								<h4>Ghost是什么</h4>
								<hr>
								<p><span>描述：</span>不太明白ghost是做什么用的</p>
								<p><span>时间：</span><span>2018/7/10</span></p>
								<p><button class="btn-link" id="addCommentBtn">添加评论</button></p>
								<input type="hidden" id="questionIdHidden" value="这里记录questionId"  />	
							</div>													
							<div id="addCommentDiv">
								<textarea></textarea><br />
								<button class="btn btn-success" value="" id="submitCommentBtn" onClick='commentQuestion(this)'>评论</button>
								<button class="btn btn-warning" id="cancelAddComment" onClick='cancelAddComment(this)'>取消</button>
							</div>
						</section>	
						<section id="questionAnswers">
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
											<button class='btn-link disableBtn' value='传入questionId' onClick='disableCommentForQuestion(this)'>删除</button>
											<button class='btn-link replyBtn' value='传入questionId' onClick='showReplyDiv(this)'>回复</button>
											<button class='btn-link detailsBtn' value='传入questionId' onClick='getReplysForComment(this)'>详情</button>
											<div class='replyCommnetDiv'><textarea></textarea>
												<br />
												<button class='btn btn-success replyCommentBtn' value='传入commentId' onClick='replyComment(this)'>回复</button>
												<button class='btn btn-warning cancelReplyComment' onclick='cancelReplyComment(this)'>取消</button>
											</div>
										</li>									
										<div class="replysForComment">
											<li>
												<span>水中水&nbsp;回复&nbsp;天外天：</span>
												<span>
													是的，我也觉得可以在软件没有修复所有bug的时候上线
												</span>
												<button class='btn-link disableBtn' value='传入replyId' onClick='disableReplyForReply(this)'>删除</button>
												<button class='btn-link replyBtn showReplyReplyBtn' value='传入replyId' onClick='showReplyDiv(this)'>回复</button>
												<div class='replyReplyDiv'><textarea></textarea>
													<br />
													<button class='btn btn-success replyReplyBtn' onClick='replyReply(this)'>回复</button>
													<button class='btn btn-warning cancelReplyReply' onclick='cancelReplyReply(this)'>取消</button>
												</div>
											</li>
										</div>										
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
