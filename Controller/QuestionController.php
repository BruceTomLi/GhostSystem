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
			$isUserLogon=$this->user->isUserLogon()?1:0;
			$resultArr=array("isUserLogon"=>$isUserLogon);
			return json_encode($resultArr);
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
		
		public function disableSelfQuestion(){
			$questionId=$_REQUEST['questionId'];
			$affectRow=$this->user->disableSelfQuestion($questionId);
			$resultArr=array("affectRow"=>$affectRow);
			$result=json_encode($resultArr);
			return $result;
		}
		
		public function enableSelfQuestion(){
			$questionId=$_REQUEST['questionId'];
			$affectRow=$this->user->enableSelfQuestion($questionId);
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
			//获取用户是否关注了该问题
			$hasUserFollowedQuestion=$this->user->hasUserFollowed($questionId);
			$commentCount=count($questionComments);
			$resultArr=array("questionDetails"=>$questionDetails,"questionComments"=>$questionComments,
				"hasUserFollowedQuestion"=>$hasUserFollowedQuestion,"commentCount"=>$commentCount);
			$result=json_encode($resultArr);
			return $result;
		}
		
		/**
		 * 下面的方法用来让用户提交一个问题
		 */
		public function commentQuestion(){
			$questionId=$_REQUEST['questionId'];
			$content=$_REQUEST['content'];
			$result="";
			if($this->user->isUserLogon()){
				$resultArr=$this->user->commentQuestion($questionId, $content);
				$resultArr["isLogon"]="true";
				$result=json_encode($resultArr);
			}
			else{
				$resultArr=array("isLogon"=>"false");
				$result=json_encode($resultArr);
			}
			
			return $result;
		}
		
		/**
		 * 下面删除一条评论信息
		 */
		public function disableCommentForQuestion(){
			$commentId=$_REQUEST['commentId'];
			$resultArr=array("affectRow"=>$this->user->disableCommentForQuestion($commentId));
			$result=json_encode($resultArr);
			return $result;
		}
		
		/**
		 * 获取评论的回复信息
		 */
		public function getReplysForComment(){
			$commentId=$_REQUEST['commentId'];
			$logonUser="";
			if($this->user->isUserLogon()){
				$logonUser=$this->user->getLogonUsername();
			}
			$resultArr=array("logonUser"=>$logonUser,"replys"=>$this->user->getReplysForComment($commentId));
			$result=json_encode($resultArr);
			return $result;
		}
		
		/**
		 * 回复一条评论
		 */
		public function replyComment(){			
			$commentId=$_REQUEST['commentId']??"";
			$fatherReplyId=$_REQUEST['fatherReplyId']??"";
			$content=$_REQUEST['content']??"";
			$result="";
			if($this->user->isUserLogon()){
				//由于需要在回复评论之后加载出评论者和评论的内容，所以在下面获取评论者信息
				$result=$this->user->createReplyForComment($fatherReplyId,$commentId, $content);
				$result["isLogon"]="true";
				$result=json_encode($result);
			}
			else{
				$result=array("isLogon"=>"false");
				$result=json_encode($result);
			}			
			return $result;
		}
		/**
		 * 回复一条回复
		 */
		public function replyReply(){
			$commentId=$_REQUEST['commentId'];
			$fatherReplyId=$_REQUEST['fatherReplyId'];
			$content=$_REQUEST['content'];
			$result="";
			if($this->user->isUserLogon()){
				//由于需要在回复评论之后加载出评论者和评论的内容，所以在下面获取评论者信息
				$result=$this->user->createReplyForReply($fatherReplyId,$commentId, $content);
				$result["isLogon"]="true";
				$result=json_encode($result);
			}
			else{
				$result=array("isLogon"=>"false");
				$result=json_encode($result);
			}			
			return $result;
		}
		
		/**
		 * 删除一条对评论的回复
		 */
		public function disableReplyForComment(){
			$replyId=$_REQUEST['replyId'];
			$result=array("disableRow"=>$this->user->disableReplyForComment($replyId));
			$result=json_encode($result);
			return $result;
		}
		
		/**
		 * 删除一条对回复的回复
		 */
		public function disableReplyForReply(){
			$replyId=$_REQUEST['replyId'];
			$result=array("disableRow"=>$this->user->disableReplyForReply($replyId));
			$result=json_encode($result);
			return $result;
		}
		
		/**
		 * 用户关注一个问题
		 */
		public function addFollow(){
			$starId=$_REQUEST['starId'];
			$followType=$_REQUEST['followType']??"unknown";
			$affectRow=$this->user->addFollow($starId,$followType);
			$resultArr=array("affectRow"=>$affectRow);
			$result=json_encode($resultArr);
			return $result;
		}
		
		/**
		 * 用户取消关注一个问题
		 */
		public function deleteFollow(){
			$starId=$_REQUEST['starId'];
			$affectRow=$this->user->deleteFollow($starId);
			$resultArr=array("affectRow"=>$affectRow);
			$result=json_encode($resultArr);
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
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="disableSelfQuestion"){
				return $this->disableSelfQuestion();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="enableSelfQuestion"){
				return $this->enableSelfQuestion();
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
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="disableCommentForQuestion"){
				return $this->disableCommentForQuestion();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="getReplysForComment"){
				return $this->getReplysForComment();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="replyComment"){
				return $this->replyComment();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="replyReply"){
				return $this->replyReply();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="disableReplyForComment"){
				return $this->disableReplyForComment();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="disableReplyForReply"){
				return $this->disableReplyForReply();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="addFollow"){
				return $this->addFollow();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="deleteFollow"){
				return $this->deleteFollow();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="isUserLogon"){
				return $this->isUserLogon();
			}
		}
	}
	
	$questionController=new QuestionController();
	echo $questionController->selectAction();
	//echo $questionController->replyComment();
?>