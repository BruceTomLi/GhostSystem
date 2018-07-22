<?php
	require_once(__DIR__.'/../Model/User.php');
	require_once(__DIR__.'/../Model/QuestionManager.php');
	class SelfFollowedController{
		private $user;
		private $questionManager;
		
		public function __construct(){
			$this->user=new User();
			$this->questionManager=new QuestionManager();
		}		
		
		/**
		 * 加载用户关注的问题
		 */
		public function loadUserFollowedQuestions(){
			$followedQuestions=$this->user->loadUserFollowedQuestions();
			// $resultArr=array("followedQuestions"=>$followedQuestions);
			$result=json_encode($followedQuestions);
			return $result;
		}
		
		public function selectAction(){			
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadUserFollowedQuestions"){
				return $this->loadUserFollowedQuestions();
			}			
			return "没有发送合适的请求";
		}
	}
	
	$selfFollowedController=new SelfFollowedController();
	echo $selfFollowedController->selectAction();
	//echo $questionController->replyComment();
?>