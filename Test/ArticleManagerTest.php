<?php
	require_once(__DIR__."/../Model/ArticleManager.php");
	require_once("TestData.php");
	use PHPUnit\Framework\TestCase;
	class ArticleManagerTest extends TestCase{
		/**
		 * 下面的代码测试向数据库中添加用户
		 */
		private $articleManager;
		
		function setUp(){
			$this->articleManager=new ArticleManager();
		}
		
		/**
		 * 测试加载所有的文章
		 */
		function testLoadAllArticles(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->articleManager->login($password, $username);
			
			$articles=$this->articleManager->loadAllArticles();
			$this->assertTrue(count($articles)>0);
			
			//测试完之后退出登录
			$this->articleManager->logout();	
		}
		
		/**
		 * 测试禁用文章
		 */
		function testDisableArticle(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->articleManager->login($password, $username);
			
			$articleId=ArticleId;
			$articleCount=$this->articleManager->disableArticle($articleId);
			$this->assertTrue($articleCount>0);
			
			//测试完之后退出登录
			$this->articleManager->logout();
		}
		
		/**
		 * 测试启用文章
		 */
		function testEnableArticle(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->articleManager->login($password, $username);
			
			$articleId=ArticleId;
			$articleCount=$this->articleManager->enableArticle($articleId);
			$this->assertTrue($articleCount>0);
			
			//测试完之后退出登录
			$this->articleManager->logout();
		}
		
		/**
		 * 测试删除文章
		 */
		function testDeleteArticle(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->articleManager->login($password, $username);
			
			$articleId=ArticleIdForDelete;
			$deleteArticleRow=$this->articleManager->deleteArticle($articleId);
			$this->assertTrue($deleteArticleRow>=0);
			
			//测试完之后退出登录
			$this->articleManager->logout();
		}
		
		/**
		 * 测试获取文章列表
		 */
		function testGetArticleList(){
			$articles=$this->articleManager->getArticleList();
			$this->assertTrue(count($articles)>0);
		}
		
		/**
		 * 测试获取文章总数
		 */
		function testGetArticlesCount(){
			$articlesCount=$this->articleManager->getArticlesCount();
			$this->assertTrue($articlesCount>0);
		}
		/**
		 * 测试通过关键字检索文章
		 */
		function testQueryArticlesByKeyword(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->articleManager->login($password, $username);
			
			$keyword="二维";
			$articles=$this->articleManager->queryArticlesByKeyword($keyword);
			$this->assertTrue(count($articles)>0);
			
			//测试完之后退出登录
			$this->articleManager->logout();	
		}
	}
?>