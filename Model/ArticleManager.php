<?php
	require_once(__DIR__."/User.php");
	require_once(__DIR__."/../classes/MysqlPdo.php");
	
	/**
	 * 这个文章管理类主要用来对作者的文章信息进行管理
	 */
	class ArticleManager extends User{
		/**
		 * 加载所有作者的文章
		 */
		function loadAllArticles(){
			if($this->isUserLogon()){
				global $pdo;
				$sql="select articleId,title,author,publishDate,(select username from tb_user where userId=publisher) as publisherName,size,label,enable from tb_article";
				$articles=$pdo->getQueryResult($sql);
				return $articles;
			}
			else{
				return "未登录系统，不能进行该操作";
			}
		}
		
		/**
		 * 加载所有作者的文章
		 */
		function queryArticlesByKeyword($keyword,$page=1){
			if($this->isUserLogon()){
				global $pdo;
				//获取分页数据
				$count=$this->queryArticlesByKeywordCount($keyword);
				$pageTotal=($count%5==0)?($count/5):ceil($count/5);//获取总页数，如果是5的倍数，就获取除以5的结果，否则ceil
				//规范化页数，并返回起始页
				$startRow=$this->getStartPage($page,$pageTotal);
				
				$keyword="%".$keyword."%";//使用模糊查询，前后要加百分号
				$paraArr=array(":keyword"=>$keyword);
				$sql="select articleId,title,author,publishDate,(select username from tb_user where userId=publisher) as publisherName,";
				$sql.="size,label,enable from tb_article where (title like :keyword or label like :keyword) limit $startRow,5";
				$articles=$pdo->getQueryResult($sql,$paraArr);
				return $articles;
			}
			else{
				return "未登录系统，不能进行该操作";
			}
		}
		
		/**
		 * 获取通过关键字查询到的文章个数
		 */
		function queryArticlesByKeywordCount($keyword){
			if($this->isUserLogon()){
				global $pdo;				
				$username=$_SESSION['username'];
				$keyword="%".$keyword."%";//使用模糊查询，前后要加百分号
				$paraArr=array(":username"=>$username,":keyword"=>$keyword);
				$sql="select count(*) as articleCount from tb_article where (title like :keyword or label like :keyword)";
				$count=$pdo->getOneFiled($sql,"articleCount",$paraArr);
				return $count;
			}
			else{
				return "未登录系统，不能进行该操作";
			}
		}
		
		/**
		 * 禁用文章
		 */
		function disableArticle($articleId){
			if($this->isUserLogon()){
				global $pdo;
				$paraArr=array(":articleId"=>$articleId);
				$sql="update tb_article set enable=0 where articleId=:articleId";
				$disabledArticleCount=$pdo->getUIDResult($sql,$paraArr);
				return $disabledArticleCount;
			}
			else{
				return "未登录系统，不能进行该操作";
			}
		}
		
		/**
		 * 启用文章
		 */
		function enableArticle($articleId){
			if($this->isUserLogon()){
				global $pdo;
				$paraArr=array(":articleId"=>$articleId);
				$sql="update tb_article set enable=1 where articleId=:articleId";
				$enabledArticleCount=$pdo->getUIDResult($sql,$paraArr);
				return $enabledArticleCount;
			}
			else{
				return "未登录系统，不能进行该操作";
			}
		}
		
		/**
		 * 删除文章
		 */
		function deleteArticle($articleId){
			if($this->isUserLogon()){
				global $pdo;
				$paraArr=array(":articleId"=>$articleId);
				$sql="delete from tb_article where articleId=:articleId";
				$deleteArticleRow=$pdo->getUIDResult($sql,$paraArr);
				return $deleteArticleRow;
			}
			else{
				return "未登录系统，不能进行该操作";
			}
		}
		
		/**
		 * 加载文章列表，用于用户在主页查看
		 */
		function getArticleList($page=1){
			global $pdo;
			$articlesCount=$this->getArticlesCount();
			$pageTotal=ceil($articlesCount/5);//获取总页数
			//规范化页数，并返回起始页
			$startRow=$this->getStartPage($page,$pageTotal);
			//使用分页专用的pdo函数进行查询，该函数有三个参数，对于要传入数组参数的sql查询，这个方法将失效，
			//那时可以对sql语句的limit后面的数字使用字符串拼接，但只应用在这个参数上，且拼接之前要进行数据类型和范围检查
			$sql="select * from tb_article where isPublic=1 and enable=1 order by publishDate desc limit :startRow,5";
			$articles=$pdo->getQueryResultForPager($sql,$startRow);
			return $articles;
		}
		
		/**
		 * 获取文章总数，以便于分页显示
		 */
		function getArticlesCount(){
			global $pdo;
			$sql="select count(*) as artilcesCount from tb_article where isPublic=1 and enable=1";
			$articlesCount=$pdo->getOneFiled($sql, "artilcesCount");
			return $articlesCount;
		}
	}
?>