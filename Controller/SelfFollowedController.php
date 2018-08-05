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
			$result=json_encode($followedQuestions);
			return $result;
		}
		
		/**
		 * 加载用户关注的话题
		 */
		public function loadUserFollowedTopics(){
			$followedTopics=$this->user->loadUserFollowedTopics();
			$result=json_encode($followedTopics);
			return $result;
		}
		
		/**
		 * 加载用户关注的人
		 */
		public function loadUserFollowedUsers(){
			$followedUsers=$this->user->loadUserFollowedUsers();
			$result=json_encode($followedUsers);
			return $result;
		}
		
		/**
		 * 取消对用户的关注
		 */
		public function cancelFollowUser(){
			$starId=$_REQUEST['userId'];
			$affectRow=$this->user->deleteFollow($starId);
			$resultArr=array("affectRow"=>$affectRow);
			$result=json_encode($resultArr);
			return $result;
		}
		
		
		public function selectAction(){			
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadUserFollowedQuestions"){
				return $this->loadUserFollowedQuestions();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadUserFollowedTopics"){
				return $this->loadUserFollowedTopics();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadUserFollowedUsers"){
				return $this->loadUserFollowedUsers();
			}	
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="cancelFollowUser"){
				return $this->cancelFollowUser();
			}	
			return "没有发送合适的请求";
		}
	}
	
	$selfFollowedController=new SelfFollowedController();
	echo $selfFollowedController->selectAction();
	//echo $questionController->replyComment();
?>