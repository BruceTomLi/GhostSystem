<?php
	require_once(__DIR__."/User.php");
	require_once(__DIR__."/../classes/MysqlPdo.php");
	
	/**
	 * 这个“问题管理员”类主要用来写一些批量管理问题的业务
	 */
	class QuestionManager extends User{
		/**
		 * 下面的方法用来按照时间顺序加载用户提出的问题
		 * 由于前台的问题页需要加载所有问题供用户浏览，所以这里调用函数是不需要用户登录的
		 */
		function getAllQuestionList(){
			global $pdo;
			$sql="select * from tb_question order by askDate desc";
			$result=$pdo->getQueryResult($sql);
			return $result;
		}
		
		function getQuestionDetails($questionId){
			global $pdo;
			$paraArr=array(":questionId"=>$questionId);			
			$sql="select * from tb_question where questionId=:questionId";
			$result=$pdo->getQueryResult($sql,$paraArr);
			return $result;
		}
	}
?>