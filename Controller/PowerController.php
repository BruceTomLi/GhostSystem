<?php
	require_once(__DIR__.'/../Model/User.php');
	require_once(__DIR__.'/../Model/PowerManager.php');
	class PowerController{
		private $user;
		private $powerManager;
		
		public function __construct(){
			$this->user=new User();
			$this->powerManager=new PowerManager();
		}
		
		/**
		 * 加载权限信息
		 */
		public function loadAuthorityInfo(){
			$resultArr=$this->powerManager->loadAuthorityInfo();
			return json_encode($resultArr);
		}
		
		/**
		 * 修改权限信息
		 */
		public function changeAuthorityInfo(){
			$authorityName=$_REQUEST['authorityName'];
			$note=$_REQUEST['note'];
			$affectRow=$this->powerManager->changeAuthorityInfo($authorityName, $note);
			$result=array("affectRow"=>$affectRow);
			return json_encode($result);
		}
		
		/**
		 * 选择要执行哪个动作
		 */
		public function selectAction(){
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadAuthorityInfo"){
				return $this->loadAuthorityInfo();
			}	
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="changeAuthorityInfo"){
				return $this->changeAuthorityInfo();
			}		
			return "没有发送合适的请求";
		}
	}

	$powerController=new PowerController();
	echo $powerController->selectAction();
?>