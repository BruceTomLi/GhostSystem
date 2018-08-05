<?php
	require_once(__DIR__.'/../Model/Author.php');
	require_once(__DIR__.'/../Model/ArticleManager.php');
	class ArticleController{
		//引入author是为了使用它的loadArticleDetails方法
		private $author;
		private $articleManager;
		
		public function __construct(){
			$this->author=new Author();
			$this->articleManager=new ArticleManager();
		}
		
		/**
		 * 加载所有的文章信息
		 */
		function loadAllArticles(){
			$articles=$this->articleManager->loadAllArticles();
			$resultArr=array("articles"=>$articles);
			return json_encode($resultArr);
		}
		
		/**
		 * 查询文章
		 */
		public function queryArticlesByKeyword(){
			$keyword=$_REQUEST['keyword']??"";
			$page=$_REQUEST['page']??1;
			$count=$this->articleManager->queryArticlesByKeywordCount($keyword);
			$articles=$this->articleManager->queryArticlesByKeyword($keyword,$page);
			$resultArr=array("articles"=>$articles,"count"=>$count);
			return json_encode($resultArr);
		}
		
		/**
		 * 禁用文章
		 */
		function disableArticle(){
			$articleId=$_REQUEST['articleId'];
			$articleCount=$this->articleManager->disableArticle($articleId);
			$resultArr=array("articleCount"=>$articleCount);
			return json_encode($resultArr);
		}
		
		/**
		 * 启用文章
		 */
		function enableArticle(){
			$articleId=$_REQUEST['articleId'];
			$articleCount=$this->articleManager->enableArticle($articleId);
			$resultArr=array("articleCount"=>$articleCount);
			return json_encode($resultArr);
		}
		
		/**
		 * 删除文章
		 */
		function deleteArticle(){
			$articleId=$_REQUEST['articleId'];
			$articleCount=$this->articleManager->deleteArticle($articleId);
			$resultArr=array("articleCount"=>$articleCount);
			return json_encode($resultArr);
		}
		
		/**
		 * 选择要执行哪个动作
		 */
		public function selectAction(){
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadAllArticles"){
				return $this->loadAllArticles();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="queryArticlesByKeyword"){
				return $this->queryArticlesByKeyword();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="disableArticle"){
				return $this->disableArticle();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="enableArticle"){
				return $this->enableArticle();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="deleteArticle"){
				return $this->deleteArticle();
			}
		}
	}

	$articleManager=new ArticleController();
	echo $articleManager->selectAction();
?>