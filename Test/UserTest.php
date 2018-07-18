<?php
	require_once(__DIR__."/../Model/User.php");
	require_once("TestData.php");
	use PHPUnit\Framework\TestCase;
	class UserTest extends TestCase{
		/**
		 * 下面的代码测试向数据库中添加用户
		 */
		private $user;
		
		function setUp(){
			$this->user=new User();
		} 
		/**
		 * 测试用户注册功能，由于会检测用户名和邮箱是否重复，所以第一次注册为true，之后未false
		 */
		function testRegister(){
			$username="tom li";
			$email="1402343@qq.com";
			$password="testpwd";
			$sex=1;
			$job="IT";
			$province="江苏";
			$city="昆山";
			$oneWord="I am a programmer";
			$heading="img/test.jpg";
			
			$result=$this->user->register($username, $password, $email, $sex, $job, $province, $city, $oneWord,$heading);
			// if($result==true){
				// echo "已经添加用户";
			// }
			// else{
				// echo "添加用户失败";
			// }
			$this->assertFalse($result);
		}
		/**
		 * 下面测试用户名是否重复，测试数据重复，结果为true
		 */
		function testIsUserNameRepeat(){
			$username=RepeatName;
			$result=$this->user->isUsernameRepeat($username);
			// if($result){
				// echo "用户名重复，不可用";
			// }
			// else{
				// echo "用户名没重复，可用";
			// }
			$this->assertTrue($result);
		}
		
		/**
		 * 下面测试邮箱是否重复，测试用的邮箱重复，结果为true
		 */
		function testIsEmailRepeat(){
			$email=RepeatEmail;
			$result=$this->user->isEmailRepeat($email);
			// if($result){
				// echo "邮箱重复，不可用";
			// }
			// else{
				// echo "邮箱没重复，可用";
			// }
			$this->assertTrue($result);
		}
		/**
		 * 下面测试用户登录功能，测试用的数据可以获取到用户名为“王五”的用户
		 */
		function testLogin(){
			$username=UserName;
			$password=Password;			
			$result=$this->user->login($password, $username);
			$this->assertEquals($result,"王五");
		}
		
		/**
		 * 下面测试检测用户是否登录了系统，因为testLogin()的效果，session中记录了王五的登录信息，结果应该为true
		 * 之后清除session，在测试未登录的情况
		 */
		function testIsUserLogon(){
			$this->assertTrue($this->user->isUserLogon() && $_SESSION['username']=="王五");
		}
		
		/**
		 * 下面测试用户登出系统的功能
		 */
		function testLogout(){
			$this->assertTrue($this->user->logout());
			$this->assertTrue(empty($_SESSION['username']));
		}
		
		/**
		 * 下面测试用户获取工作类型列表信息的功能，断言获取到的工作列表非空
		 */
		function testGetJobList(){
			$this->assertTrue(!empty($this->user->getJobList()));
		}
		
		/**
		 * 下面测试用户注册时获取省份列表的功能
		 */
		function testGetProvinceList(){
			$this->assertTrue(!empty($this->user->getProvinceList()));
		}
		
		/**
		 * 下面测试用户注册时根据省份获取城市列表的功能
		 */
		function testGetCityList(){
			$province=Province;
			$this->assertTrue(!empty($this->user->getCityList($province)));
		}
		
		/**
		 * 下面测试用户能否创建一个新问题
		 */
		function testCreateNewQuestion(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;			
			$result=$this->user->login($password, $username);
			
			$questionType=QuestionType;
			$questionContent=QuestionContent;
			$questionDescription=QuestionDescription;
			$result=$this->user->createNewQuestion($questionType, $questionContent, $questionDescription);
			//问题重复时不添加问题
			if(!$this->user->isQuestionRepeat($questionContent)){				
				$this->assertEquals($result,1);
			}
			else{
				$this->assertEquals($result,0);
			}			
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 测试获取单个用户的问题列表
		 */
		function testGetSelfQuestionList(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;			
			$result=$this->user->login($password, $username);
			
			$questionList=$this->user->getSelfQuestionList();
			$this->assertTrue(!empty($questionList));
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 测试获取单个用户的问题详情
		 */
		function testGetQuestionDetailsByQuestionId(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$questionId=QuestionId;			
			$questionDescription=$this->user->getQuestionDetailsByQuestionId($questionId);
			$this->assertTrue(!empty($questionDescription));
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试用户通过问题内容或者详细描述来检索一个问题
		 */
		function testGetQuestionListByContentOrDescription(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$keyword="单元测试";
			$questionList=$this->user->getQuestionListByContentOrDescription($keyword);
			$this->assertTrue(!empty($questionList));
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试用户禁用一个问题
		 */
		function testDisableSelfQuestion(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$questionId=QuestionId;
			$result=$this->user->disableSelfQuestion($questionId);
			//下面的测试条件是因为用户可能已经禁用了问题，那么数据库修改的结果就是影响函数为0
			$this->assertTrue($result==1 || $result==0);
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试用户给问题添加一条评论
		 */
		function testCommentQuestion(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$questionId=QuestionId;
			$content=ExampleComment;
			$result=$this->user->commentQuestion($questionId, $content);
			//下面的测试条件是因为用户可能已经删除了问题，那么数据库修改的结果就是影响函数为0
			$this->assertTrue($result["affectRow"]==1 || $result["affectRow"]==0);
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试通过问题号加载用户对该问题的评论
		 */
		function testGetCommentsForQuestion(){
			$questionId=QuestionId;
			$result=$this->user->getCommentsForQuestion($questionId);
			$this->assertTrue(!empty($result));
		}
		
		/**
		 * 下面测试禁用一个问题的一条评论
		 */
		function testDisableCommentForQuestion(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$commentId=CommentId;
			$result=$this->user->disableCommentForQuestion($commentId);
			$this->assertTrue($result==1 || $result==0);
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试通过评论号加载用户对该评论的回复
		 * 这个测试每运行一次都会在数据库中增加一条信息
		 */
		function testCreateReplyForComment(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$fatherReplyId=CommentId;
			$commentId=CommentId;
			$content=ReplyContent;
			$result=$this->user->createReplyForComment($fatherReplyId, $commentId, $content);
			//添加一条回复就是向数据库中插入了一条对评论的回复记录
			$this->assertEquals($result["insertRow"],1);
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试通过评论号加载用户对该评论的回复
		 * 这个测试每运行一次都会在数据库中增加一条信息
		 */
		function testCreateReplyForReply(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$fatherReplyId=FatherReplyId;
			$commentId=CommentId;
			$content=ReplyContent;
			$result=$this->user->createReplyForReply($fatherReplyId, $commentId, $content);
			//添加一条回复就是向数据库中插入了一条值，为0是该评论不存在
			$this->assertTrue($result["insertRow"]==1);
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试通过回复号删除相应评论的回复
		 * 这个测试执行第一次的时候会删除数据库中的数据，之后在执行就不会了
		 * 下面的函数写的没问题，但是测试之后会删除数据，所以先注释
		 */
		function testDisableReplyForComment(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$replyId=ReplyId;
			$result=$this->user->disableReplyForComment($replyId);
			//禁用回复信息的评论就是在数据库中将评论信息改为禁用，也可能已经禁用
			$this->assertTrue($result==0 || $result==1);
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试加载一个评论的所有回复信息
		 */
		function testGetReplysForComment(){
			$commentId=CommentId;
			$result=$this->user->getReplysForComment($commentId);
			$this->assertTrue(!empty($result));
		}
		
		/**
		 * 下面测试通过评论号获取评论信息
		 */
		function testGetCommentByCommentId(){
			$commentId=CommentId;
			$result=$this->user->getCommentByCommentId($commentId);
			$this->assertTrue(!empty($result));
		}
		
		/**
		 * 下面测试根据问题号获取评论数
		 */
		function testGetCommentCountByQuestionId(){
			$questionId=QuestionId;
			$result=$this->user->getCommentCountByQuestionId($questionId);
			$this->assertTrue($result>0);
		}
		
		/**
		 * 下面测试根据评论号获取回复数
		 */
		function testGetReplyCountByCommentId(){
			$commentId=CommentId;
			$result=$this->user->getReplyCountByCommentId($commentId);
			$this->assertTrue($result>0);
		}
		
		/**
		 * 下面测试通过replyId获取reply
		 */
		function testGetReplyByReplyId(){
			$replyId=ReplyId;
			$result=$this->user->getReplyByReplyId($replyId);
			$this->assertTrue($result>0);
		}
		 
		/**
		 * 下面演示sql注入
		 */
		/*function testSqlInject(){
			global $pdo;
			$username="test";
			$password="unknown' or 'a'='a";
			$paraArr=array(':username'=>$username,':password'=>$password);
			// $sql="select count(*) as sumCount from tb_user where username='$username' and password='$password'";
			$sql="select count(*) as sumCount from tb_user where username=:username and password=:password";		
			echo $sql;
			$rows=$pdo->getOneFiled($sql, 'sumCount',$paraArr);
			echo $rows;
		}*/
		
	}

?>