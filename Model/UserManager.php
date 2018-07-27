<?php
	require_once(__DIR__."/User.php");
	require_once(__DIR__."/../classes/MysqlPdo.php");
	
	/**
	 * 这个“用户管理员”类主要用来修改用户的角色
	 */
	class UserManager extends User{
		/**
		 * 加载所有的用户信息
		 */
		function loadAllUserInfo(){
			if($this->isUserLogon()){
				global $pdo;
				$sql="call pro_getUsersHasRoles()";
				$users=$pdo->getQueryResult($sql);
				return $users;
			}
			else{
				return "用户未登录，无法进行此操作";
			}
		}
	}
?>