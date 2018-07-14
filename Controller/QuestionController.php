<?php
	require_once(__DIR__.'/../Model/User.php');
	require_once(__DIR__.'/../Model/QuestionManager.php');
	class QuestionController{
		private $user;
		private $questionManager;
		
		public function __construct(){
			$this->user=new User();
			$this->questionManager=new QuestionManager();
		}
		
		public function isUserLogon(){
			return $this->user->isUserLogon()?1:0;
		}
		
		public function userLogonInfo(){
			return $this->user->getLogonUsername();
		}
		
		public function createNewQuestion(){
			$questionType=$_REQUEST['questionType'];
			$questionContent=$_REQUEST['questionContent'];
			$questionDescription=$_REQUEST['questionDescription'];
			return $this->user->createNewQuestion($questionType, $questionContent, $questionDescription);
		}
		
		public function getSelfQuestionList(){
			$questionList=json_encode($this->user->getSelfQuestionList());
			return $questionList;
		}
		
		public function getSelfQuestionDetails(){
			$questionId=$_REQUEST['questionId'];
			$questionDetails=json_encode($this->user->getQuestionDetailsByQuestionId($questionId));
			return $questionDetails;
		}
		
		public function searchQuestionListByContentOrDescription(){
			$keyword=$_REQUEST['keyword'];
			$questionList=json_encode($this->user->getQuestionListByContentOrDescription($keyword));
			return $questionList;
		}
		
		public function deleteSelfQuestion(){
			$questionId=$_REQUEST['questionId'];
			$affectRow=$this->user->deleteSelfQuestion($questionId);
			$resultArr=array("affectRow"=>$affectRow);
			$result=json_encode($resultArr);
			return $result;
		}
		
		public function getAllQuestion(){
			$result=json_encode($this->questionManager->getAllQuestionList());
			return $result;
		}
		/**
		 * 下面的方法和getSelfQuestionDetails()一样用来加载一个信息，
		 * 但是调用的是QuestionManager的方法而不是User的方法，不需要用户登录
		 */
		public function getQuestionDetails(){
			$questionId=$_REQUEST['questionId'];
			$result=json_encode($this->questionManager->getQuestionDetails($questionId));
			return $result;
		}
		
		public function selectAction(){
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="userLogonInfo"){
				return $this->userLogonInfo();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="createNewQuestion"){
				return $this->createNewQuestion();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="getSelfQuestionList"){
				return $this->getSelfQuestionList();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="getSelfQuestionDetails"){
				return $this->getSelfQuestionDetails();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="searchQuestionListByContentOrDescription"){
				return $this->searchQuestionListByContentOrDescription();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="deleteSelfQuestion"){
				return $this->deleteSelfQuestion();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="getAllQuestion"){
				return $this->getAllQuestion();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="getQuestionDetails"){
				return $this->getQuestionDetails();
			}
			return "没有发送合适的请求";
		}
	}
	
	$questionController=new QuestionController();
	echo $questionController->selectAction();
?>