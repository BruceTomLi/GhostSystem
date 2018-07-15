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
			//需要获取问题详情，以及问题相关的评论
			$questionDetails=$this->questionManager->getQuestionDetails($questionId);
			$questionComments=$this->user->getCommentsForQuestion($questionId);
			$commentCount=count($questionComments);
			$resultArr=array("questionDetails"=>$questionDetails,"questionComments"=>$questionComments,"commentCount"=>$commentCount);
			$result=json_encode($resultArr);
			return $result;
		}
		
		/**
		 * 下面的方法用来让用户提交一个问题
		 */
		public function commentQuestion(){
			$questionId=$_REQUEST['questionId'];
			$content=$_REQUEST['content'];
			$resultArr=array("affectRow"=>$this->user->commentQuestion($questionId, $content));
			$result=json_encode($resultArr);
			return $result;
		}
		
		/**
		 * 下面删除一条评论信息
		 */
		public function deleteCommentForQuestion(){
			$commentId=$_REQUEST['commentId'];
			$resultArr=array("affectRow"=>$this->user->deleteCommentForQuestion($commentId));
			$result=json_encode($resultArr);
			return $result;
		}
		
		/**
		 * 获取评论的回复信息
		 */
		public function getReplysForComment(){
			$commentId=$_REQUEST['commentId'];
			$result=json_encode($this->user->getReplysForComment($commentId));
			return $result;
		}
		
		/**
		 * 回复一条评论
		 */
		public function replyComment(){
			$commentId=$_REQUEST['commentId'];
			$content=$_REQUEST['content'];
			$result=array("insertRow"=>$this->user->createReplysForComment($commentId, $content));
			$result=json_encode($result);
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
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="commentQuestion"){
				return $this->commentQuestion();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="deleteCommentForQuestion"){
				return $this->deleteCommentForQuestion();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="getReplysForComment"){
				return $this->getReplysForComment();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="replyComment"){
				return $this->replyComment();
			}
			return "没有发送合适的请求";
		}
	}
	
	$questionController=new QuestionController();
	echo $questionController->selectAction();
?>