<?php
	require_once(__DIR__."/../Model/ArticleManager.php");
	
	class IndexController{
		private $articleManager;
		
		public function __construct(){
			$this->articleManager=new ArticleManager();
		}
		
		/**
		 * 获取所有文章信息
		 */
		public function getArticleList(){
			$page=$_REQUEST['page'];
			$articles=$this->articleManager->getArticleList($page);
			$articlesCount=$this->articleManager->getArticlesCount();
			$resultArr=array("articles"=>$articles,"count"=>$articlesCount);
			return json_encode($resultArr);
		}
		
		/**
		 * 选择要执行哪个动作
		 */
		public function selectAction(){
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="getArticleList"){
				return $this->getArticleList();
			}
		}
	}

	$indexController=new IndexController();
	echo $indexController->selectAction();
?>