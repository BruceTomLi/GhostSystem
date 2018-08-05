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
			$sql="select * from tb_question where enable=1 order by askDate desc";
			$result=$pdo->getQueryResult($sql);
			return $result;
		}
		
		/**
		 * 获取某个问题的详细信息
		 * 是给未登录用户设置的方法，不需要检测登录
		 */
		function getQuestionDetails($questionId){
			global $pdo;
			$paraArr=array(":questionId"=>$questionId);			
			$sql="select * from tb_question where questionId=:questionId";
			$result=$pdo->getQueryResult($sql,$paraArr);
			return $result;
		}
		
		/**
		 * 获取所有的问题，给管理员设置的，用于管理所有用户的问题，所以enable为1或者0都要显示
		 */
		function getAllQuestionListForManager(){
			if($this->isUserLogon()){
				global $pdo;
				$sql="select (select username from tb_user where userId=tq.askerId) as askerName,tq.* from tb_question tq order by askDate desc";
				$questions=$pdo->getQueryResult($sql);
				return $questions;
			}
			else{
				return "未登录系统，不能进行该操作";
			}
		}
		
		/**
		 * 通过关键字检索问题
		 */
		function queryQuestionsByKeyword($keyword,$page=1){
			if($this->isUserLogon()){
				global $pdo;
				//获取分页数据
				$count=$this->queryQuestionsByKeywordCount($keyword);
				$pageTotal=ceil($count/5);//获取总页数
				//规范化页数，并返回起始页
				$startRow=$this->getStartPage($page,$pageTotal);
				
				$keyword="%".$keyword."%";//使用模糊查询，前后要加百分号
				$paraArr=array(":keyword"=>$keyword);
				$sql="select (select username from tb_user where userId=tq.askerId) as asker,tq.* from tb_question tq where  ";
				$sql.="(content like :keyword or questionDescription like :keyword) limit $startRow,5";
				$questionList=$pdo->getQueryResult($sql,$paraArr);
				return $questionList;
			}
			else{
				return "未登录系统，不能进行该操作";
			}
		}
		
		/**
		 * 获取检索的记录数
		 */
		function queryQuestionsByKeywordCount($keyword){
			if($this->isUserLogon()){
				global $pdo;				
				$keyword="%".$keyword."%";//使用模糊查询，前后要加百分号
				$paraArr=array(":keyword"=>$keyword);
				$sql="select count(*) as questionCount from tb_question tq where  ";
				$sql.="(content like :keyword or questionDescription like :keyword)";
				$count=$pdo->getOneFiled($sql, "questionCount",$paraArr);
				return $count;
			}
			else{
				return "未登录系统，不能进行该操作";
			}
		}
				
	}
?>