<?php
	require_once(__DIR__."/../Model/Author.php");
	require_once("TestData.php");
	use PHPUnit\Framework\TestCase;
	class AuthorTest extends TestCase{
		/**
		 * 下面的代码测试向数据库中添加用户
		 */
		private $author;
		
		function setUp(){
			$this->author=new Author();
		}
		
		/**
		 * 测试文章标题是否重复
		 */
		function testIsArticleTitleRepeat(){
			$title=ArticleTitle;
			$isArticleTitleRepeat=$this->author->isArticleTitleRepeat($title);
			$this->assertTrue($isArticleTitleRepeat);
		}
		
		/**
		 * 测试作者写文章
		 */
		function testWriteArticle(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->author->login($password, $username);
			
			$infoArray=array("title"=>ArticleTitle,"author"=>UserName,"size"=>ArticleSize,"label"=>ArticleLabel,
			"content"=>ArticleContent);
			//文章标题没重复时才会写入一篇文章
			$writeArticleCount=$this->author->writeArticle($infoArray);
			if($this->author->isArticleTitleRepeat(ArticleTitle)){
				$this->assertTrue($writeArticleCount==0);
			}
			else{
				$this->assertTrue($writeArticleCount>0);
			}
			
			//测试完之后退出登录
			$this->author->logout();	
		}
		
		/**
		 * 测试加载作者所有文章
		 */
		function testLoadSelfArticles(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->author->login($password, $username);
			
			$articles=$this->author->loadSelfArticles();
			$this->assertTrue(count($articles)>0);
			
			//测试完之后退出登录
			$this->author->logout();	
		}
		
		/**
		 * 加载作者一篇文章的详情
		 */
		function testLoadArticleDetails(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->author->login($password, $username);
			
			$articleId=ArticleId;
			$article=$this->author->loadArticleDetails($articleId);
			$this->assertTrue(count($article)>0);
			
			//测试完之后退出登录
			$this->author->logout();	
		}		
		
		/**
		 * 测试作者删除自己的文章
		 */
		function testDeleteSelfArticle(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->author->login($password, $username);
			
			$articleId=ArticleIdForDelete;
			$deleteArticleRow=$this->author->deleteSelfArticle($articleId);
			//文章被删除一次之后，就不再有效果
			$this->assertTrue($deleteArticleRow>=0);
			
			//测试完之后退出登录
			$this->author->logout();	
		}
		
		/**
		 * 测试发布自己的文章
		 */
		function testPublishSelfArticle(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->author->login($password, $username);
			
			$articleId=ArticleId;
			$publishArticleRow=$this->author->publishSelfArticle($articleId);
			$this->assertTrue(count($publishArticleRow)>0);
			
			//测试完之后退出登录
			$this->author->logout();	
		}
		
		/**
		 * 测试检测文章是否已经发布
		 */
		function testIsArticlePublished(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->author->login($password, $username);
			
			$articleId=ArticleId;
			$publishArticleCount=$this->author->isArticlePublished($articleId);
			$this->assertEquals($publishArticleCount,1);
			
			//测试完之后退出登录
			$this->author->logout();	
		}
		
		/**
		 * 测试检测取消发布自己的文章
		 */
		function testCancelPublishSelfArticle(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->author->login($password, $username);
			
			$articleId=ArticleId;
			$cancelPublishArticleRow=$this->author->cancelPublishSelfArticle($articleId);
			$this->assertEquals($cancelPublishArticleRow,1);
			
			//测试完之后退出登录
			$this->author->logout();	
		}
		
		/**
		 * 测试通过关键字检索自己的文章
		 */
		function testQueryArticlesByKeyword(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->author->login($password, $username);
			
			$keyword="测试";
			$articles=$this->author->queryArticlesByKeyword($keyword);
			$this->assertTrue(count($articles)>0);
			
			//测试完之后退出登录
			$this->author->logout();	
		}
	}

?>