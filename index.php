<?php
	$page=$_REQUEST['page']??1;//接收页数信息，以便于分页显示
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Ghost系统主页</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
		<link href="css/index.css" rel="stylesheet" type="text/css">
		<script src="js/jquery-1.9.1.js"></script>
		<script src="./bootstrap/js/bootstrap.min.js"></script>
		<script src="js/MyPager.js"></script>
		<script src="js/index.js"></script>
	</head>
	<body>		
		<!--存放页数信息，以便于分页显示-->
		<div>
			<input type="hidden" id="pageHidden" value="<?php echo $page; ?>"/>
		</div>
		<div class="container-fluid">
			<header id="header">
				<?php include("View/header.php"); ?>
			</header>
			<!--下面是页面主体部分-->
			<div class="row-fluid mainContent">
				<div class="span12">
					<div class="row-fluid">
						<div class="span8">
							<div  id="articleDetail">
								<div class="hero-unit">
									<h1 class="artilceTitle">
										5 年的时间、300 万美元的营收，这是我们创建 Ghost 的过程中学到的一切
									</h1>
									<span>作者：王赛 • 2018年5月17日</span>
									<p>
										尚未译完，改天再译 原作者：JOHN O'NOLAN, HANNAH WOLFE 上周是 Ghost 从 Kickstarter 上推广算起的五周年纪念日。 利用这些里程碑来标记重要时刻并反思迄今为止的旅程总是显得很有趣。在上一个四周年纪念日里，我谈到了营收里程碑
									</p>
									<p>
										<button  class="btn btn-primary defaultBtn">阅读全文</button>
									</p>
								</div>
								<div class="hero-unit">
									<h1 class="artilceTitle">
										主题模板和博客支持本地化了！
									</h1>
									<span>作者：王赛 • 2018年1月22日</span>
									<p>
										上周我们 发布 了一个新版本，包含了大家期盼已久的功能：主题模板和网站对本地化的支持。 这个功能完全是由我们的一个贡献者（Juan）开发的，Ghost 基金提供了支持。 我们已经针对这个功能编写了完整的文档，下面就来介绍一下这个功能是如何工作的： 网站本地化 你可以在 Ghos
									</p>
									<p>
										<a class="btn btn-primary defaultBtn" href="#">阅读全文</a>
									</p>
								</div>
								<div class="hero-unit">
									<h1 class="artilceTitle">
										Android 版 Ghost 客户端来了！
									</h1>
									<span>作者：王赛 • 2017年11月8日</span>
									<p>
										<img src="img/GhostApp.jpg" />
										Ghost 从一开始就支持响应式 Web 使用体验，但是我们今天仍然向前迈出了一大步 -- 推出 Android 平台原生 APP ！ 我们一直试图为 Ghost 用户构建一个可靠的移动端 Web 体验，但不可避免地，它在它所能做的事情上仍然是相当受限的。即便是在 2017 年的	
									</p>
									<p>
										<a class="btn btn-primary defaultBtn" href="#">阅读全文</a>
									</p>
								</div>
							</div>
							
							<div class="pagination" id="paginationDiv">
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
