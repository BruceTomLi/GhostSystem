<?php
	require_once(__DIR__.'/../Model/UserManager.php');
	class UserController{
		private $userManager;
		
		public function __construct(){
			$this->userManager=new UserManager();
		}
		/**
		 * 加载所有用户信息
		 */
		public function loadAllUserInfo(){
			$users=$this->userManager->loadAllUserInfo();
			return json_encode($users);
		}
		
		/**
		 * 加载用户信息（主要是角色信息）
		 */
		public function loadUserRoleInfo(){
			$userId=$_REQUEST['userId'];
			$userRoles=$this->userManager->loadUserRoleInfo($userId);
			return json_encode($userRoles);
		}
		
		/**
		 * 加载所有的角色信息（用户修改用户角色时，用户勾选相应的角色）
		 */
		public function loadAllRoles(){
			$roles=$this->userManager->loadAllRoles();
			return json_encode($roles);
		}
		
		/**
		 * 更新用户的角色信息
		 */
		public function updateUserRoleInfo(){
			$userId=$_REQUEST['userId'];
			$roles=$_REQUEST['roles'];
			$resultArr=$this->userManager->updateUserRoleInfo($userId,$roles);
			return json_encode($resultArr);
		}

		/**
		 * 通过关键字检索用户信息
		 */
		public function searchUserByKeyword(){
			$page=$_REQUEST['page']??1;
			$keyword=$_REQUEST['keyword']??"";
			$role=$_REQUEST['role']??"";
			$sex=$_REQUEST['sex']??"";
			$enable=$_REQUEST['enable']??"";
			$count=$this->userManager->searchUserByKeywordCount($keyword, $role, $sex, $enable);
			$users=$this->userManager->searchUserByKeyword($keyword, $role, $sex, $enable,$page);
			$resultArr=array("users"=>$users,"count"=>$count);
			return json_encode($resultArr);
		}
		
		/**
		 * 禁用用户
		 */
		public function disableUser(){
			$userId=$_REQUEST['userId'];
			$disabledUser=$this->userManager->disableUser($userId);
			$resultArr=array("disabledUser"=>$disabledUser);
			return json_encode($resultArr);			
		}
		
		/**
		 * 启用用户
		 */
		public function enableUser(){
			$userId=$_REQUEST['userId'];
			$enabledUser=$this->userManager->enableUser($userId);
			$resultArr=array("eabledUser"=>$enabledUser);
			return json_encode($resultArr);			
		}
		
		/**
		 * 批量禁用用户
		 */
		public function disableQueryUsers(){
			$page=$_REQUEST['page']??1;
			$keyword=$_REQUEST['keyword']??"";
			$role=$_REQUEST['role']??"";
			$sex=$_REQUEST['sex']??"";
			$enable=$_REQUEST['enable']??"";
			$count=$this->userManager->disableQueryUsers($keyword, $role, $sex, $enable);
			$resultArr=array("count"=>$count);
			return json_encode($resultArr);
		}
		
		/**
		 * 批量启用用户
		 */
		public function enableQueryUsers(){
			$page=$_REQUEST['page']??1;
			$keyword=$_REQUEST['keyword']??"";
			$role=$_REQUEST['role']??"";
			$sex=$_REQUEST['sex']??"";
			$enable=$_REQUEST['enable']??"";
			$count=$this->userManager->enableQueryUsers($keyword, $role, $sex, $enable);
			$resultArr=array("count"=>$count);
			return json_encode($resultArr);
		}
		
		
		/**
		 * 选择要执行哪个动作
		 */
		public function selectAction(){
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadAllUserInfo"){
				return $this->loadAllUserInfo();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadUserRoleInfo"){
				return $this->loadUserRoleInfo();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadAllRoles"){
				return $this->loadAllRoles();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="updateUserRoleInfo"){
				return $this->updateUserRoleInfo();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="searchUserByKeyword"){
				return $this->searchUserByKeyword();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="disableUser"){
				return $this->disableUser();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="enableUser"){
				return $this->enableUser();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="disableQueryUsers"){
				return $this->disableQueryUsers();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="enableQueryUsers"){
				return $this->enableQueryUsers();
			}
		}
	}

	$userController=new UserController();
	echo $userController->selectAction();
?>