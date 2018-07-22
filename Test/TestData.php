<?php
	/**
	 * 这个文件用来设置一些测试用的数据
	 * 因为测试时需要对数据库中的数据进行增删改查，可能导致测试进行完第一次之后就测试失败
	 */
	 
	define("UserName", "王五");
	define("Password","ww@123");
	define("UserEmail","wangwu@123.com");
	define("RepeatName","tomtom");
	define("RepeatEmail","fasdfa@qq.com");
	define("Province","湖北省");
	define("QuestionType","IT");
	define("QuestionContent","这是单元测试里面用来测试创建一个新的问题的测试内容");
	define("QuestionDescription","这里是问题描述，实际情况中可以填写超文本信息");
	define("QuestionId","5b4fe29fc28900.16360449");
	define("ExampleComment","这里测试给问题增加一条评论");
	define("CommentId","5b4fe52284d406.43129252");
	define("ReplyId","5b533f62a5b881.48909021");
	define("ReplyCommentContent","这里测试给一条评论添加一条回复");
	define("ReplyReplyContent","这里测试给一条回复添加一条回复");
	define("FatherReplyId","5b533f62a5b881.48909021");
	
	define("NewUserName","liyun");
	define("NewUserEmail","liyuntian@123.com");
	define("UserId","11");
	//此时还没有开发出话题的功能，所以给的是一个replyId，是为了测试用户关注话题
	define("TopicId","5b533f62a5b881.48909021");
?>