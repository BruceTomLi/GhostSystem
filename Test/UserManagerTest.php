<?php
	require_once(__DIR__."/../Model/UserManager.php");
	require_once("TestData.php");
	use PHPUnit\Framework\TestCase;
	class RoleManagerTest extends TestCase{
		/**
		 * 下面的代码测试向数据库中添加用户
		 */
		private $userManager;
		
		function setUp(){
			$this->userManager=new UserManager();
		}
		
		/**
		 * 测试给加载所有用户信息
		 */
		function testLoadAllUserInfo(){
			//测试这个功能需要先登录，而且还需要用户拥有权限管理员的角色
			$username=UserName;
			$password=Password;
			$this->userManager->login($password, $username);
			
			$users=$this->userManager->loadAllUserInfo();
			$this->assertTrue(count($users)>0);
			
			//测试完之后退出登录
			$this->userManager->logout();				
		}
		
		/**
		 * 测试给加载用户信息(主要是角色信息)
		 */
		function testLoadUserRoleInfo(){
			//测试这个功能需要先登录，而且还需要用户拥有权限管理员的角色
			$username=UserName;
			$password=Password;
			$this->userManager->login($password, $username);
			
			$userId=UserId;
			$userRoles=$this->userManager->loadUserRoleInfo($userId);
			$this->assertTrue(count($userRoles)>0);
			
			//测试完之后退出登录
			$this->userManager->logout();
		}
		
		/**
		 * 测试加载所有的角色信息
		 */
		function testLoadAllRoles(){
			//测试这个功能需要先登录，而且还需要用户拥有权限管理员的角色
			$username=UserName;
			$password=Password;
			$this->userManager->login($password, $username);
			
			$roles=$this->userManager->loadAllRoles();
			$this->assertTrue(count($roles)>0);
			
			//测试完之后退出登录
			$this->userManager->logout();
		}
		
		/**
		 * 测试修改用户角色信息
		 */
		function testUpdateUserRoleInfo(){
			//测试这个功能需要先登录，而且还需要用户拥有权限管理员的角色
			$username=UserName;
			$password=Password;
			$this->userManager->login($password, $username);
			
			$userId=UserId;
			$roles=UserRoles;
			$resultArr=$this->userManager->updateUserRoleInfo($userId, $roles);
			$this->assertTrue($resultArr['userRoleDeleteRow']>0 && $resultArr['userRoleAddRow']>0);
			
			//测试完之后退出登录
			$this->userManager->logout();
		}
		
		/**
		 * 测试通过关键字搜索用户信息
		 */
		function testSearchUserByKeyword(){
			$keyword="wangwu";
			$role=RoleName;//这里的roleId是测试角色
			$sex=1;
			$enable=1;
			
			//测试这个功能需要先登录，而且还需要用户拥有权限管理员的角色
			$username=UserName;
			$password=Password;
			$this->userManager->login($password, $username);
			
			$users=$this->userManager->searchUserByKeyword($keyword, $role, $sex, $enable);
			echo count($users);
			$this->assertTrue(count($users)>0);
			
			//测试完之后退出登录
			$this->userManager->logout();
		}
		
		/**
		 * 测试禁用用户，禁用之后将导致用户无法登录，导致其他测试无法进行，所以在用户没有logout之前同时测试禁用和启用
		 */
		function testDisableUser(){
			//测试这个功能需要先登录，而且还需要用户拥有权限管理员的角色
			$username=UserName;
			$password=Password;
			$this->userManager->login($password, $username);
			
			$userId=UserId;
			//禁用用户
			$disabledUser=$this->userManager->disableUser($userId);
			echo count($disabledUser);
			$this->assertTrue(count($disabledUser)>0);
			//启用用户
			$enabledUser=$this->userManager->enableUser($userId);
			echo count($enabledUser);
			$this->assertTrue(count($enabledUser)>0);
			
			//测试完之后退出登录
			$this->userManager->logout();
		}
		
		/**
		 * 测试启用用户，上面的测试已经测试了启用用户，这个测试用例是可有可无的
		 */
		function testEnableUser(){
			//测试这个功能需要先登录，而且还需要用户拥有权限管理员的角色
			$username=UserName;
			$password=Password;
			$this->userManager->login($password, $username);
			
			$userId=UserId;
			$enabledUser=$this->userManager->enableUser($userId);
			echo count($enabledUser);
			$this->assertTrue(count($enabledUser)>=0);
			
			//测试完之后退出登录
			$this->userManager->logout();
		}
		
		/**
		 * 测试禁用查询到的用户
		 */
		function testDisableQueryUsers(){
			$keyword="李云天";
			$role=RoleName;//这里的roleId是测试角色
			$sex=1;
			$enable="";
			
			//测试这个功能需要先登录，而且还需要用户拥有权限管理员的角色
			$username=UserName;
			$password=Password;
			$this->userManager->login($password, $username);
			
			$count=$this->userManager->disableQueryUsers($keyword, $role, $sex, $enable);
			$this->assertTrue($count>0);
			
			//测试完之后退出登录
			$this->userManager->logout();
		}
		
		/**
		 * 测试启用查询到的用户
		 */
		function testEnableQueryUsers(){
			$keyword="李云天";
			$role=RoleName;//这里的roleId是测试角色
			$sex=1;
			$enable="";
			
			//测试这个功能需要先登录，而且还需要用户拥有权限管理员的角色
			$username=UserName;
			$password=Password;
			$this->userManager->login($password, $username);
			
			$count=$this->userManager->enableQueryUsers($keyword, $role, $sex, $enable);
			$this->assertTrue($count>0);
			
			//测试完之后退出登录
			$this->userManager->logout();
		}
	}
?>