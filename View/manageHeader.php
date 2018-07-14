<?php
	require_once(__DIR__."/../Controller/ManageController.php");
	$manageController=new ManageController();
	if(!$manageController->isUserLogon()){
		header("Location:../login.php");
		die;
	}
?>
<div id="manageHeaderDetails">
	<!--下面是页面菜单部分-->
	<div class="row-fluid">
		<div class="span12">
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container-fluid headContent">
						<a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar">
						 	<span class="icon-bar"></span>
						 	<span class="icon-bar"></span>
						 	<span class="icon-bar"></span>
						</a>
						<div class="nav-collapse collapse navbar-responsive-collapse">									 
							<ul class="nav navbar-nav">
								<li><a href="../index.php">首页</a></li>
								<li><a href="selfSetting.php">我的信息</a></li>
								<li><a href="selfArticle.php">我的文章</a></li>
								<li><a href="selfQuestion.php">我的问题</a></li>
								<li><a href="selfTopic.php">我的话题</a></li>
								<li><a href="selfFollow.php">我的关注</a></li>
								<li><a href="selfFans.php">我的粉丝</a></li>
					      		<li><a href="user.php">用户</a></li>
					      		<li><a href="role.php">角色</a></li>
					      		<li><a href="authority.php">权限</a></li>
					      		<li><a href="article.php">文章</a></li>
					      		<li><a href="about.php">关于</a></li>							
							</ul>
						</div>								
					</div>
				</div>						
			</div>
		</div>
	</div>
	
	<link rel="stylesheet" type="text/css" href="../css/header.css">
</div>
