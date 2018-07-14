<?php
	require_once(__DIR__."/../Model/QuestionManager.php");
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
			$this->assertTrue(!empty($result));
		}
		
		function testGetQuestionDetails(){
			$questionId="5b45c856e9c0f6.75638451";
			$result=$this->questionManager->getQuestionDetails($questionId);
			$this->assertTrue(!empty($result));
		}
	}
?>