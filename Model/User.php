<?php
	require_once(__DIR__.'/../classes/MysqlPdo.php');
	require_once(__DIR__.'/../classes/SessionDBC.php');
	class User{
		// 下面的属性在程序中都用不到，我先注释起来
		// private $id;
		// private $username;
		// private $password;
		// private $email;
		// private $sex;
		// private $job;
		// private $province;
		// private $city;
		// private $oneWord;
		// private $heading;
				
		/**
		 * 下面的注册方法是填写完整信息之后进行注册
		 * 成功注册信息时，返回true，否则返回false
		 */
		function register($username,$password,$email,$sex,$job,$province,$city,$oneWord,$heading=null){
			if($this->chkRegisterInfo($username, $password, $email)){
				global $pdo;
				if(!$this->isUsernameRepeat($username) && !$this->isEmailRepeat($email)){
					$password=md5($password);
					$userId=uniqid('',true);
					$paraArr=array(':userId'=>$userId,':username'=>$username,':password'=>$password,':email'=>$email,
						':sex'=>$sex,':job'=>$job,':province'=>$province,':city'=>$city,':oneWord'=>$oneWord,':heading'=>$heading,':enable'=>"1");
					$sql="insert into tb_user values(:userId,:username,:password,:email,:sex,:job,:province,:city,:oneWord,:heading,:enable)";
					//$sql="insert into tb_user values(null,'$username','$password','$email',$sex,'$province','$job','$city','$oneWord','$heading')";
					//echo $sql;
					$result=$pdo->getUIDResult($sql,$paraArr);
					//$result=$pdo->getUIDResult($sql);
					if($result==1){
						return true;
					}
					else{
						return false;
					}
				}
				else{
					return false;
				}			
			}
			else{
				return false;
			}
			
		}
		/**
		 * 下面的函数用来检测用户填写的注册信息，在执行注册函数时，应该先检测用户传给服务器的信息是否合法
		 */
		private function chkRegisterInfo($username,$password,$email){
			$isUsernameOk=false;
			$isPasswordOk=false;
			$isEmailOk=false;
			
			if(!empty($username) && strlen($username)>=2 && strlen($username)<=8){
				$isUsernameOk=true;
			}
			if(!empty($password) && strlen($password)>=6 && strlen($password)<=18){
				$isPasswordOk=true;
			}
			if(!empty($email) && filter_var($email,FILTER_VALIDATE_EMAIL)){
				$isEmailOk=true;
			}
			$isAllOk=$isUsernameOk && $isPasswordOk && $isEmailOk;
			return $isAllOk;
		}
		/**
		 * 用户在注册时检测用户名是否重复
		 */
		function isUsernameRepeat($username){
			global $pdo;
			$paraArr=array(":username"=>$username);
			$sql="select count(*) as userCount from tb_user where username=:username";
			$result=$pdo->getOneFiled($sql, "userCount",$paraArr);
			if($result==0){
				return false;
			}
			else{
				return true;
			}
		}
		/**
		 * 用于在注册时检测邮箱是否重复
		 */
		function isEmailRepeat($email){
			global $pdo;
			$paraArr=array(":email"=>$email);
			$sql="select count(*) as emailCount from tb_user where email=:email";
			$result=$pdo->getOneFiled($sql, "emailCount",$paraArr);
			if($result==0){
				return false;
			}
			else{
				return true;
			}
		}
		
		/**
		 * 下面的函数实现用户登录功能，用户登录只需要输入邮箱或者用户名，之后输入密码就可以了
		 */
		function login($password,$emailOrUsername){
			if($this->chkLoginInfo($password,$emailOrUsername)){
				$password=md5($password);
				global $pdo;
				$paraArr=array(":password"=>$password,":emailOrUsername"=>$emailOrUsername);
				$sql="select username from tb_user where password=:password and (email=:emailOrUsername or username=:emailOrUsername) and enable=1;";
				$result=$pdo->getOneFiled($sql, 'username',$paraArr);
				if(!empty($result)){
					$_SESSION['username']=$result;
					session_write_close();//执行这个函数，php会马上执行session的“写入”和“关闭”函数
				}				
				return $result;
			}
			else{
				return null;
			}
			
		}
		/**
		 * 下面的函数检测用户的登录信息是否合法，虽然已经在js里面进行过校验，但是
		 * 不能阻止黑客不通过浏览器向服务器发起请求
		 */
		private function chkLoginInfo($password,$emailOrUsername){
			$isPwdOk=false;
			$isEmailOrUsernameOk=false;
			if(is_string($emailOrUsername) && !empty($emailOrUsername)){
				$isEmailOrUsernameOk=true;
			}
			if(is_string($password) && !empty($password)){
				$isPwdOk=true;
			}
			
			$isAllOk=$isEmailOrUsernameOk && $isPwdOk;
			return $isAllOk;
		}
		
		/**
		 * 下面定义一个函数用来让用户创建一个新的问题
		 */
		function createNewQuestion($questionType,$questionContent,$questionDescription){
			global $pdo;
			if($this->isUserLogon() && !$this->isQuestionRepeat($questionContent)){
				$questionId=uniqid("",true);
				$asker=$_SESSION['username'];
				$askerDate=date("Y-m-d H:i:s");
				$paraArr=array(":questionId"=>$questionId,":asker"=>$asker,":askDate"=>$askerDate,":questionType"=>$questionType,
					":questionContent"=>$questionContent,":questionDescription"=>$questionDescription,":enable"=>"1");
				$sql="insert into tb_question values(:questionId,:asker,:askDate,:questionType,:questionContent,:questionDescription,:enable)";
				$result=$pdo->getUIDResult($sql,$paraArr);
				return $result;
			}
			else{
				return false;
			}
		}
		
		/**
		 * 下面定义的函数检测用户要添加的问题是否重复
		 */
		function isQuestionRepeat($questionContent){
			global $pdo;
			$paraArr=array(":questionContent"=>$questionContent);
			$sql="select count(*) as questionCount from tb_question where content=:questionContent and enable=1";
			$count=$pdo->getOneFiled($sql, "questionCount",$paraArr);
			$result=$count>0?true:false;
			return $result;
		}
		
		/**
		 * 下面定义函数检测用户是否登录，基于session
		 * 原本打算定义单独的类对用户登录状态进行检测，但是后来发现定义在
		 * User类中更符合逻辑，而且在执行只有登录状态下才能执行的函数时
		 * 直接调用User类中的函数进行检测，更加安全
		 */		 
		function isUserLogon(){
			if(!empty($_SESSION['username'])){
				return true;
			}
			else{
				return false;
			}
		}
		
		/**
		 * 下面的函数测试用户的登出功能
		 */
		function logout(){					
			if(!empty($_SESSION['username'])){
				@session_start();//这里使用@是因为在session_start()函数前面如果有其他输出，就会报警告
				session_destroy();
				return true;
			}
			else{
				return false;
			}
		}
		
		/**
		 * 下面是用户注册时获取工作列表的功能
		 */
		function getJobList(){
			$jobOptions = '';
			$jobPdo = new MysqlPdo();
			$sql="select job from tb_job";
			$jobLists = $jobPdo->getQueryResult($sql);
			return $jobLists;
		}
		/**
		 * 下面是用户注册时获取省份列表的功能
		 */
		function getProvinceList(){
			$provinceOptions = '';
			$provincePdo = new MysqlPdo();
			$sql="select province from tb_province";
			$provinceLists = $provincePdo->getQueryResult($sql);
			return $provinceLists;
		}
		/**
		 * 下面是用户注册时根据省份获取城市的功能
		 */
		function getCityList($province){
			global $pdo;
			$paraArr = array(":province"=>$province);
			$sql="select city from tb_city where provinceId in(select provinceId from tb_province where province = :province)";			
			$cityLists = $pdo->getQueryResult($sql,$paraArr);
			return $cityLists;
		}
		/**
		 * 获取登录后的用户名
		 */
		function getLogonUsername(){
			if(!empty($_SESSION['username'])){
				return $_SESSION['username'];
			}
			else{
				return "未登录";
			}
		}
		
		/**
		 * 获取用户提出的问题的问题列表
		 */
		function getSelfQuestionList(){
			if($this->isUserLogon()){
				global $pdo;
				$paraArr=array(":asker"=>$_SESSION['username']);
				$sql="select questionId,asker,askDate,questionType,content from tb_question where asker=:asker";
				$questionList=$pdo->getQueryResult($sql,$paraArr);
				return $questionList;
			}
			else{
				return null;
			}
		}
		
		/**
		 * 下面通过问题的Id获取到问题的详情
		 */
		function getQuestionDetailsByQuestionId($questionId){
			if($this->isUserLogon()){
				global $pdo;				
				$paraArr=array(":questionId"=>$questionId);
				$sql="select * from tb_question where questionId=:questionId";
				$questionDetails=$pdo->getQueryResult($sql,$paraArr);
				return $questionDetails;
			}
			else{
				return null;
			}
		}
		
		/**
		 * 下面通过搜索问题内容或者描述中的关键字来检索相应的问题（针对单个用户）
		 */
		function getQuestionListByContentOrDescription($keyword){
			if($this->isUserLogon()){
				global $pdo;
				$username=$_SESSION['username'];
				$keyword="%".$keyword."%";//使用模糊查询，前后要加百分号
				$paraArr=array(":keyword"=>$keyword,":asker"=>$username);
				$sql="select * from tb_question where asker=:asker and (content like :keyword or questionDescription like :keyword) and enable=1";
				$questionList=$pdo->getQueryResult($sql,$paraArr);
				return $questionList;
			}
			else{
				return null;
			}
		}
		
		/**
		 * 下面的函数用来删除用户个人的问题
		 */
		function disableSelfQuestion($questionId){
			if($this->isUserLogon()){
				global $pdo;
				$paraArr=array(":questionId"=>$questionId);
				$sql="update tb_question set enable=0 where questionId=:questionId";
				$result=$pdo->getUIDResult($sql,$paraArr);
				return $result;
			}
			else{
				return null;
			}
		}
		
		/**
		 * 下面的函数用来让用户评论一个问题
		 */
		function commentQuestion($questionId,$content){
			if($this->isUserLogon()){
				global $pdo;
				//向数据库中增加评论信息
				$commenter=$_SESSION['username'];
				$commentId=uniqid("",true);
				$commentDate=date("Y-m-d H:i:s");
				$paraArr=array(":commentId"=>$commentId,":questionId"=>$questionId,
					":commenter"=>$commenter,":commentDate"=>$commentDate,":content"=>$content,":enable"=>"1");
				$sql="insert into tb_comment values(:commentId,:questionId,:commenter,:commentDate,:content,:enable)";
				$affectRow=$pdo->getUIDResult($sql,$paraArr);
				
				$comment=$this->getCommentByCommentId($commentId);
				
				$resultArr=array("affectRow"=>$affectRow,"createdComment"=>$comment);				
				
				return $resultArr;
			}
			else{
				return null;
			}
		}
		
		/**
		 * 下面的函数通过commentId来获取相应的comment，以便于用户在提交一个评论之后
		 * 可以不刷新页面就看到新的评论信息，因为commentId是在服务器端产生的，所以
		 * 光凭借前端的信息不足以用jquery动态添加元素
		 */
		function getCommentByCommentId($commentId){
			global $pdo;
			$paraArr=array(":commentId"=>$commentId);
			$sql="select * from tb_comment where commentId=:commentId";
			$result=$pdo->getQueryResult($sql,$paraArr);
			return $result;
		}
		
		
		/**
		 * 下面的函数通过问题号加载相应的评论
		 */
		function getCommentsForQuestion($questionId){
			global $pdo;
			$logonUser=$_SESSION['username']??"";
			$paraArr=array(":logonUser"=>$logonUser,":questionId"=>$questionId);
			//$sql="select * from tb_comment where questionId=:questionId";
			//$sql="select case when commenter=:logonUser then 'true' else 'false' end as isCommenter,commentId,";
			//$sql.="questionId,commenter,commentDate,content from tb_comment where questionId=:questionId;";
			//由于逻辑变得有点复杂（需要判断是否为当前登录者，需要获取该评论的回复数，所以改为使用存储过程
			$sql="call pro_getComments(:logonUser,:questionId)";
			$result=$pdo->getQueryResult($sql,$paraArr);
			return $result;
		}
		
		/**
		 * 下面的函数根据评论号删除一个评论
		 */
		function disableCommentForQuestion($commentId){
			if($this->isUserLogon()){
				global $pdo;
				$commenter=$_SESSION['username'];
				$paraArr=array(":commentId"=>$commentId,":commenter"=>$commenter);
				$sql="update tb_comment set enable=0 where commentId=:commentId and commenter=:commenter";
				$result=$pdo->getUIDResult($sql,$paraArr);
				return $result;
			}
			else{
				return null;
			}
		}
		
		/**
		 * 下面的函数给评论添加相应的回复
		 */
		function createReplyForComment($fatherReplyId,$commentId,$content){
			if($this->isUserLogon()){
				//向数据库中插入新的回复信息
				global $pdo;
				$replyer=$_SESSION['username'];
				$replyId=uniqid("",true);
				$replyDate=date("Y-m-d H:i:s");
				$paraArr=array(":replyId"=>$replyId,":fatherReplyId"=>$fatherReplyId,":commentId"=>$commentId,
					":replyer"=>$replyer,":replyDate"=>$replyDate,":content"=>$content,":enable"=>"1");
				$sql="insert into tb_reply values(:replyId,:fatherReplyId,:commentId,:replyer,:replyDate,:content,:enable)";

				$insertRow=$pdo->getUIDResult($sql,$paraArr);
				//获取刚插入的回复信息
				$replyContent=$this->getReplyByReplyId($replyId);
				$resultArr=array("insertRow"=>$insertRow,"replyContent"=>$replyContent);
				return $resultArr;
			}
			else{
				return null;
			}
		}
		
		
		/**
		 * 下面的函数给评论回复添加相应的回复
		 */
		function createReplyForReply($fatherReplyId,$commentId,$content){
			if($this->isUserLogon()){
				//向数据库中插入新的回复信息
				global $pdo;
				$replyer=$_SESSION['username'];
				$replyId=uniqid("",true);
				$replyDate=date("Y-m-d H:i:s");
				$paraArr=array(":replyId"=>$replyId,":fatherReplyId"=>$fatherReplyId,":commentId"=>$commentId,
					":replyer"=>$replyer,":replyDate"=>$replyDate,":content"=>$content,":enable"=>"1");
				$sql="insert into tb_reply values(:replyId,:fatherReplyId,:commentId,:replyer,:replyDate,:content,:enable)";
				$insertRow=$pdo->getUIDResult($sql,$paraArr);
				//获取刚插入的回复信息
				$replyContent=$this->getReplyByReplyId($replyId);
				$resultArr=array("insertRow"=>$insertRow,"replyContent"=>$replyContent);
				return $resultArr;
			}
			else{
				return null;
			}
		}
		
		
		/**
		 * 下面的函数给评论删除相应的回复
		 */
		function disableReplyForComment($replyId){
			if($this->isUserLogon()){
				global $pdo;
				$replyer=$_SESSION['username'];
				$paraArr=array(":replyId"=>$replyId,":replyer"=>$replyer);
				$sql="update tb_reply set enable=0 where replyId=:replyId and replyer=:replyer";
				$result=$pdo->getUIDResult($sql,$paraArr);
				return $result;
			}
			else{
				return null;
			}
		}
		
		/**
		 * 下面的函数给回复删除相应的回复
		 */
		function disableReplyForReply($replyId){
			if($this->isUserLogon()){
				global $pdo;
				$replyer=$_SESSION['username'];
				$paraArr=array(":replyId"=>$replyId,":replyer"=>$replyer);
				$sql="update tb_reply set enable=0 where replyId=:replyId and replyer=:replyer";
				$result=$pdo->getUIDResult($sql,$paraArr);
				return $result;
			}
			else{
				return null;
			}
		}
		
		/**
		 * 下面的函数给一个评论加载相应的回复信息
		 */
		function getReplysForComment($commentId){
			global $pdo;
			$paraArr=array(":commentId"=>$commentId);
			//下面的sql语句已经对应比较复杂的逻辑了，可以考虑使用mysql的函数或者存储过程来完成
			//主要作用1.获得当前reply对应的父reply的replyer 2.判断reply表中的replyer是否为当前登录者
			//作用1是为了在前台显示谁回复了谁的信息，作用2是为了在前台决定是否显示删除按钮
			$sql="call pro_getReplys(:commentId)";
			$result=$pdo->getQueryResult($sql,$paraArr);
			return $result;
		}
		
		/**
		 * 下面的函数获取单个问题的评论数
		 */
		function getCommentCountByQuestionId($questionId){
			global $pdo;
			$paraArr=array(":questionId"=>$questionId);
			$sql="select count(commentId) as commentCount from tb_comment where questionId=:questionId and enable=1";
			$commentCount=$pdo->getOneFiled($sql, "commentCount",$paraArr);
			return $commentCount;
		}
		
		/**
		 * 下面的函数获取单个评论的回复数
		 */
		function getReplyCountByCommentId($commentId){
			global $pdo;
			$paraArr=array(":commentId"=>$commentId);
			$sql="select count(replyId) as replyCount from tb_reply where commentId=:commentId and enable=1";
			$replyCount=$pdo->getOneFiled($sql, "replyCount",$paraArr);
			return $replyCount;
		}
		
		/**
		 * 下面的函数通过replyId获取reply
		 * 主要是为了方便用户在回复完信息之后可以加载出新的信息
		 */
		function getReplyByReplyId($replyId){
			global $pdo;
			$paraArr=array(":replyId"=>$replyId);
			$sql="call pro_getReplyByReplyId(:replyId)";
			$result=$pdo->getQueryResult($sql,$paraArr);
			return $result;
		}
		
	}
?>
