<?php
	require_once(__DIR__.'/../Model/User.php');
	require_once(__DIR__.'/../Model/QuestionManager.php');
	class PersonController{
		private $user;
		private $questionManager;
		
		public function __construct(){
			$this->user=new User();
			$this->questionManager=new QuestionManager();
		}		
		/**
		 * 判断用户是否登录
		 */
		public function isUserLogon(){
			$isUserLogon=$this->user->isUserLogon()?true:false;
			return $isUserLogon;
		}
		
		/**
		 * 通过userId获取用户基本信息
		 */
		public function getUserBaseInfoByUserId(){
			$userId=$_REQUEST['userId']??"";
			$personalInfo=$this->user->getUserBaseInfoByUserId($userId);
			return $personalInfo;
		}
		
		/**
		 * 判断当前登录用户是否已经关注了该用户
		 */
		public function hasUserFollowedUser(){
			$userId=$_REQUEST['userId']??"";
			$hasUserFollowed=$this->user->hasUserFollowed($userId);
			if($hasUserFollowed==1){
				return true;
			}
			else if($hasUserFollowed==0){
				return false;
			}
			else{
				return $hasUserFollowed;
			}
			
		}
	}
?>