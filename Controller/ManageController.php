<?php
	require_once(__DIR__."/../Model/User.php");

	class ManageController{
		private $user;
		
		function __construct(){
			$this->user=new User();
		}
		
		function isUserLogon(){
			return $this->user->isUserLogon();
		}
	}
?>