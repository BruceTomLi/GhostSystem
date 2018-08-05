<?php
	require_once(__DIR__."/../Model/TopicManager.php");
	require_once("TestData.php");
	use PHPUnit\Framework\TestCase;
	
	class TopicManagerTest extends TestCase{
		private $topicManager;
		
		function setUp(){
			$this->topicManager=new TopicManager();
		} 
		/**
		 * 下面的代码测试问题管理员加载所有的问题列表
		 */
		function testGetAllTopicList(){
			$result=$this->topicManager->getAllTopicList();
			$this->assertTrue(count($result)>0);
		}
		
		/**
		 * 测试获取问题详情
		 */
		function testGetTopicDetails(){
			$topicId=TopicId;
			$result=$this->topicManager->getTopicDetails($topicId);
			$this->assertTrue(count($result)>0);
		}
		/**
		 * 测试为管理员获取所有问题
		 */
		function testGetAllTopicListForManager(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->topicManager->login($password, $username);
			
			$topics=$this->topicManager->getAllTopicListForManager();
			$this->assertTrue(count($topics)>0);
			
			//测试完之后退出登录
			$this->topicManager->logout();
		}
		
		/**
		 * 测试检索问题
		 */
		function testQueryTopicsByKeyword(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;
			$this->topicManager->login($password, $username);
			
			$keyword="测试";
			$topics=$this->topicManager->queryTopicsByKeyword($keyword);
			$this->assertTrue(count($topics)>0);
			
			//测试完之后退出登录
			$this->topicManager->logout();
		}
		
	}
?>