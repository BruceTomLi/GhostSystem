<?php
	require_once(__DIR__.'/../Model/User.php');
	require_once(__DIR__.'/../Model/QuestionManager.php');
	class SelfSettingController{
		private $user;
		private $questionManager;
		
		public function __construct(){
			$this->user=new User();
			$this->questionManager=new QuestionManager();
		}		
		
		function isUserLogon(){
			return $this->user->isUserLogon();
		}
		
		/**
		 * 加载管理页面时，加载出用户的个人信息
		 * loadUserInfo()会判断用户是否登录，所以不应在Controller里面再进行判断
		 */
		function loadUserInfo(){
			return json_encode($this->user->loadUserInfo());
		}
		
		/**
		 * 下面的函数修改用户个人信息
		 */
		function changeUserInfo(){
			$userInfo=array("username"=>$_REQUEST['username'],"email"=>$_REQUEST['email'],
				"sex"=>$_REQUEST['sex'],"job"=>$_REQUEST['job'],"province"=>$_REQUEST['province'],
				"city"=>$_REQUEST['city'],"oneWord"=>$_REQUEST['oneWord']);
			//先修改一般的信息
			$affectRow=$this->user->changeSelfInfo($userInfo);
			//使用数组和json格式对放回的信息进行封装，这样即使修改信息失败，也能在前台看到合适的提示信息
			$resultArr=array("affectRow"=>$affectRow);			
			return json_encode($resultArr);
		}
		
		/**
		 * 下面的函数修改用户密码
		 */
		function changeUserPassword(){
			$oldPassword=$_REQUEST['oldPassword'];
			$newPassword=$_REQUEST['newPassword'];
			$affectRow=$this->user->changeSelfPassword($oldPassword, $newPassword);
			$resultArr=array("affectRow"=>$affectRow);
			return json_encode($resultArr);
		}
		
		/**
		 * 下面的函数用来上传用户的头像
		 * 上传用户的文件的操作有点麻烦，因为需要判断文件的类型和大小
		 * 只有各方面符合要求之后才能上传，这也是出于安全性的考虑
		 */
		function uploadSelfHeading(){
			$fileName=$_FILES['heading']['tmp_name']??"";
			$realName=$_FILES['heading']['name']??"";
			if ((($_FILES["heading"]["type"] == "image/gif") || ($_FILES["heading"]["type"] == "image/jpeg")
				|| ($_FILES["heading"]["type"] == "image/png") || ($_FILES["heading"]["type"] == "image/pjpeg")
				|| ($_FILES["heading"]["type"] == "image/x-png") )
				&& ($_FILES["heading"]["size"] < 500000))
			{
				if(!empty($fileName) && !empty($realName)){
					$resultArr=$this->user->uploadSelfHeading($fileName, $realName);
					return json_encode($resultArr);
				}
				else{
					$resultArr=array("affectRow"=>"用户没有上传有效头像文件");
					return json_encode($resultArr);
				}
			}
			else{
				$resultArr=array("affectRow"=>"您上传的图片类型或者大小不符合规范");
				return json_encode($resultArr);
			}			
		}
		
		/**
		 * 下面的函数选择用户的请求动作，并给出相应的相应
		 */
		function selectAction(){
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadUserInfo"){
				return $this->loadUserInfo();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="changeUserInfo"){
				return $this->changeUserInfo();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="changeUserPassword"){
				return $this->changeUserPassword();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="uploadSelfHeading"){
				return $this->uploadSelfHeading();
			}
		}
	}
	
	$selfSettingController=new SelfSettingController();
	echo $selfSettingController->selectAction();
	//echo $questionController->replyComment();
?>