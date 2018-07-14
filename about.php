<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Ghost 快捷手册</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="css/handbook.css" />
		<script src="js/jquery-1.9.1.js"></script>
		<script src="./bootstrap/js/bootstrap.min.js"></script>
		<script src="js/loadHeaderFooter.js"></script>
		<script src="js/loadRightNav.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<header id="header">
				<?php include("View/header.php"); ?>
			</header>
		
			<div class="row-fluid mainContent">
				<div class="span12">
					<div class="row-fluid">
						<div class="span8" id="articleContent">
							<article class="post page">

							    <header class="post-head">
							        <h1 class="post-title">关于 Ghost 中文网</h1>
							    </header>
							
							    <section class="post-content">
							        <blockquote>
							  			<p>Ghost 是基于 Node.js 的开源博客平台，由前 WordPress UI 部门主管 <a href="http://john.onolan.org/">John O’Nolan</a> 和 WordPress 高级工程师（女） <a href="http://hannah.wf/">Hannah Wolfe</a> 创立，目的是为了给用户提供一种更加纯粹的内容写作与发布平台。</p>
									</blockquote>
							
									<p><img src="http://static.ghostchina.com/image/b/5e/877fa798be75dbe791dba07ac4811.jpg" alt="John O’Nolan 和 Hannah Wolfe" /></p>
							
									<p>2013 年 9 月份，Ghost 正式向公众发布，Ghost 中文网也随之上线。 <br />
									Ghost 中文网的目标是致力于 Ghost 开源博客系统在国内的推广，与广大 Ghost 用户分享 Ghost 相关的知识、技巧。</p>
									
									<hr />
									
									<p>如果你也喜欢 Ghost ，可以通过以下方式与我们交流：</p>
									
									<ul>
										<li>微博：<a href="http://weibo.com/ghostchinacom">@ghostchinacom</a></li>
										<li>QQ群：309172035</li>
									</ul>
									
									<hr />
									
									<p>合作站点：</p>
									
									<ul>
										<li><a href="http://www.bootcss.com/">Bootstrap 中文网</a></li>
										<li><a href="http://www.bootcdn.cn/">开放 CDN 服务</a></li>
										<li><a href="http://www.gruntjs.net/">Grunt 中文网</a></li>
										<li><a href="http://www.golaravel.com/">Laravel 中文网</a></li>
										<li><a href="http://www.jquery123.com/">jQuery 中文文档</a></li>
									</ul>
									
									<p>合作伙伴：</p>
									
									<ul>
										<li><a href="http://www.aliyun.com/">阿里云</a></li>
									</ul>
									
									<p>赞助商：</p>
									
									<ul>
										<li><a href="https://www.upyun.com/">又拍云</a></li>
										<li><a href="http://www.ucloud.cn/">UCloud</a></li>
										<li><a href="http://www.qiniu.com/">七牛云存储</a></li>
									</ul>
							    </section>
							
							</article>
								
						</div>
						<div class="span4"  id="rightNav">
							<?php include("View/rightNav.php"); ?>
						</div>	
					</div>
				</div>
			</div>
			
			<footer id="footer">
				<?php include("View/footer.php"); ?>
			</footer>	
		</div>
	</body>
</html>
