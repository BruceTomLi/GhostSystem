<?php
	require_once(__DIR__."/User.php");
	require_once(__DIR__."/../classes/MysqlPdo.php");
	
	/**
	 * 这个“作者”类主要用来写一些文章，作者可以对自己的文章进行管理
	 */
	class PowerManager extends User{
		/**
		 * 下面的函数修改权限信息
		 * 系统的权限是固定的几种，不能在前端动态增加权限
		 * tb_authority表中的id和name都应该写死在数据库中，
		 * 只提供权限的说明信息供权限管理员进行修改
		 */
		function changeAuthorityInfo($authorityName,$note){
			if($this->isUserLogon()){
				global $pdo;
				$paraArr=array(":note"=>$note,":name"=>$authorityName);
				$sql="update tb_authority set note=:note where name=:name";
				$affectRow=$pdo->getUIDResult($sql,$paraArr);
				return $affectRow;
			}
			else{
				return "未登录系统，无法进行该操作";
			}
		}
		
		/**
		 * 加载权限信息
		 */
		function loadAuthorityInfo(){
			if($this->isUserLogon()){
				global $pdo;
				$sql="select * from tb_authority";
				$authorities=$pdo->getQueryResult($sql);
				return $authorities;
			}
			else{
				return "未登录系统，无法进行该操作";
			}
		}
		
	}
?>