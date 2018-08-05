<?php
	require_once(__DIR__.'/../Model/User.php');
	require_once(__DIR__.'/../Model/TopicManager.php');
	class SelfTopicController{
		private $user;
		private $topicManager;
		
		public function __construct(){
			$this->user=new User();
			$this->topicManager=new TopicManager();
		}
				
		
		public function createNewTopic(){
			$topicType=$_REQUEST['topicType'];
			$topicContent=$_REQUEST['topicContent'];
			$topicDescription=$_REQUEST['topicDescription'];
			return $this->user->createNewTopic($topicType, $topicContent, $topicDescription);
		}
		
		public function getSelfTopicList(){
			$page=$_REQUEST['page'];
			$count=$this->user->getSelfTopicCount();
			$topics=$this->user->getSelfTopicList($page);
			$resultArr=array("topics"=>$topics,"count"=>$count);
			return json_encode($resultArr);
		}
		
		
		public function searchTopicListByContentOrDescription(){
			$keyword=$_REQUEST['keyword'];
			$page=$_REQUEST['page'];
			$count=$this->user->getTopicListByContentOrDescriptionCount($keyword);
			$topics=$this->user->getTopicListByContentOrDescription($keyword,$page);
			$resultArr=array("topics"=>$topics,"count"=>$count);
			return json_encode($resultArr);
			return $topicList;
		}
		
		public function disableSelfTopic(){
			$topicId=$_REQUEST['topicId'];
			$affectRow=$this->user->disableSelfTopic($topicId);
			$resultArr=array("affectRow"=>$affectRow);
			$result=json_encode($resultArr);
			return $result;
		}
		
		public function enableSelfTopic(){
			$topicId=$_REQUEST['topicId'];
			$affectRow=$this->user->enableSelfTopic($topicId);
			$resultArr=array("affectRow"=>$affectRow);
			$result=json_encode($resultArr);
			return $result;
		}
		//删除自己的话题
		public function deleteSelfTopic(){
			$topicId=$_REQUEST['topicId'];
			$affectRow=$this->user->deleteSelfTopic($topicId);
			$resultArr=array("deleteRow"=>$affectRow);
			$result=json_encode($resultArr);
			return $result;
		}
		
		
		/**
		 * 加载所有话题类型
		 */
		public function loadTopicTypes(){
			$resultArr=array("types"=>$this->user->loadTopicTypes());
			return json_encode($resultArr);
		}
		
		public function selectAction(){
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="createNewTopic"){
				return $this->createNewTopic();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="getSelfTopicList"){
				return $this->getSelfTopicList();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="searchTopicListByContentOrDescription"){
				return $this->searchTopicListByContentOrDescription();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="disableSelfTopic"){
				return $this->disableSelfTopic();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="enableSelfTopic"){
				return $this->enableSelfTopic();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="deleteSelfTopic"){
				return $this->deleteSelfTopic();
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action']=="loadTopicTypes"){
				return $this->loadTopicTypes();
			}
		}
	}
	
	$SelfTopicController=new SelfTopicController();
	echo $SelfTopicController->selectAction();
	//echo $SelfTopicController->replyComment();
?>