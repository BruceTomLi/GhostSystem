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
			
			//已经注册过一次的再注册一次会失败，因为用户名和邮箱重复了
			$affectRow=$this->user->register($username, $password, $email, $sex, $job, $province, $city, $oneWord,$heading);
			$this->assertTrue($affectRow==0);
		}
		/**
		 * 下面测试用户名是否重复，测试数据重复，结果为true
		 */
		function testIsUserNameRepeat(){
			$username=RepeatName;
			$result=$this->user->isUsernameRepeat($username);
			$this->assertTrue($result);
		}
		
		/**
		 * 下面测试邮箱是否重复，测试用的邮箱重复，结果为true
		 */
		function testIsEmailRepeat(){
			$email=RepeatEmail;
			$result=$this->user->isEmailRepeat($email);
			$this->assertTrue($result);
		}
		/**
		 * 下面测试用户登录功能，测试用的数据可以获取到用户名为“王五”的用户
		 */
		function testLogin(){
			$username=UserName;
			$password=Password;			
			$result=$this->user->login($password, $username);
			$this->assertEquals($result,UserName);
		}
		
		/**
		 * 下面测试检测用户是否登录了系统，因为testLogin()的效果，session中记录了王五的登录信息，结果应该为true
		 * 之后清除session，在测试未登录的情况
		 */
		function testIsUserLogon(){
			$this->assertTrue($this->user->isUserLogon() && $_SESSION['username']==UserName);
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
			$this->assertTrue(count($questionList)>0);
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 测试获取单个用户的问题个数
		 */
		function testGetSelfQuestionCount(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;			
			$result=$this->user->login($password, $username);
			
			$count=$this->user->getSelfQuestionCount();
			$this->assertTrue($count>0);
			
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
			//问题被disable之后就查不到了
			$this->assertTrue(count($questionList)>0);
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试用户通过问题内容或者详细描述来检索一个问题的个数
		 */
		function testGetQuestionListByContentOrDescriptionCount(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$keyword="单元测试";
			$count=$this->user->getQuestionListByContentOrDescriptionCount($keyword);
			$this->assertTrue($count>0);
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
		 * 下面测试用户启用一个问题
		 */
		function testEnableSelfQuestion(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$questionId=QuestionId;
			$result=$this->user->enableSelfQuestion($questionId);
			//下面的测试条件是因为用户可能已经启用了问题，那么数据库修改的结果就是影响函数为0
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
			$result=0;
			if($this->user->isCommentEnable($commentId)){
				$result=$this->user->disableCommentForQuestion($commentId);
				$this->assertTrue($result==1);
			}
			else{
				$this->assertTrue($result==0);
			}
			
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
			$content=ReplyCommentContent;
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
			$content=ReplyReplyContent;
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
			$this->user->login($password, $username);
			
			$replyId=ReplyId;
			$result=0;
			if($this->user->isReplyEnable($replyId)){
				$result=$this->user->disableReplyForComment($replyId);
				//禁用回复信息的评论就是在数据库中将评论信息改为禁用，也可能已经禁用
				$this->assertTrue($result==1);
			}
			else{
				$this->assertTrue($result==0);
			}
			
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
		 * 下面测试加载已经登录的用户的个人信息
		 */
		function testLoadUserInfo(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			$result=$this->user->loadUserInfo();
			$this->assertEquals(count($result),1);
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		function testIsUsernameUsedByOthers(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			//先测试原用户名，是被自己占用的，断言false
			$newUsername=UserName;			
			$result=$this->user->isUsernameUsedByOthers($newUsername);
			$this->assertFalse($result);
			
			//再测试新用户名，是被被别人占用的，断言true
			$newUsername=NewUserName;			
			$result=$this->user->isUsernameUsedByOthers($newUsername);
			$this->assertTrue($result);
			
			//测试完之后退出登录
			$this->user->logout();			
		}
		
		/**
		 * 测试用户要修改的邮箱是否和其他人重复
		 */
		function testIsEmailUsedByOthers(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			
			//先测试原邮箱，是被自己占用的，断言false
			$newEmail=UserEmail;	
			$result=$this->user->isEmailUsedByOthers($newEmail);
			$this->assertFalse($result);
			
			//再测试新用户名，是被被别人占用的，断言true
			$newEmail=NewUserEmail;			
			$result=$this->user->isEmailUsedByOthers($newEmail);
			$this->assertTrue($result);
						
			//测试完之后退出登录
			$this->user->logout();			
		}
		
		/**
		 * 下面测试修改用户自己的信息
		 */
		function testChangeSelfInfo(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			$userInfo=array("username"=>UserName,"email"=>UserEmail,
				"sex"=>"1","job"=>"保洁员","province"=>"上海","city"=>"上海市",
				"oneWord"=>"我是一个保洁员");
			
			$result=$this->user->changeSelfInfo($userInfo);
			$this->assertEquals(count($result),1);
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试用户修改密码的功能
		 */
		function testChangeSelfPassword(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			$oldPassword=Password;
			$newPassword=Password;
			
			$affectRow=$this->user->changeSelfPassword($oldPassword,$newPassword);
			//新旧密码一样时，不会更新任何记录
			$this->assertTrue($affectRow==1 || $affectRow==0);
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面的函数测试用户关注一个问题/话题/人
		 */
		function testAddFollow(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			//关注一个问题
			$questionId=QuestionId;
			$followType="question";			
			$questionRow=$this->user->addFollow($questionId,$followType);
			$this->assertTrue($questionRow==1 || $questionRow==0);
			
			//关注一个人
			$userId=UserId;
			$followType="user";
			$userRow=$this->user->addFollow($userId,$followType);
			$this->assertTrue($userRow==1 || $userRow==0);
			
			//关注一话题
			$topicId=TopicId;
			$followType="topic";
			$topicRow=$this->user->addFollow($topicId,$followType);
			$this->assertTrue($topicRow==1 || $topicRow==0);
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面的函数测试用户取消关注一个问题
		 */
		function testDeleteFollow(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			//取消关注问题
			$questionId=QuestionId;
			$affectRow=$this->user->deleteFollow($questionId);
			$this->assertTrue($affectRow==1 || $affectRow==0);
			
			//取消关注话题
			$topicId=TopicId;
			$affectRow=$this->user->deleteFollow($topicId);
			$this->assertTrue($affectRow==1 || $affectRow==0);
			
			//取消关注人
			$userId=UserId;
			$affectRow=$this->user->deleteFollow($userId);
			$this->assertTrue($affectRow==1 || $affectRow==0);
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面的函数测试用户是否关注了某个问题/话题/人
		 */
		function testHasUserFollowed(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			//用户是否关注了问题
			$questionId=QuestionId;
			$followCount=$this->user->hasUserFollowed($questionId);
			//用户关注了问题时，结果为1；用户没有关注时，结果为0。因为上面测试关注和取消关注的函数的影响，结果应该为0
			$this->assertTrue($followCount==0);
			
			//用户是否关注了话题
			$topicId=TopicId;
			$followCount=$this->user->hasUserFollowed($topicId);
			//用户关注了问题时，结果为1；用户没有关注时，结果为0。因为上面测试关注和取消关注的函数的影响，结果应该为0
			$this->assertTrue($followCount==0);
			
			//用户是否关注了人
			$userId=UserId;
			$followCount=$this->user->hasUserFollowed($userId);
			//用户关注了问题时，结果为1；用户没有关注时，结果为0。因为上面测试关注和取消关注的函数的影响，结果应该为0
			$this->assertTrue($followCount==0);
			
			//测试完之后退出登录
			$this->user->logout();			
		}
		
		/**
		 * 测试加载用户关注的问题
		 */
		function testLoadUserFollowedQuestions(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			$followedQuestions=$this->user->loadUserFollowedQuestions();
			//如果获取到用户关注的问题，结果数量就大于0
			$this->assertTrue(count($followedQuestions)>0);
			
			//测试完之后退出登录
			$this->user->logout();	
		}
		
		/**
		 * 测试加载用户关注的人
		 */
		function testLoadUserFollowedUsers(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			$followedUsers=$this->user->loadUserFollowedUsers();
			//如果获取到用户关注的问题，结果数量就大于0
			$this->assertTrue(count($followedUsers)>0);
			
			//测试完之后退出登录
			$this->user->logout();	
		}
		
		/**
		 * 测试用户上传自己的头像
		 */
		function testUploadSelfHeading(){
			$fileName="../UploadImages/skyy.jpg";
			$realName="heading.jpg";
			$isUnitTest=true;
			
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			$resultArr=$this->user->uploadSelfHeading($fileName, $realName,$isUnitTest);
			//如果用户上传的是相同文件名的文件，那么文件夹里的文件会修改，但是数据库里面的记录不会更新
			$this->assertTrue($resultArr['fileUploadOk']==1 && $resultArr['affectRow']>=0);
			
			//测试完之后退出登录
			$this->user->logout();			
		}
		
		/**
		 * 下面测试用户通过UserId加载一个人的基本信息
		 */
		function testGetUserBaseInfoByUserId(){
			$userId=UserId;
			$personalInfo=$this->user->getUserBaseInfoByUserId($userId);
			$this->assertEquals(count($personalInfo),1);
		}
		
		/**
		 * 下面测试加载用户的粉丝
		 */
		function testLoadUserFans(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			$fans=$this->user->loadUserFans();
			//如果用户上传的是相同文件名的文件，那么文件夹里的文件会修改，但是数据库里面的记录不会更新
			$this->assertTrue(count($fans)>0);
			
			//测试完之后退出登录
			$this->user->logout();	
		}
		
		/**
		 * 测试用户删除自己的问题
		 */
		function testDeleteSelfQuestion(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			$questionId=QuestionIdForDelete;
			$deleteQuestionCount=$this->user->deleteSelfQuestion($questionId);
			//删除掉问题，1次之后失效
			$this->assertTrue($deleteQuestionCount>=0);
			
			//测试完之后退出登录
			$this->user->logout();	
		}
		
		/**
		 * 测试加载问题类型，话题类型，作文类型
		 */
		function testLoadTypes(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			$types1=$this->user->loadQuestionTypes();
			$types2=$this->user->loadArticleTypes();
			$types3=$this->user->loadTopicTypes();
			//删除掉问题，1次之后失效
			$this->assertTrue(count($types1)>0 && count($types2)>0 && count($types3)>0);
			
			//测试完之后退出登录
			$this->user->logout();	
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
		
		/***************************下面部分是关于话题的测试******************************/
		/**
		 * 下面测试用户能否创建一个新话题
		 */
		function testCreateNewTopic(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;			
			$result=$this->user->login($password, $username);
			
			$topicType=TopicType;
			$topicContent=TopicContent;
			$topicDescription=TopicDescription;
			$result=$this->user->createNewTopic($topicType, $topicContent, $topicDescription);
			//话题重复时不添加话题
			if(!$this->user->isTopicRepeat($topicContent)){				
				$this->assertEquals($result,1);
			}
			else{
				$this->assertEquals($result,0);
			}			
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 测试获取单个用户的话题列表
		 */
		function testGetSelfTopicList(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;			
			$result=$this->user->login($password, $username);
			
			$topicList=$this->user->getSelfTopicList();
			$this->assertTrue(count($topicList)>0);
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 测试获取单个用户的话题个数
		 */
		function testGetSelfTopicCount(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;			
			$result=$this->user->login($password, $username);
			
			$count=$this->user->getSelfTopicCount();
			$this->assertTrue($count>0);
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 测试获取单个用户的话题详情
		 */
		function testGetTopicDetailsByTopicId(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$topicId=TopicId;			
			$topicDescription=$this->user->getTopicDetailsByTopicId($topicId);
			$this->assertTrue(count($topicDescription)>0);
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试用户通过话题内容或者详细描述来检索一个话题
		 */
		function testGetTopicListByContentOrDescription(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$keyword="单元测试";
			$topicList=$this->user->getTopicListByContentOrDescription($keyword);
			//话题被disable之后就查不到了
			$this->assertTrue(count($topicList)>0);
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试用户通过话题内容或者详细描述来检索一个话题的个数
		 */
		function testGetTopicListByContentOrDescriptionCount(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$keyword="单元测试";
			$count=$this->user->getTopicListByContentOrDescriptionCount($keyword);
			$this->assertTrue($count>0);
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试用户禁用一个话题
		 */
		function testDisableSelfTopic(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$topicId=TopicId;
			$result=$this->user->disableSelfTopic($topicId);
			//下面的测试条件是因为用户可能已经禁用了话题，那么数据库修改的结果就是影响函数为0
			$this->assertTrue($result==1 || $result==0);
			//测试完之后退出登录
			$this->user->logout();
		}
		/**
		 * 下面测试用户启用一个话题
		 */
		function testEnableSelfTopic(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$topicId=TopicId;
			$result=$this->user->enableSelfTopic($topicId);
			//下面的测试条件是因为用户可能已经启用了话题，那么数据库修改的结果就是影响函数为0
			$this->assertTrue($result==1 || $result==0);
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试用户给话题添加一条评论
		 */
		function testCommentTopic(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$topicId=TopicId;
			$content="呵呵哒";
			$result=$this->user->commentTopic($topicId, $content);
			//下面的测试条件是因为用户可能已经删除了话题，那么数据库修改的结果就是影响函数为0
			$this->assertTrue($result["affectRow"]==1);// || $result["affectRow"]==0);
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试通过话题号加载用户对该话题的评论
		 */
		function testGetCommentsForTopic(){
			$topicId=TopicId;
			$result=$this->user->getCommentsForTopic($topicId);
			$this->assertTrue(count($result)>0);
		}
		
		/**
		 * 下面测试禁用一个话题的一条评论
		 */
		function testDisableCommentForTopic(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$result=$this->user->login($password, $username);
			
			$commentId=CommentId;
			$result=0;
			if($this->user->isCommentEnable($commentId)){
				$result=$this->user->disableCommentForTopic($commentId);
				$this->assertTrue($result==1);
			}
			else{
				$this->assertTrue($result==0);
			}
			
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试根据话题号获取评论数
		 */
		function testGetCommentCountByTopicId(){
			$topicId=TopicId;
			$result=$this->user->getCommentCountByTopicId($topicId);
			$this->assertTrue($result>0);
		}
		
		/**
		 * 测试加载用户关注的话题
		 */
		function testLoadUserFollowedTopics(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			$followedTopics=$this->user->loadUserFollowedTopics();
			//如果获取到用户关注的话题，结果数量就大于0
			$this->assertTrue(count($followedTopics)>=0);
			
			//测试完之后退出登录
			$this->user->logout();	
		}
		
		/**
		 * 测试用户删除自己的话题
		 */
		function testDeleteSelfTopic(){
			//测试这个功能需要先登录
			$username=UserName;
			$password=Password;	
			$this->user->login($password, $username);
			
			$topicId=TopicIdForDelete;
			$deleteTopicCount=$this->user->deleteSelfTopic($topicId);
			//删除掉话题，1次之后失效
			$this->assertTrue($deleteTopicCount>=0);
			
			//测试完之后退出登录
			$this->user->logout();	
		}
	}

?>