<?php
	class MysqlPdo{
		private $pdo=null;
		/**
		 * 在构造函数中初始化pdo
		 */
		function __construct(){
			$this->initPdo();
		}
		
		function initPdo(){
			try{
				$this->pdo=new PDO('mysql:dbname=db_ghost;host=localhost','root','root');
			}
			catch(Exception $e){
				echo "<p>An Error occured:".$e->getMessage()."</p>";
			}
		}
		/**
		 * 这里获取查询结果的函数中传入了sql语句和作为参数的数组，这样有利于
		 * 进行参数化查询，防止sql注入攻击，参数默认为空，因为有些语句直接执行，
		 * 不需要参数
		 * 这个函数执行查询操作，并且返回结果集
		 */
		function getQueryResult($sql,$paraArr=null){
			if($this->pdo==null){
				$this->initPdo();
			}
			$stmt=$this->pdo->prepare($sql);
			$stmt->execute($paraArr);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		/**
		 * 为分页查询提供专用函数，因为limit后面的参数只能通过bindParam方式传递
		 * 但是引出一个明显问题，不能给sql语句传送灵活的数组参数了
		 */
		function getQueryResultForPager($sql,$startRow=1){
			if($this->pdo==null){
				$this->initPdo();
			}
			$stmt=$this->pdo->prepare($sql);
			$stmt->bindParam(":startRow",$startRow,PDO::PARAM_INT);
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		/**
		 * 这个方法和上面基本一样，但是他会返回一个对象
		 */
		function getQueryResultToClass($sql,$className,$paraArr=null){
			if($this->pdo==null){
				$this->initPdo();
			}
			$stmt=$this->pdo->prepare($sql);
			$stmt->execute($paraArr);
			$result=$stmt->fetchAll(PDO::FETCH_CLASS,$className);
			return $result;
		}
		/**
		 * 这个函数执行Update，Insert，Delete操作，并且返回影响到的行数
		 */
		function getUIDResult($sql,$paraArr=null){
			if($this->pdo==null){
				$this->initPdo();
			}
			$stmt=$this->pdo->prepare($sql);
			$stmt->execute($paraArr);
			$affectRows=$stmt->rowCount();
			return $affectRows;
		}
		/**
		 * 下面的函数获取某个具体的字段值，当仅仅只需要获取某一个字段值的时候用起来比较方便
		 * 其实是在getQueryResult得到的结果集的内容中提取到的一个字段值
		 */
		function getOneFiled($sql,$field,$paraArr=null){
			$queryResult=$this->getQueryResult($sql,$paraArr);
			if(count($queryResult)!=0){
				$field=$queryResult[0][$field];
				return $field;
			}
			else{
				return '';
			}
		}
		/**
		 * 这个函数注销pdo，并将pdo置为null
		 */
		function closePdo(){
			unset($this->pdo);
			$this->pdo=null;
		}
	}

	$pdo=new MysqlPdo();
?>