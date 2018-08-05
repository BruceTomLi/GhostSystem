<?php
	require_once(__DIR__.'/../Model/User.php');
	require_once(__DIR__.'/../Model/Author.php');
	class SelfArticleController{
		private $author;
		
		public function __construct(){
			$this->author=new Author();
		}		
		
		/**
		 * 写文章
		 */
		public function writeArticle(){
			$title=$_REQUEST['title'];
			$author=$_REQUEST['author'];
			$label=$_REQUEST['label'];
			$content=$_REQUEST['content']??"";
			$size=strlen($content);
			$infoArray=array("title"=>$title,"author"=>$author,"label"=>$label,"content"=>$content,"size"=>$size);
			
			$writeArticleCount=$this->author->writeArticle($infoArray);
			$resultArr=array("writeArticleCount"=>$writeArticleCount);
			$result=json_encode($resultArr);
			return $result;
		}
		
		/**
		 * 加载作者所有的文章
		 */
		public function loadSelfArticles(){
			$articles=$this->author->loadSelfArticles();
			$resultArr=array("articles"=>$articles);
			return json_encode($resultArr);
		}
		
		/**
		 * 查询作者的文章
		 */
		public function queryArticlesByKeyword(){
			$keyword=$_REQUEST['keyword']??"";
			$page=$_REQUEST['page']??1;
			$count=$this->author->queryArticlesByKeywordCount($keyword);
			$articles=$this->author->queryArticlesByKeyword($keyword,$page);
			$resultArr=array("articles"=>$articles,"count"=>$count);
			return json_encode($resultArr);
		}
		
		/**
		 * 加载作者一篇文章的详情
		 */
		public function loadArticleDetails(){
			$articleId=$_REQUEST['articleId'];
			$articleDetails=$this->author->loadArticleDetails($articleId);
			$resultArr=array("articleDetails"=>$articleDetails);
			return json_encode($resultArr,true);
		}
		
		/**
		 * 删除作者自己写的作文
		 */
		public function deleteSelfArticle(){
			$articleId=$_REQUEST['articleId'];
			$deleteArticleRow=$this->author->deleteSelfArticle($articleId);
			$resultArr=array("deleteArticleRow"=>$deleteArticleRow);
			return json_encode($resultArr);
		}
		
		/**
		 * 发布作者自己的文章
		 */
		public function publishSelfArticle(){
			$articleId=$_REQUEST['articleId'];
			$publishArticleRow=$this->author->publishSelfArticle($articleId);
			$resultArr=array("publishArticleRow"=>$publishArticleRow);
			return json_encode($resultArr);
		}
		
		/**
		 * 取消发布自己的文章
		 */
		public function cancelPublishSelfArticle(){
			$articleId=$_REQUEST['articleId'];
			$cancelPublishArticleRow=$this->author->cancelPublishSelfArticle($articleId);
			$resultArr=array("cancelPublishArticleRow"=>$cancelPublishArticleRow);
			return json_encode($resultArr);
		}
		 
		 
		public function selectAction(){			
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="writeArticle"){
				return $this->writeArticle();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadSelfArticles"){
				return $this->loadSelfArticles();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="queryArticlesByKeyword"){
				return $this->queryArticlesByKeyword();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadArticleDetails"){
				return $this->loadArticleDetails();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="deleteSelfArticle"){
				return $this->deleteSelfArticle();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="publishSelfArticle"){
				return $this->publishSelfArticle();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="cancelPublishSelfArticle"){
				return $this->cancelPublishSelfArticle();
			}
		}
	}
	
	$selfArticleController=new SelfArticleController();
	echo $selfArticleController->selectAction();
	//echo $questionController->replyComment();
?>