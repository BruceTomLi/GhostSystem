<?php
	// session_start();
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
			$username=$this->user->login($password, $emailOrUsername);
			$loginInfo=array();
			if(!empty($username)){				
				$loginInfo=array("username"=>$username);
				$loginInfo=json_encode($loginInfo);
				return $loginInfo;//登录成功的情况
			}		
			else{
				$loginInfo=array("username"=>"");
				$loginInfo=json_encode($loginInfo);
				return $loginInfo;//登录失败的情况
			}
		}
	}
	
	$loginController=new LoginController();
	//因为页面脚本执行出错的时候也会导致返回结果不为""，导致登录成功，所以修改上面的代码，通过存取json来报告登录状态
	echo $loginController->login();
?>