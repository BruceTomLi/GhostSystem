<?php
	require_once(__DIR__."/../classes/SessionDBC.php");
	require_once(__DIR__."/../Model/User.php");
	
	class LoginController{
		private $user;
		
		public function __construct(){
			$this->user=new User();
		}
		
		public function login(){
			$password=$_POST['password']??null;
			$emailOrUsername=$_POST['emailOrUsername']??null;
			$isSuccess=$this->user->login($password, $emailOrUsername);
			$loginInfo=array();
			$visitUrl=$_SESSION['visitUrl']??"forum/question.php";
			if($isSuccess=="success"){				
				$loginInfo=array("isSuccess"=>$isSuccess,"visitUrl"=>$visitUrl);
				$loginInfo=json_encode($loginInfo);
				return $loginInfo;//登录成功的情况
			}		
			else{
				$loginInfo=array("isSuccess"=>"fail");
				$loginInfo=json_encode($loginInfo);
				return $loginInfo;//登录成功的情况
			}
		}
		
		public function selectAction(){
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="login"){
				return $this->login();
			}
		}
	}
	
	$loginController=new LoginController();
	//因为页面脚本执行出错的时候也会导致返回结果不为""，导致登录成功，所以修改上面的代码，通过存取json来报告登录状态
	echo $loginController->selectAction();
?>