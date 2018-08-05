<?php
	require_once(__DIR__."/../Model/QuestionManager.php");
	require_once("TestData.php");
	use PHPUnit\Framework\TestCase;
	
	class QuestionManagerTest extends TestCase{
		private $questionManager;
		
		function setUp(){
			$this->questionManager=new QuestionManager();
		} 
		/**
		 * 下面的代码测试问题管理员加载所有的问题列表
		 */
		function testGetAllQuestionList(){
			$result=$this->questionManager->getAllQuestionList();
			$this->assertTrue(count($result)>0);
		}
		
		/**
		 * 测试获取问题详情
		 */
		function testGetQuestionDetails(){
			$questionId=QuestionId;
			$result=$this->questionManager->getQuestionDetails($questionId);
			$this->assertTrue(count($result)>0);
		}
		/**
		 * 测试为管理员获取所有问题
		 */
		function testGetAllQuestionListForManager(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->questionManager->login($password, $username);
			
			$questions=$this->questionManager->getAllQuestionListForManager();
			$this->assertTrue(count($questions)>0);
			
			//测试完之后退出登录
			$this->questionManager->logout();
		}
		
		/**
		 * 测试检索问题
		 */
		function testQueryQuestionsByKeyword(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->questionManager->login($password, $username);
			
			$keyword="测试";
			$questions=$this->questionManager->queryQuestionsByKeyword($keyword);
			$this->assertTrue(count($questions)>0);
			
			//测试完之后退出登录
			$this->questionManager->logout();
		}
		
	}
?>