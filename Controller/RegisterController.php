<?php
	require_once('../Model/User.php');
	require_once('../classes/MysqlPdo.php');

	class RegisterController{
		private $user;
		
		public function __construct(){
			$this->user=new User();
		}
		/**
		 * 执行注册操作，调用User类中的注册方法
		 */
		private function register(){
			$username=$_POST['username']??null;
			$password=$_POST['password']??null;
			$email=$_POST['email']??null;
			$sex=$_POST['sex']??null;
			$job=$_POST['job']??null;
			$province=$_POST['province']??null;
			$city=$_POST['city']??null;
			$oneWord=$_POST['oneWord']??null;
			$heading=$_POST['heading']??null;
			
			$result=$this->user->register($username, $password, $email, $sex, $job,$province, $city, $oneWord,$heading);
			if($result){
				return 1;
			}
			return 0;
		}
		/**
		 * 执行检测用户名是否重复操作，调用User类中的isUsernameRepeat方法
		 */
		private function chkUsername(){
			$username=$_GET['username']??null;
			$result=$this->user->isUsernameRepeat($username)==true?1:0;
			return $result;
		}
		/**
		 * 检测用户邮箱是否重复，调用User类中的isEmailRepeat方法
		 */
		private function chkEmail(){
			$email=$_GET['email']??null;
			$result=$this->user->isEmailRepeat($email)==true?1:0;
			return $result;
		}
		/**
		 * 加载职业列表
		 */
		// function getJobList(){
			// $jobOptions = '';
			// $jobPdo = new MysqlPdo();
			// $sql="select job from tb_job";
			// $jobLists = $jobPdo->getQueryResult($sql);
			// //print_r($jobList);
			// foreach ($jobLists  as $key => $value) {
				// foreach($value as $key2 => $value2) {
					// $jobOptions.= "<option value='$value2'>$value2</option>";
				// }
			// }
			// if($jobOptions){
				// return $jobOptions;
			// }
		// }
		
		private function getJobList(){
			$jobLists = $this->user->getJobList();
			//print_r($jobList);
			/*foreach ($jobLists  as $key => $value) {
				foreach($value as $key2 => $value2) {
					$jobOptions.= "<option value='$value2'>$value2</option>";
				}
			}*/
			//print_r($jobLists);
			//echo "<br>";
			$jobListsJson=json_encode($jobLists);
			//$jobListsJson=$jobLists;
			if(!empty($jobListsJson)){
				return $jobListsJson;
			}
			else{
				return '未获取到职业列表';
			}
		}
		/**
		 * 加载省份列表
		 */
		private function getProvinceList(){
			$provinceLists = $this->user->getProvinceList();
			/*foreach ($provinceLists  as $key => $value) {
				foreach($value as $key2 => $value2) {
					$provinceOptions.= "<option value='$value2'>$value2</option>";
				}
			}*/
			$provinceLists = json_encode($provinceLists);
			if(!empty($provinceLists)){
				return $provinceLists;
			}else {
				return '未获取到省份列表';
			}
		}
		/**
		 * 加载城市列表
		 */
		private function getCityList(){
			$province = $_GET['province'];
			//$province = "广东省";
			$cityLists=$this->user->getCityList($province);
			//print_r($cityLists);
			/*foreach ($cityLists  as $key => $value) {
				foreach($value as $key2 => $value2) {
					$cityOptions.= "<option value='$value2'>$value2</option>";				
				}
			}*/
			$cityLists = json_encode($cityLists);
			if(!empty($cityLists)) {
				return $cityLists;
			}else {
				return '未获取到城市列表';
			}
			
		}
		
		//getCityList();
		/**
		 * 检测从前端的请求类型，选择适当的方法相应
		 */
		function selectAction(){
			if(isset($_POST['action']) || isset($_GET['action'])){
				if(isset($_GET['action']) && $_GET['action']=="chkUsername"){
					return $this->chkUsername();
				}
				else if(isset($_GET['action']) && $_GET['action']=="chkEmail"){
					return $this->chkEmail();
				}
				else if(isset($_POST['action']) && $_POST['action']=="register"){
					return $this->register();
				}
				else if(isset($_GET['action']) && $_GET['action']=="getJobList"){
					return $this->getJobList();
				}
				else if(isset($_GET['action']) && $_GET['action']=="getProvinceList"){
					return $this->getProvinceList();
				}
				else if(isset($_GET['action']) && $_GET['action']=="getCityList"){
					return $this->getCityList();
				}
				else{
					return "请求动作不正确";
				}
			}		
			else{
				return "没有使用请求动作";
			}
		}
	}
	
	$registerController=new RegisterController();
	echo $registerController->selectAction();
?>