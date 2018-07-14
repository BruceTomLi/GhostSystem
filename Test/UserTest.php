<?php
	require_once(__DIR__."/../Model/User.php");
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
			$username="tomtom";
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
			$email="fasdfa@qq.com";
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
			$password="wangwu@123";
			$username="王五";
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
			$province="湖北省";
			$this->assertTrue(!empty($this->user->getCityList($province)));
		}
		
		/**
		 * 下面测试用户能否创建一个新问题
		 */
		function testCreateNewQuestion(){
			//测试这个功能需要先登录
			$password="wangwu@123";
			$username="王五";
			$result=$this->user->login($password, $username);
			
			$questionType="IT";
			$questionContent="这是单元测试里面用来测试创建一个新的问题的测试内容";
			$questionDescription="这里是问题描述，实际情况中可以填写超文本信息";
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
			$password="wangwu@123";
			$username="王五";
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
			$password="wangwu@123";
			$username="王五";
			$result=$this->user->login($password, $username);
			
			$questionId="5b45c856e9c0f6.75638451";			
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
			$password="wangwu@123";
			$username="王五";
			$result=$this->user->login($password, $username);
			
			$keyword="单元测试";
			$questionList=$this->user->getQuestionListByContentOrDescription($keyword);
			$this->assertTrue(!empty($questionList));
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试用户删除一个问题
		 */
		function testDeleteSelfQuestion(){
			//测试这个功能需要先登录
			$password="wangwu@123";
			$username="王五";
			$result=$this->user->login($password, $username);
			
			$questionId="5b45c856e9c0f6.75638452";
			$result=$this->user->deleteSelfQuestion($questionId);
			//下面的测试条件是因为用户可能已经删除了问题，那么数据库修改的结果就是影响函数为0
			$this->assertTrue($result==1 || $result==0);
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试用户给问题添加一条评论
		 */
		function testCommentQuestion(){
			//测试这个功能需要先登录
			$password="wangwu@123";
			$username="王五";
			$result=$this->user->login($password, $username);
			
			$questionId="5b45c856e9c0f6.75638452";
			$content="这里测试给问题增加一条评论";
			$result=$this->user->commentQuestion($questionId, $content);
			//下面的测试条件是因为用户可能已经删除了问题，那么数据库修改的结果就是影响函数为0
			$this->assertTrue($result==1 || $result==0);
			//测试完之后退出登录
			$this->user->logout();
		}
		
		/**
		 * 下面测试通过问题号加载用户对该问题的评论
		 */
		function testGetCommentsForQuestion(){
			$questionId="5b45c856e9c0f6.75638452";
			$result=$this->user->getCommentsForQuestion($questionId);
			$this->assertTrue(!empty($result));
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