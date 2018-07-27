<?php
	require_once(__DIR__.'/../Model/User.php');
	require_once(__DIR__.'/../Model/QuestionManager.php');
	class SelfFansController{
		private $user;
		private $questionManager;
		
		public function __construct(){
			$this->user=new User();
			$this->questionManager=new QuestionManager();
		}
		
		/**
		 * 加载用户的粉丝
		 */
		public function loadUserFans(){
			$fans=$this->user->loadUserFans();
			$resultArr=array("fans"=>$fans);
			return json_encode($resultArr);
		}
		
		public function selectAction(){
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadUserFans"){
				return $this->loadUserFans();
			}		
			return "没有发送合适的请求";
		}
	}
	
	$selfFansController=new SelfFansController();
	echo $selfFansController->selectAction();
	//echo $questionController->replyComment();
?>