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
	}
?>