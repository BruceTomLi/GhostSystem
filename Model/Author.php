<?php
	require_once(__DIR__."/User.php");
	require_once(__DIR__."/../classes/MysqlPdo.php");
	
	/**
	 * 这个“作者”类主要用来写一些文章，作者可以对自己的文章进行管理
	 */
	class Author extends User{
		/**
		 * 作者写好并保存一篇文章
		 * 文章的内容较多，将前台的参数存放在一个文章数组中进行传递
		 * 开发进行到这里时，我发现还是先开发用户角色管理和授权的管理比较合理，
		 * 因为作者只是少数人拥有的角色，而且他的功能较多，在执行操作的时候应该先判断一下
		 * 用户的登录状态和用户角色
		 */
		function writeArticle($infoArray){
			if($this->isUserLogon()){
				global $pdo;
				$articleId=uniqid("",true);
				$author=$_SESSION['username'];
				$paraArr=array(":articleId"=>$articleId,":title"=>$infoArray['title'],":author"=>$infoArray['author'],
					":publishDate"=>$infoArray['publishDate'],":publisher"=>$infoArray['publisher'],
					":size"=>$infoArray['size'],":label"=>$infoArray['label'],":content"=>$infoArray['content'],
					":isPublic"=>$infoArray['isPublic'],":enable"=>"1");
				$sql="insert into tb_article values(:articleId,:title,:author,:publishDate,:publisher,:size,:label,:content,:isPublic,:enable";
				$affectRow=$pdo->getUIDResult($sql,$paraArr);
				return $affectRow;
			}
			else{
				return "未登录系统，不能写文章";
			}
			
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